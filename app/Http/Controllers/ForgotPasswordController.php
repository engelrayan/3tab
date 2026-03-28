<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════════
    // STEP 1 — Send OTP
    // ══════════════════════════════════════════════════════════════════════════

    public function showSendOtp(): View
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', 'exists:users,email'],
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.exists'   => 'لا يوجد حساب مرتبط بهذا البريد الإلكتروني.',
        ]);

        $email = strtolower(trim($request->email));

        // ── Rate-limit: max 3 sends / 15 min per email ────────────────────────
        $limiterKey = 'otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($limiterKey, 3)) {
            $wait = RateLimiter::availableIn($limiterKey);
            return back()->withErrors([
                'email' => "تم تجاوز الحد المسموح. حاول مرة أخرى بعد {$wait} ثانية.",
            ])->withInput();
        }
        RateLimiter::hit($limiterKey, 900); // 15-minute window

        // ── Generate & store OTP ──────────────────────────────────────────────
        $otp = $this->generateAndStore($email);

        // ── Send mail ─────────────────────────────────────────────────────────
        try {
            Mail::to($email)->send(new OtpMail($otp));
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'تعذّر إرسال البريد الإلكتروني. تحقق من البريد وحاول مرة أخرى.',
            ])->withInput();
        }

        // ── Session: remember email + send timestamp (for resend cooldown) ────
        session([
            'otp_email'   => $email,
            'otp_sent_at' => now()->timestamp,
        ]);

        return redirect()->route('forgot.verify.show')
            ->with('status', "تم إرسال كود التحقق إلى {$email}");
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STEP 2 — Verify OTP
    // ══════════════════════════════════════════════════════════════════════════

    public function showVerify(): RedirectResponse|View
    {
        if (! session('otp_email')) {
            return redirect()->route('forgot.show')
                ->withErrors(['email' => 'ابدأ من هنا بإدخال بريدك الإلكتروني.']);
        }
        return view('auth.otp-verify');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'يرجى إدخال الكود.',
            'otp.digits'   => 'الكود يجب أن يكون 6 أرقام.',
        ]);

        $email = session('otp_email');
        if (! $email) {
            return redirect()->route('forgot.show')
                ->withErrors(['email' => 'انتهت الجلسة. أعد المحاولة من البداية.']);
        }

        // ── Rate-limit: max 5 wrong attempts / 10 min per email ───────────────
        $limiterKey = 'otp-verify:' . $email;
        if (RateLimiter::tooManyAttempts($limiterKey, 5)) {
            return redirect()->route('forgot.show')
                ->withErrors(['email' => 'تم تجاوز الحد المسموح من المحاولات. اطلب كوداً جديداً.']);
        }

        $record = PasswordResetOtp::where('email', $email)->latest()->first();

        // ── Record missing ────────────────────────────────────────────────────
        if (! $record) {
            return back()->withErrors(['otp' => 'لم يتم إرسال كود لهذا البريد. اطلب كوداً جديداً.']);
        }

        // ── Expired ───────────────────────────────────────────────────────────
        if ($record->isExpired()) {
            $record->delete();
            return redirect()->route('forgot.show')
                ->withErrors(['email' => 'انتهت صلاحية الكود. أدخل بريدك مرة أخرى لإرسال كود جديد.']);
        }

        // ── Wrong OTP ─────────────────────────────────────────────────────────
        if (! $record->verify($request->otp)) {
            RateLimiter::hit($limiterKey, 600);
            $record->increment('attempts');
            $remaining = max(0, 5 - RateLimiter::attempts($limiterKey));
            return back()->withErrors([
                'otp' => "الكود غير صحيح." . ($remaining > 0 ? " ({$remaining} محاولات متبقية)" : ''),
            ]);
        }

        // ── ✅ Correct — clean up & mark session as verified ──────────────────
        RateLimiter::clear($limiterKey);
        $record->delete();

        session()->forget(['otp_email', 'otp_sent_at']);
        session([
            'reset_email'    => $email,
            'reset_token'    => Str::uuid()->toString(),
            'reset_verified' => true,
        ]);

        return redirect()->route('forgot.reset.show');
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STEP 2b — Resend OTP (AJAX-friendly)
    // ══════════════════════════════════════════════════════════════════════════

    public function resendOtp(Request $request): RedirectResponse
    {
        $email = session('otp_email');
        if (! $email) {
            return redirect()->route('forgot.show')
                ->withErrors(['email' => 'انتهت الجلسة. أدخل بريدك مرة أخرى.']);
        }

        // ── Enforce 60-second cooldown via session timestamp ──────────────────
        $sentAt = session('otp_sent_at', 0);
        if (now()->timestamp - $sentAt < 60) {
            return back()->withErrors(['otp' => 'انتظر 60 ثانية قبل طلب كود جديد.']);
        }

        $limiterKey = 'otp-send:' . $email;
        if (RateLimiter::tooManyAttempts($limiterKey, 3)) {
            $wait = RateLimiter::availableIn($limiterKey);
            return back()->withErrors(['otp' => "تم تجاوز الحد المسموح. حاول بعد {$wait} ثانية."]);
        }
        RateLimiter::hit($limiterKey, 900);

        $otp = $this->generateAndStore($email);

        try {
            Mail::to($email)->send(new OtpMail($otp));
        } catch (\Throwable) {
            return back()->withErrors(['otp' => 'تعذّر إرسال البريد. حاول مرة أخرى.']);
        }

        session(['otp_sent_at' => now()->timestamp]);

        return back()->with('status', 'تم إرسال كود جديد إلى بريدك الإلكتروني ✅');
    }

    // ══════════════════════════════════════════════════════════════════════════
    // STEP 3 — Reset Password
    // ══════════════════════════════════════════════════════════════════════════

    public function showReset(): RedirectResponse|View
    {
        if (! session('reset_verified') || ! session('reset_email')) {
            return redirect()->route('forgot.show')
                ->withErrors(['email' => 'يجب التحقق من هويتك أولاً.']);
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        if (! session('reset_verified') || ! session('reset_email')) {
            return redirect()->route('forgot.show');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required'  => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min'       => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'كلمتا المرور غير متطابقتين.',
        ]);

        $email = session('reset_email');
        $user  = User::where('email', $email)->first();

        if (! $user) {
            session()->forget(['reset_email', 'reset_token', 'reset_verified']);
            return redirect()->route('forgot.show');
        }

        $user->update(['password' => Hash::make($request->password)]);

        // ── Purge verification session ────────────────────────────────────────
        session()->forget(['reset_email', 'reset_token', 'reset_verified']);

        return redirect()->route('login')
            ->with('status', 'تم تحديث كلمة المرور بنجاح 🎉 سجّل دخولك الآن.');
    }

    // ══════════════════════════════════════════════════════════════════════════
    // Private helpers
    // ══════════════════════════════════════════════════════════════════════════

    /** Generate a 6-digit OTP, hash it, and persist it (replacing any old record). */
    private function generateAndStore(string $email): string
    {
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::where('email', $email)->delete();

        PasswordResetOtp::create([
            'email'      => $email,
            'otp_code'   => Hash::make($otp),
            'attempts'   => 0,
            'expires_at' => now()->addMinutes(10),
        ]);

        return $otp;
    }
}
