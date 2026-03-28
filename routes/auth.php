<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

// ── Guest-only routes (login / register / forgot-password) ───────────────────
Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    // ── Forgot Password (OTP Flow) ────────────────────────────────────────────
    // Step 1: enter email & send OTP
    Route::get('/forgot-password',
        [ForgotPasswordController::class, 'showSendOtp'])->name('forgot.show');
    Route::post('/forgot-password/send-otp',
        [ForgotPasswordController::class, 'sendOtp'])->name('forgot.send')
        ->middleware('throttle:5,10');

    // Step 2: verify 6-digit OTP
    Route::get('/forgot-password/verify',
        [ForgotPasswordController::class, 'showVerify'])->name('forgot.verify.show');
    Route::post('/forgot-password/verify-otp',
        [ForgotPasswordController::class, 'verifyOtp'])->name('forgot.verify')
        ->middleware('throttle:10,10');

    // Step 2b: resend OTP
    Route::post('/forgot-password/resend',
        [ForgotPasswordController::class, 'resendOtp'])->name('forgot.resend')
        ->middleware('throttle:3,10');

    // Step 3: set new password
    Route::get('/forgot-password/reset',
        [ForgotPasswordController::class, 'showReset'])->name('forgot.reset.show');
    Route::post('/forgot-password/reset',
        [ForgotPasswordController::class, 'resetPassword'])->name('forgot.reset');
});

// ── Logout ───────────────────────────────────────────────────────────────────
Route::post('/logout', [LoginController::class, 'destroy'])
     ->middleware('auth')
     ->name('logout');
