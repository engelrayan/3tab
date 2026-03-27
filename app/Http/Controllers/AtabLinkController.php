<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtabLinkController extends Controller
{
    /**
     * إنشاء عتاب برابط قابل للمشاركة
     */
    public function store(Request $request)
    {
        $request->validate([
            'body'         => ['required', 'string', 'min:3', 'max:500'],
            'is_anonymous' => ['boolean'],
            'is_one_time'  => ['boolean'],
            'expires_days' => ['nullable', 'integer', 'min:1', 'max:30'],
        ], [
            'body.required' => 'اكتب رسالة العتاب',
            'body.min'      => 'الرسالة قصيرة جداً',
            'body.max'      => 'الرسالة طويلة جداً (500 حرف كحد أقصى)',
        ]);

        $atab = Atab::create([
            'sender_id'    => Auth::id(),
            'receiver_id'  => null,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_one_time'  => $request->boolean('is_one_time'),
            'status'       => Atab::STATUS_PENDING,
            'token'        => Atab::generateUniqueToken(),
            'expires_at'   => $request->expires_days
                              ? now()->addDays((int) $request->expires_days)
                              : null,
        ]);

        // حفظ الرسالة الأولى
        $atab->messages()->create([
            'sender_id' => Auth::id(),
            'body'      => $request->body,
        ]);

        return response()->json([
            'success' => true,
            'link'    => route('atab.link', $atab->token),
            'token'   => $atab->token,
        ]);
    }

    /**
     * عرض صفحة الرابط
     */
    public function show(string $token)
    {
        $atab = Atab::where('token', $token)
                    ->with(['sender', 'messages' => fn($q) => $q->oldest()->limit(1)])
                    ->first();

        // 404 لو مش موجود
        if (!$atab) {
            return view('atab.link-404');
        }

        // منتهي الصلاحية (expires_at)
        if ($atab->isExpired()) {
            return view('atab.link-expired', compact('atab'));
        }

        // ── One-Time logic ──────────────────────────────────────────────
        if ($atab->is_one_time) {
            $sessionKey = 'atab_ot_seen_' . $atab->id;

            // مستخدم مسجّل → يتجاوز القيد دائماً (يروّح للمحادثة)
            if (Auth::check()) {
                if (!$atab->isClaimed() && $atab->sender_id !== Auth::id()) {
                    $this->claimAtab($atab, Auth::user());
                    return redirect()->route('atab.show', $atab)
                                     ->with('success', 'تم إضافة العتاب لحسابك 🤍');
                }
                if ($atab->receiver_id === Auth::id() || $atab->sender_id === Auth::id()) {
                    return redirect()->route('atab.show', $atab);
                }
            }

            // ضيف: لو سبق عرضه (opened_at موجود) وما فيش session → expired
            if ($atab->opened_at !== null && !session()->has($sessionKey)) {
                return view('atab.link-one-time-expired', compact('atab'));
            }

            // أول مشاهدة: سجّل opened_at + ضع session key
            if ($atab->opened_at === null) {
                $atab->update(['opened_at' => now()]);
                session()->put($sessionKey, true);
            }

            // تسجيل مشاهدة
            $viewKey = 'atab_viewed_' . $atab->id;
            if (!session()->has($viewKey)) {
                $atab->incrementViews();
                session()->put($viewKey, true);
            }

            session()->put('pending_atab_token', $token);
            $firstMessage = $atab->messages->first();

            return view('atab.link', compact('atab', 'firstMessage'));
        }
        // ── End One-Time logic ───────────────────────────────────────────

        // تسجيل مشاهدة (مرة واحدة per session)
        $viewKey = 'atab_viewed_' . $atab->id;
        if (!session()->has($viewKey)) {
            $atab->incrementViews();
            session()->put($viewKey, true);
        }

        // لو المستخدم مسجّل دخول
        if (Auth::check()) {
            // لو مش مطالب به بعد → attach تلقائي
            if (!$atab->isClaimed()) {
                // لا تسمح للمرسل يطالب بعتابه
                if ($atab->sender_id !== Auth::id()) {
                    $this->claimAtab($atab, Auth::user());
                    return redirect()->route('atab.show', $atab)
                                     ->with('success', 'تم إضافة العتاب لحسابك 🤍');
                }
            } elseif ($atab->receiver_id === Auth::id() || $atab->sender_id === Auth::id()) {
                // صاحب العتاب أو المستلم → روّح للمحادثة
                return redirect()->route('atab.show', $atab);
            }
        }

        // حفظ الـ token في الـ session لما يسجّل بعدين
        session()->put('pending_atab_token', $token);

        $firstMessage = $atab->messages->first();

        return view('atab.link', compact('atab', 'firstMessage'));
    }

    /**
     * بعد login/register — attach الـ pending atab
     */
    public static function attachPendingAtab(): void
    {
        $token = session()->pull('pending_atab_token');
        if (!$token || !Auth::check()) return;

        $atab = Atab::where('token', $token)->first();
        if (!$atab || $atab->isClaimed() || $atab->isExpired()) return;

        // لا تسمح للمرسل يطالب بعتابه
        if ($atab->sender_id === Auth::id()) return;

        app(self::class)->claimAtab($atab, Auth::user());
    }

    /**
     * Claim: ربط العتاب بالمستخدم
     */
    protected function claimAtab(Atab $atab, $user): void
    {
        $atab->update([
            'receiver_id' => $user->id,
            'status'      => Atab::STATUS_ACTIVE,
            'claimed_at'  => now(),
        ]);
    }
}
