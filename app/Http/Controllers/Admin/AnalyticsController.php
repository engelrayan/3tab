<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atab;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $days = 30;

        // Users per day (last 30 days)
        $usersPerDay = DB::table('users')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Atabs per day
        $atabsPerDay = DB::table('atabs')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing dates
        $labels = [];
        $userData = [];
        $atabData = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $labels[]   = now()->subDays($i)->format('m/d');
            $userData[] = $usersPerDay[$d] ?? 0;
            $atabData[] = $atabsPerDay[$d] ?? 0;
        }

        // Anonymous vs named
        $anonCount  = Atab::where('is_anonymous', true)->count();
        $namedCount = Atab::where('is_anonymous', false)->count();

        // Status distribution
        $statusDist = Atab::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Guest vs auth
        $guestCount = Atab::whereNull('sender_id')->count();
        $authCount  = Atab::whereNotNull('sender_id')->count();

        // Top receivers
        $topReceivers = User::withCount('receivedAtabs as received_count')
            ->orderByDesc('received_count')
            ->take(5)
            ->get();

        // Conversion metric: users who registered and have linked atabs
        $totalUsers   = User::count();
        $activeUsers  = User::whereHas('receivedAtabs')->orWhereHas('sentAtabs')->count();

        return view('admin.analytics', compact(
            'labels', 'userData', 'atabData',
            'anonCount', 'namedCount',
            'statusDist',
            'guestCount', 'authCount',
            'topReceivers',
            'totalUsers', 'activeUsers'
        ));
    }
}
