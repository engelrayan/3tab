<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request, Atab $atab)
    {
        $ip = $request->ip();

        // ── Guard: one report per user or IP per atab ─────────────────────
        if (Auth::check()) {
            $already = Report::where('atab_id', $atab->id)
                ->where('reporter_user_id', Auth::id())
                ->exists();
        } else {
            $already = Report::where('atab_id', $atab->id)
                ->where('reporter_ip', $ip)
                ->whereNull('reporter_user_id')
                ->exists();
        }

        if ($already) {
            return response()->json([
                'success' => false,
                'message' => 'أبلغت عن هذه الرسالة من قبل',
            ], 422);
        }

        // ── Save report ────────────────────────────────────────────────────
        Report::create([
            'atab_id'          => $atab->id,
            'reporter_user_id' => Auth::id(),
            'reporter_ip'      => $ip,
            'reason'           => $request->input('reason'),
        ]);

        // ── Auto-flag when threshold reached ──────────────────────────────
        $threshold = config('abuse.report_flag_threshold', 3);
        $count     = Report::where('atab_id', $atab->id)->count();

        if ($count >= $threshold && !$atab->is_flagged) {
            $atab->update(['is_flagged' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الإبلاغ · شكراً على مساعدتك في الحفاظ على المجتمع',
        ]);
    }
}
