<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use App\Models\Mood;
use App\Models\UserMood;
use App\Services\MoodEngine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $receivedAtabs = Atab::where('receiver_id', $user->id)
            ->with(['sender', 'messages' => fn($q) => $q->oldest()->limit(1)])
            ->latest()->get();

        $sentAtabs = Atab::where('sender_id', $user->id)
            ->with(['receiver', 'messages' => fn($q) => $q->oldest()->limit(1)])
            ->latest()->get();

        $moods      = Mood::all();

        // الحالة النشطة (مش بس اليوم — مدتها 24 ساعة)
        $activeMood = $user->activeMood()->with('mood')->first();
        $todayMood  = $activeMood; // backward compat

        $moodEngine = MoodEngine::get($activeMood?->mood?->name_en);

        $journey = [
            'pending_received' => $receivedAtabs->where('status', 'pending')->count(),
            'pending_sent'     => $sentAtabs->where('status', 'pending')->count(),
            'active'           => $receivedAtabs->where('status', 'active')->count()
                                + $sentAtabs->where('status', 'active')->count(),
            'reconciled'       => $receivedAtabs->where('status', 'reconciled')->count(),
        ];

        $smartAlert = (new MoodController)->checkConsecutiveSadPublic();

        $pendingReconciliations = Atab::where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->where('reconciliation_status', Atab::REC_REQUESTED)
            ->where('reconciliation_requested_by', '!=', $user->id)
            ->with(['reconciliationRequester', 'sender', 'receiver'])
            ->latest('reconciliation_requested_at')
            ->get();

        // Analytics: رسائل وصلت لكل mood
        $moodAnalytics = UserMood::where('user_id', $user->id)
            ->with('mood')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->groupBy(fn($um) => $um->mood->name_en ?? 'unknown')
            ->map(fn($g) => [
                'mood'     => $g->first()->mood->name_ar,
                'emoji'    => $g->first()->mood->emoji,
                'days'     => $g->count(),
                'received' => Atab::where('receiver_id', $user->id)
                    ->whereIn(DB::raw('DATE(created_at)'), $g->pluck('date')->map(fn($d) => $d->format('Y-m-d')))
                    ->count(),
            ])->sortByDesc('received')->values()->take(5);

        // share text لـ dashboard
        $profileUrl = route('profile.show', $user->username);
        $shareText  = MoodEngine::shareText($activeMood?->mood?->name_en, $profileUrl);

        return view('dashboard', compact(
            'receivedAtabs', 'sentAtabs', 'moods',
            'todayMood', 'activeMood', 'moodEngine',
            'journey', 'smartAlert', 'pendingReconciliations',
            'moodAnalytics', 'profileUrl', 'shareText'
        ));
    }
}
