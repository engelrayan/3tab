<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AtabLinkController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GuestAtabController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'البريد الإلكتروني مطلوب',
            'email.email'       => 'البريد الإلكتروني غير صحيح',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            // attach pending atab لو موجود في الـ session
            AtabLinkController::attachPendingAtab();

            // ربط عتابات الزائر بالحساب (إذا كان أرسل قبل الدخول)
            if ($request->filled('guest_token')) {
                GuestAtabController::linkTokenForUser($request->guest_token, Auth::id());
            }

            // لو كان عنده pending token → روّح للـ atab مباشرة
            if (session()->has('redirect_to_atab')) {
                $atabId = session()->pull('redirect_to_atab');
                return redirect()->route('atab.show', $atabId)
                                 ->with('success', 'تم إضافة العتاب لحسابك 🤍');
            }

            return redirect()->intended(route('dashboard'))
                             ->with('success', 'أهلاً بعودتك ' . Auth::user()->name . '! 🤍');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'البريد أو كلمة المرور غير صحيحة']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
