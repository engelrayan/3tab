<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SafetyController extends Controller
{
    /**
     * Update the send_permission setting for the authenticated user.
     */
    public function update(Request $request)
    {
        $request->validate([
            'send_permission' => ['required', 'in:everyone,registered'],
        ]);

        Auth::user()->update([
            'send_permission' => $request->send_permission,
        ]);

        return response()->json([
            'success'    => true,
            'permission' => $request->send_permission,
            'message'    => $request->send_permission === 'registered'
                ? '🔒 الآن فقط المستخدمون المسجّلون يمكنهم إرسال عتاب'
                : '🌍 الجميع يمكنهم إرسال عتاب',
        ]);
    }
}
