<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atab;
use Illuminate\Http\Request;

class ReconciliationController extends Controller
{
    public function index(Request $request)
    {
        $q = Atab::with(['sender', 'receiver', 'reconciliationRequester'])
            ->where(fn($q) => $q->where('reconciliation_status', '!=', 'none')->orWhere('status', Atab::STATUS_RECONCILED));

        if ($filter = $request->input('filter')) {
            if ($filter === 'requested') $q->where('reconciliation_status', Atab::REC_REQUESTED);
            if ($filter === 'accepted')  $q->where('reconciliation_status', Atab::REC_ACCEPTED);
            if ($filter === 'rejected')  $q->where('reconciliation_status', Atab::REC_REJECTED);
        }

        $atabs = $q->latest('reconciliation_requested_at')->paginate(20)->withQueryString();

        return view('admin.reconciliations.index', compact('atabs'));
    }
}
