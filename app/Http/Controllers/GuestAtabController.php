<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use App\Models\Mood;
use App\Models\User;
use App\Models\UserMood;
use App\Services\ModerationService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuestAtabController extends Controller
{
    /**
     * إرسال عتاب لمستخدم — يعمل مع وبدون تسجيل دخول
     */
    public function store(Request $request, string $username)
    {
        $receiver = User::where('username', $username)->firstOrFail();

        $request->validate([
            'body'         => ['required', 'string', 'min:3', 'max:500'],
            'is_anonymous' => ['nullable', 'boolean'],
        ], [
            'body.required' => 'اكتب رسالة العتاب',
            'body.min'      => 'الرسالة قصيرة جداً (٣ أحرف على الأقل)',
            'body.max'      => 'الرسالة طويلة جداً (٥٠٠ حرف كحد أقصى)',
        ]);

        // ── Safety mode: guests not allowed ───────────────────────────────
        if (!Auth::check() && !$receiver->acceptsGuestMessages()) {
            return response()->json([
                'success' => false,
                'message' => '🔒 هذا المستخدم يقبل الرسائل من المسجّلين فقط',
            ], 403);
        }

        $isAnonymous = $request->boolean('is_anonymous', true);

        if (Auth::check()) {
            if (Auth::id() === $receiver->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكنك إرسال عتاب لنفسك',
                ], 422);
            }
            $senderId   = Auth::id();
            $guestToken = null;

            // ── Check if receiver has ignored this sender ──────────────────
            if ($receiver->hasIgnored($senderId)) {
                // Silent accept — sender doesn't know they're ignored
                return response()->json([
                    'success'       => true,
                    'guest_token'   => null,
                    'is_anonymous'  => $isAnonymous,
                    'authenticated' => true,
                ]);
            }
        } else {
            $senderId   = null;
            $guestToken = Str::random(48);
        }

        // ── Moderation ────────────────────────────────────────────────────
        $body = ModerationService::clean($request->body);

        if (ModerationService::findBlockedWord($body)) {
            return response()->json([
                'success' => false,
                'message' => '🚫 الرسالة تحتوي على كلمات غير مسموح بها',
            ], 422);
        }

        if (ModerationService::isDuplicate($body, $request->ip())) {
            return response()->json([
                'success' => false,
                'message' => '🚫 لا تكرر نفس الرسالة',
            ], 422);
        }

        $isFlagged = ModerationService::isSuspicious($body);

        $atab = Atab::create([
            'sender_id'    => $senderId,
            'receiver_id'  => $receiver->id,
            'is_anonymous' => $isAnonymous,
            'is_flagged'   => $isFlagged,
            'status'       => Atab::STATUS_PENDING,
            'guest_token'  => $guestToken,
        ]);

        $atab->messages()->create([
            'sender_id' => $senderId,
            'body'      => $body,
        ]);

        // إشعار المستلم دائماً
        $atab->load('sender');
        NotificationService::notifyNewAtab($receiver, $atab);

        // تحديث مزاج المرسل تلقائياً إذا كان مسجّلاً
        if (Auth::check()) {
            $sadMood = Mood::where('name_en', 'sad')->first();
            if ($sadMood) {
                UserMood::updateOrCreate(
                    ['user_id' => Auth::id(), 'date' => today()],
                    ['mood_id' => $sadMood->id]
                );
            }
        }

        return response()->json([
            'success'       => true,
            'guest_token'   => $guestToken,   // null إذا كان مسجّلاً
            'is_anonymous'  => $isAnonymous,
            'authenticated' => Auth::check(),
        ]);
    }

    /**
     * ربط العتابات المُرسَلة كزائر بحساب المستخدم بعد التسجيل / الدخول
     * فقط إذا لم تكن مجهولة الهوية
     */
    public function linkGuestAtabs(Request $request)
    {
        $request->validate([
            'guest_token' => ['required', 'string', 'max:60'],
        ]);

        $updated = Atab::where('guest_token', $request->guest_token)
            ->where('is_anonymous', false)
            ->whereNull('sender_id')
            ->update([
                'sender_id'   => Auth::id(),
                'guest_token' => null,
            ]);

        return response()->json(['success' => true, 'linked' => $updated]);
    }

    /**
     * ربط guest_tokens متعددة بعد التسجيل (server-side helper)
     */
    public static function linkTokenForUser(string $guestToken, int $userId): void
    {
        Atab::where('guest_token', $guestToken)
            ->where('is_anonymous', false)
            ->whereNull('sender_id')
            ->update([
                'sender_id'   => $userId,
                'guest_token' => null,
            ]);
    }
}
