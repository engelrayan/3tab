<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'allow_anonymous'     => SystemSetting::bool('allow_anonymous', true),
            'allow_guest_sending' => SystemSetting::bool('allow_guest_sending', true),
            'guest_rate_limit'    => SystemSetting::int('guest_rate_limit', 5),
            'auth_rate_limit'     => SystemSetting::int('auth_rate_limit', 20),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'allow_anonymous'     => ['boolean'],
            'allow_guest_sending' => ['boolean'],
            'guest_rate_limit'    => ['integer', 'min:1', 'max:100'],
            'auth_rate_limit'     => ['integer', 'min:1', 'max:200'],
        ]);

        SystemSetting::set('allow_anonymous',     $request->boolean('allow_anonymous')     ? '1' : '0');
        SystemSetting::set('allow_guest_sending', $request->boolean('allow_guest_sending') ? '1' : '0');
        SystemSetting::set('guest_rate_limit',    (string)$request->input('guest_rate_limit', 5));
        SystemSetting::set('auth_rate_limit',     (string)$request->input('auth_rate_limit', 20));

        return response()->json(['success' => true, 'message' => 'تم حفظ الإعدادات']);
    }
}
