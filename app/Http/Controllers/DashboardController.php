<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use App\Models\Mood;
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

        $moods     = Mood::all();
        $todayMood = $user->todayMood()->with('mood')->first();

        // Mood engine
        $moodEngine = MoodEngine::get($todayMood?->mood?->name_en);

        // Journey indicators
        $journey = [
            'pending_received' => $receivedAtabs->where('status', 'pending')->count(),
            'pending_sent'     => $sentAtabs->where('status', 'pending')->count(),
            'active'           => $receivedAtabs->where('status', 'active')->count()
                                + $sentAtabs->where('status', 'active')->count(),
            'reconciled'       => $receivedAtabs->where('status', 'reconciled')->count(),
        ];

        // Smart trigger: 3 consecutive sad days
        $smartAlert = (new MoodController)->checkConsecutiveSadPublic();

        // طلبات صلح واردة (الطرف الآخر طلب مني)
        $pendingReconciliations = Atab::where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->where('reconciliation_status', Atab::REC_REQUESTED)
            ->where('reconciliation_requested_by', '!=', $user->id)
            ->with(['reconciliationRequester', 'sender', 'receiver'])
            ->latest('reconciliation_requested_at')
            ->get();

        return view('dashboard', compact(
            'receivedAtabs', 'sentAtabs', 'moods',
            'todayMood', 'moodEngine', 'journey', 'smartAlert',
            'pendingReconciliations'
        ));
    }
}