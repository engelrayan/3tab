<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AtabLinkController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GuestAtabController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:60'],
            'username' => ['required', 'string', 'max:30', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'avatar'   => ['nullable', 'image', 'max:2048'],
            'terms'    => ['accepted'],
        ], [
            'name.required'      => 'الاسم مطلوب',
            'username.required'  => 'اسم المستخدم مطلوب',
            'username.unique'    => 'اسم المستخدم مأخوذ، جرّب غيره',
            'username.regex'     => 'اسم المستخدم: حروف إنجليزية وأرقام وـ فقط',
            'email.required'     => 'البريد الإلكتروني مطلوب',
            'email.unique'       => 'البريد مسجّل مسبقاً',
            'password.required'  => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
            'password.min'       => 'كلمة المرور 8 أحرف على الأقل',
            'avatar.image'       => 'الصورة يجب أن تكون ملف صورة',
            'avatar.max'         => 'الصورة لا تتجاوز 2 ميجابايت',
            'terms.accepted'     => 'يجب الموافقة على الشروط والأحكام',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name'     => $request->name,
            'username' => strtolower($request->username),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'avatar'   => $avatarPath,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // attach pending atab لو موجود في الـ session
        AtabLinkController::attachPendingAtab();

        // ربط عتابات الزائر بالحساب الجديد (إذا أرسل قبل التسجيل)
        if ($request->filled('guest_token')) {
            GuestAtabController::linkTokenForUser($request->guest_token, $user->id);
        }

        if (session()->has('redirect_to_atab')) {
            $atabId = session()->pull('redirect_to_atab');
            return redirect()->route('atab.show', $atabId)
                             ->with('success', 'أهلاً ' . $user->name . '! تم إضافة العتاب لحسابك 🤍');
        }

        return redirect()->route('dashboard')
                         ->with('success', "أهلاً {$user->name}! 🤍 حسابك جاهز");
    }
}
