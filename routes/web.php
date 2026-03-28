<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AtabController;
use App\Http\Controllers\AtabLinkController;
use App\Http\Controllers\GuestAtabController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReconciliationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\IgnoreController;
use App\Http\Controllers\SafetyController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

// ── Public ───────────────────────────────────────────────────────────────────
Route::get('/', fn() => view('welcome'))->name('home');

// رابط عتاب مشترك
Route::get('/a/{token}', [AtabLinkController::class, 'show'])->name('atab.link');

// إرسال عتاب من الصفحة الشخصية (زائر أو مسجّل) — مع rate limit للحماية
Route::post('/send/{username}', [GuestAtabController::class, 'store'])
    ->name('guest.atab.store')
    ->middleware('throttle:guest-atab');

// إبلاغ عن عتاب — عام (لا يشترط تسجيل دخول)
Route::post('/atab/{atab}/report', [ReportController::class, 'store'])
    ->name('atab.report')
    ->middleware('throttle:10,1');

// ── Auth required ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mood
    Route::post('/mood',            [MoodController::class, 'store'])->name('mood.store')->middleware('throttle:3,1');
    Route::get('/mood/history',     [MoodController::class, 'history'])->name('mood.history');
    Route::get('/mood/analytics',   [MoodController::class, 'analytics'])->name('mood.analytics');

    // Smart Share Message Generator
    Route::get('/share/message',    [ShareController::class, 'generate'])->name('share.message');

    // Atab — normal
    Route::post('/atab',                  [AtabController::class, 'store'])->name('atab.store')->middleware('throttle:5,1');
    Route::get('/atab/{atab}',            [AtabController::class, 'show'])->name('atab.show');
    Route::post('/atab/{atab}/reply',     [AtabController::class, 'reply'])->name('atab.reply')->middleware('throttle:10,1');
    Route::post('/atab/{atab}/reconcile', [AtabController::class, 'requestReconciliation'])->name('atab.reconcile');
    Route::post('/atab/{atab}/confirm',   [AtabController::class, 'confirmReconciliation'])->name('atab.confirm');
    Route::post('/atab/{atab}/reject',    [AtabController::class, 'rejectReconciliation'])->name('atab.reject');
    Route::post('/atab/{atab}/close',     [AtabController::class, 'close'])->name('atab.close');

    // Reconciliations page
    Route::get('/reconciliations', [ReconciliationController::class, 'index'])->name('reconciliations.index');

    // Notifications
    Route::get('/notifications',                        [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/fetch',                  [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::get('/notifications/unread-count',           [NotificationController::class, 'unreadCount'])->name('notifications.count');
    Route::post('/notifications/read-all',              [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::post('/notifications/{notification}/read',   [NotificationController::class, 'markRead'])->name('notifications.read');

    // Moderation
    Route::post('/atab/{atab}/ignore',    [IgnoreController::class, 'store'])->name('atab.ignore');
    Route::delete('/ignore/{userId}',     [IgnoreController::class, 'destroy'])->name('ignore.destroy');
    Route::post('/settings/safety',       [SafetyController::class, 'update'])->name('settings.safety');

    // Atab — link
    Route::post('/atab-link', [AtabLinkController::class, 'store'])->name('atab.link.store')->middleware('throttle:5,1');

    // ربط عتابات الزائر بالحساب بعد التسجيل
    Route::post('/link-guest-atabs', [GuestAtabController::class, 'linkGuestAtabs'])
        ->name('atab.link.guest');

});

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/',                                    [Admin\DashboardController::class,     'index'])->name('dashboard');

    // Users
    Route::get('/users',                               [Admin\UserController::class,          'index'])->name('users');
    Route::post('/users/{user}/block',                 [Admin\UserController::class,          'block'])->name('users.block');
    Route::post('/users/{user}/unblock',               [Admin\UserController::class,          'unblock'])->name('users.unblock');
    Route::post('/users/{user}/make-admin',            [Admin\UserController::class,          'makeAdmin'])->name('users.make-admin');
    Route::post('/users/{user}/revoke-admin',          [Admin\UserController::class,          'revokeAdmin'])->name('users.revoke-admin');
    Route::post('/users/{user}/warn',                  [Admin\UserController::class,          'warn'])->name('users.warn');

    // Atabs
    Route::get('/atabs',                               [Admin\AtabManageController::class,    'index'])->name('atabs');
    Route::delete('/atabs/{atab}',                     [Admin\AtabManageController::class,    'destroy'])->name('atabs.destroy');
    Route::post('/atabs/{atab}/flag',                  [Admin\AtabManageController::class,    'flag'])->name('atabs.flag');
    Route::post('/atabs/{atab}/unflag',                [Admin\AtabManageController::class,    'unflag'])->name('atabs.unflag');

    // Reports
    Route::get('/reports',                             [Admin\ReportManageController::class,  'index'])->name('reports');
    Route::delete('/reports/{atab}/delete-atab',       [Admin\ReportManageController::class,  'deleteAtab'])->name('reports.delete-atab');
    Route::delete('/reports/{atab}/dismiss',           [Admin\ReportManageController::class,  'dismiss'])->name('reports.dismiss');
    Route::post('/reports/{atab}/block-sender',        [Admin\ReportManageController::class,  'blockSender'])->name('reports.block-sender');

    // Reconciliations
    Route::get('/reconciliations',                     [Admin\ReconciliationController::class,'index'])->name('reconciliations');

    // Analytics
    Route::get('/analytics',                           [Admin\AnalyticsController::class,     'index'])->name('analytics');

    // Moderation
    Route::get('/moderation',                          [Admin\ModerationController::class,    'index'])->name('moderation');
    Route::post('/moderation/words',                   [Admin\ModerationController::class,    'addWord'])->name('moderation.words.add');
    Route::delete('/moderation/words',                 [Admin\ModerationController::class,    'removeWord'])->name('moderation.words.remove');
    Route::post('/moderation/unflag/{atab}',           [Admin\ModerationController::class,    'unflag'])->name('moderation.unflag');
    Route::delete('/moderation/atabs/{atab}',          [Admin\ModerationController::class,    'destroyFlagged'])->name('moderation.atabs.destroy');

    // Settings
    Route::get('/settings',                            [Admin\SettingsController::class,      'index'])->name('settings');
    Route::post('/settings',                           [Admin\SettingsController::class,      'update'])->name('settings.update');
});

// ── Auth routes ───────────────────────────────────────────────────────────────
require __DIR__.'/auth.php';

// صفحة البروفايل — في الآخر لأنها تمسك أي username
Route::get('/{username}', [ProfileController::class, 'show'])->name('profile.show');
