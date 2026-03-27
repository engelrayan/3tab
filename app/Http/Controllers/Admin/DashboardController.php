<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atab;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Core Stats ────────────────────────────────────────────────
        $stats = [
            'users'            => User::count(),
            'users_today'      => User::whereDate('created_at', today())->count(),
            'users_yesterday'  => User::whereDate('created_at', today()->subDay())->count(),
            'atabs'            => Atab::count(),
            'atabs_today'      => Atab::whereDate('created_at', today())->count(),
            'atabs_yesterday'  => Atab::whereDate('created_at', today()->subDay())->count(),
            'anonymous'        => Atab::where('is_anonymous', true)->count(),
            'reconciled'       => Atab::where('status', Atab::STATUS_RECONCILED)->count(),
            'flagged'          => Atab::where('is_flagged', true)->count(),
            'reports'          => Report::distinct('atab_id')->count('atab_id'),
            'reports_total'    => Report::count(),
            'reports_today'    => Report::whereDate('created_at', today())->count(),
            'reports_yesterday'=> Report::whereDate('created_at', today()->subDay())->count(),
            'blocked_users'    => User::where('is_blocked', true)->count(),
            'guests_today'     => Atab::whereNull('sender_id')->whereDate('created_at', today())->count(),
        ];

        // ── Priority Alerts ───────────────────────────────────────────
        $alerts = [
            'reports'  => $stats['reports'],
            'flagged'  => $stats['flagged'],
            'suspected'=> User::where('is_blocked', false)
                             ->whereHas('sentAtabs', fn($q) => $q->has('reports'))
                             ->count(),
        ];
        $alerts['total'] = $alerts['reports'] + $alerts['flagged'];

        // ── System Health ─────────────────────────────────────────────
        $healthScore = 100;
        if ($alerts['reports'] > 0)  $healthScore -= min(40, $alerts['reports'] * 8);
        if ($alerts['flagged'] > 0)  $healthScore -= min(30, $alerts['flagged'] * 5);
        if ($stats['blocked_users'] > 5) $healthScore -= 10;
        $healthScore = max(0, $healthScore);

        $health = match(true) {
            $healthScore >= 80 => ['label' => 'ممتاز',  'color' => '#4ade80', 'dot' => '🟢', 'class' => 'h-green'],
            $healthScore >= 50 => ['label' => 'متوسط',  'color' => '#fbbf24', 'dot' => '🟡', 'class' => 'h-yellow'],
            default            => ['label' => 'يحتاج مراجعة', 'color' => '#f87171', 'dot' => '🔴', 'class' => 'h-red'],
        };
        $health['score'] = $healthScore;

        // ── Activity Timeline ─────────────────────────────────────────
        $timeline = collect();

        User::latest()->take(5)->get()->each(function ($u) use (&$timeline) {
            $timeline->push([
                'type'  => 'user',
                'icon'  => '👤',
                'color' => '#5A8FC2',
                'text'  => "انضم {$u->name}",
                'sub'   => "@{$u->username}",
                'time'  => $u->created_at,
                'link'  => null,
                'urgent'=> false,
            ]);
        });

        Atab::with('receiver')->latest()->take(7)->get()->each(function ($a) use (&$timeline) {
            $timeline->push([
                'type'  => $a->is_flagged ? 'flag' : 'atab',
                'icon'  => $a->is_flagged ? '🚩' : '💬',
                'color' => $a->is_flagged ? '#fbbf24' : '#C6924A',
                'text'  => $a->is_flagged ? 'عتاب مشبوه اكتُشف' : 'عتاب جديد',
                'sub'   => 'إلى ' . ($a->receiver?->name ?? 'مجهول'),
                'time'  => $a->created_at,
                'link'  => null,
                'urgent'=> $a->is_flagged,
            ]);
        });

        Report::with('atab')->latest()->take(5)->get()->each(function ($r) use (&$timeline) {
            if (!$r->atab) return;
            $timeline->push([
                'type'  => 'report',
                'icon'  => '🚨',
                'color' => '#ef4444',
                'text'  => 'بلاغ جديد',
                'sub'   => 'تم الإبلاغ عن رسالة',
                'time'  => $r->created_at,
                'link'  => route('admin.reports'),
                'urgent'=> true,
            ]);
        });

        Atab::where('reconciliation_status', 'requested')
            ->with('receiver')
            ->latest('reconciliation_requested_at')
            ->take(3)
            ->get()
            ->each(function ($a) use (&$timeline) {
                $timeline->push([
                    'type'  => 'reconciliation',
                    'icon'  => '🤝',
                    'color' => '#7A9E8E',
                    'text'  => 'طلب صلح',
                    'sub'   => $a->receiver?->name ?? '—',
                    'time'  => $a->reconciliation_requested_at ?? $a->updated_at,
                    'link'  => route('admin.reconciliations'),
                    'urgent'=> false,
                ]);
            });

        $timeline = $timeline->sortByDesc('time')->take(15)->values();

        // ── Activity Chart (7 days) ───────────────────────────────────
        $activity = DB::table('atabs')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // ── Recent Items ──────────────────────────────────────────────
        $recentReports = Atab::withCount('reports')
            ->whereHas('reports')
            ->with(['sender', 'receiver'])
            ->orderByDesc('reports_count')
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'stats', 'alerts', 'health', 'timeline', 'activity', 'recentReports', 'recentUsers'
        ));
    }
}
