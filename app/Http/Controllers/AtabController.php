<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use App\Models\Mood;
use App\Models\UserMood;
use App\Services\ModerationService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtabController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id'  => ['required', 'exists:users,id'],
            'body'         => ['required', 'string', 'min:3', 'max:500'],
            'is_anonymous' => ['boolean'],
        ]);

        abort_if($request->receiver_id == Auth::id(), 403, 'لا يمكنك إرسال عتاب لنفسك');

        // ── Moderation checks ─────────────────────────────────────────────
        $body = ModerationService::clean($request->body);

        if ($blocked = ModerationService::findBlockedWord($body)) {
            return back()->withErrors(['body' => '🚫 الرسالة تحتوي على كلمات غير مسموح بها'])->withInput();
        }

        if (ModerationService::isDuplicate($body, $request->ip())) {
            return back()->withErrors(['body' => '🚫 لا تكرر نفس الرسالة'])->withInput();
        }

        $isFlagged = ModerationService::isSuspicious($body);

        // ── Receiver's ignored-users list ─────────────────────────────────
        $receiver = \App\Models\User::findOrFail($request->receiver_id);
        if ($receiver->hasIgnored(Auth::id())) {
            // Silently accept but do nothing — sender doesn't know they're ignored
            return redirect()->route('dashboard')->with('success', 'خطوة كويسة 👏 التعبير بيريّح');
        }

        $atab = Atab::create([
            'sender_id'    => Auth::id(),
            'receiver_id'  => $request->receiver_id,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_flagged'   => $isFlagged,
            'status'       => Atab::STATUS_PENDING,
        ]);

        $atab->messages()->create([
            'sender_id' => Auth::id(),
            'body'      => $body,
        ]);

        // Auto-update sender mood to "sad" when sending atab
        $sadMood = Mood::where('name_en', 'sad')->first();
        if ($sadMood) {
            UserMood::updateOrCreate(
                ['user_id' => Auth::id(), 'date' => today()],
                ['mood_id' => $sadMood->id]
            );
        }

        // إشعار المستلم
        $atab->load('receiver');
        if ($atab->receiver) {
            NotificationService::notifyNewAtab($atab->receiver, $atab);
        }

        return redirect()->route('atab.show', $atab)
                         ->with('success', 'خطوة كويسة 👏 التعبير بيريّح');
    }

    public function show(Atab $atab)
    {
        abort_unless(
            in_array(Auth::id(), [$atab->sender_id, $atab->receiver_id]),
            403
        );

        $atab->load(['sender', 'receiver']);

        // تحديث الحالة عند فتح المستلم للعتاب
        if (Auth::id() === $atab->receiver_id) {
            // تسجيل أول مشاهدة
            if (!$atab->seen_at) {
                $atab->update(['seen_at' => now()]);
            }
            // تحريك الحالة من pending → active
            if ($atab->isPending()) {
                $atab->update(['status' => Atab::STATUS_ACTIVE]);
            }
        }

        // تحديث رسائل الطرف الآخر كـ "مقروءة"
        $atab->messages()
             ->where('sender_id', '!=', Auth::id())
             ->whereNull('read_at')
             ->update(['read_at' => now()]);

        $messages = $atab->messages()->with('sender')->oldest()->get();

        return view('atab.show', compact('atab', 'messages'));
    }

    public function close(Atab $atab)
    {
        abort_unless(in_array(Auth::id(), [$atab->sender_id, $atab->receiver_id]), 403);
        abort_if($atab->isReconciled(), 403, 'العتاب تمت مصالحته بالفعل');

        $atab->update(['status' => Atab::STATUS_CLOSED]);

        return back()->with('success', 'تم إغلاق العتاب');
    }

    public function reply(Request $request, Atab $atab)
    {
        abort_unless(in_array(Auth::id(), [$atab->sender_id, $atab->receiver_id]), 403);
        abort_if($atab->isReconciled(), 403, 'المحادثة تمت مصالحتها');

        $request->validate(['body' => ['required', 'string', 'min:1', 'max:500']]);

        $body = ModerationService::clean($request->body);

        if (ModerationService::findBlockedWord($body)) {
            return back()->withErrors(['body' => '🚫 الرسالة تحتوي على كلمات غير مسموح بها'])->withInput();
        }

        $atab->messages()->create(['sender_id' => Auth::id(), 'body' => $body]);

        if ($atab->isPending()) {
            $atab->update(['status' => Atab::STATUS_ACTIVE]);
        }

        // إشعار الطرف الآخر بالرد
        NotificationService::notifyReply($atab, Auth::id());

        return back()->with('success', 'خطوة كويسة 👏 التعبير بيريّح');
    }

    public function requestReconciliation(Atab $atab)
    {
        abort_unless(in_array(Auth::id(), [$atab->sender_id, $atab->receiver_id]), 403);
        abort_if($atab->isReconciled() || $atab->status === Atab::STATUS_CLOSED, 403);
        // Block if already pending from this user
        abort_if($atab->iRequestedReconciliation(Auth::id()), 403, 'أرسلت طلب مصالحة بالفعل');

        $atab->update([
            'reconciliation_status'       => Atab::REC_REQUESTED,
            'reconciliation_requested_by' => Auth::id(),
            'reconciliation_requested_at' => now(),
        ]);

        // إشعار الطرف الآخر بطلب الصلح
        NotificationService::notifyReconcileRequest($atab, Auth::id());

        return back()->with('success', 'تم إرسال طلب الصلح ❤️');
    }

    public function confirmReconciliation(Atab $atab)
    {
        abort_unless(in_array(Auth::id(), [$atab->sender_id, $atab->receiver_id]), 403);
        abort_unless($atab->hasReconciliationRequest(), 403, 'لا يوجد طلب مصالحة نشط');
        abort_if($atab->reconciliation_requested_by === Auth::id(), 403, 'أنت من طلب المصالحة');

        $atab->update([
            'reconciliation_status'      => Atab::REC_ACCEPTED,
            'reconciliation_confirmed_at' => now(),
            'status'                     => Atab::STATUS_RECONCILED,
        ]);

        // إشعار صاحب الطلب بقبول الصلح
        NotificationService::notifyReconcileAccepted($atab, Auth::id());

        // Update mood to happy on reconciliation for both parties
        $happyMood = Mood::where('name_en', 'happy')->first();
        if ($happyMood) {
            UserMood::updateOrCreate(
                ['user_id' => Auth::id(), 'date' => today()],
                ['mood_id' => $happyMood->id]
            );
        }

        return back()->with('success', '🎉 رجعتم أصحاب! حليب يا قشطة 🤍');
    }

    public function rejectReconciliation(Atab $atab)
    {
        abort_unless(in_array(Auth::id(), [$atab->sender_id, $atab->receiver_id]), 403);
        abort_unless($atab->hasReconciliationRequest(), 403, 'لا يوجد طلب مصالحة نشط');
        abort_if($atab->reconciliation_requested_by === Auth::id(), 403, 'لا يمكنك رفض طلبك');

        $atab->update(['reconciliation_status' => Atab::REC_REJECTED]);

        return back()->with('info', 'تمام… خد وقتك 😅');
    }
}