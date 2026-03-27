<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use Illuminate\Support\Facades\Auth;

class ReconciliationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // طلبات واردة: الطرف الآخر طلب مني المصالحة
        $incoming = Atab::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->where('reconciliation_status', Atab::REC_REQUESTED)
            ->where('reconciliation_requested_by', '!=', $userId)
            ->with(['sender', 'receiver', 'reconciliationRequester',
                    'messages' => fn($q) => $q->oldest()->limit(1)])
            ->latest('reconciliation_requested_at')
            ->get();

        // طلبات صادرة: أنا من طلب المصالحة
        $outgoing = Atab::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->where('reconciliation_status', Atab::REC_REQUESTED)
            ->where('reconciliation_requested_by', $userId)
            ->with(['sender', 'receiver',
                    'messages' => fn($q) => $q->oldest()->limit(1)])
            ->latest('reconciliation_requested_at')
            ->get();

        // سجل المصالحات المكتملة
        $accepted = Atab::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->where('reconciliation_status', Atab::REC_ACCEPTED)
            ->with(['sender', 'receiver',
                    'messages' => fn($q) => $q->oldest()->limit(1)])
            ->latest('reconciliation_confirmed_at')
            ->take(10)
            ->get();

        return view('reconciliations.index', compact('incoming', 'outgoing', 'accepted'));
    }
}
