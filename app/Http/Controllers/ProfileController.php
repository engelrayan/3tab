<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Atab;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $todayMood = $user->todayMood()->with('mood')->first();

        // إحصائيات
        $total      = Atab::where('receiver_id', $user->id)->count();
        $reconciled = Atab::where('receiver_id', $user->id)
                          ->where('status', Atab::STATUS_RECONCILED)
                          ->count();
        $anonymous  = Atab::where('receiver_id', $user->id)
                          ->where('is_anonymous', true)
                          ->count();
        $today      = Atab::where('receiver_id', $user->id)
                          ->whereDate('created_at', today())
                          ->count();

        $stats = [
            'total'          => $total,
            'reconciled'     => $reconciled,
            'anonymous_pct'  => $total > 0 ? round(($anonymous / $total) * 100) : 0,
            'today'          => $today,
        ];

        return view('profile.show', compact('user', 'todayMood', 'stats'));
    }
}
