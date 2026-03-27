<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atab;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportManageController extends Controller
{
    public function index(Request $request)
    {
        $q = Atab::withCount('reports')
            ->whereHas('reports')
            ->with(['sender', 'receiver', 'reports' => fn($r) => $r->latest()->take(1)]);

        if ($request->input('filter') === 'high') {
            $q->having('reports_count', '>=', 3);
        }

        $atabs = $q->orderByDesc('reports_count')->paginate(20)->withQueryString();

        return view('admin.reports.index', compact('atabs'));
    }

    public function deleteAtab(Atab $atab)
    {
        $atab->delete();
        return response()->json(['success' => true, 'message' => 'تم حذف العتاب وكل البلاغات المرتبطة به']);
    }

    public function dismiss(Atab $atab)
    {
        $atab->reports()->delete();
        $atab->update(['is_flagged' => false]);
        return response()->json(['success' => true, 'message' => 'تم رفض البلاغ وإلغاء التحذير']);
    }

    public function blockSender(Atab $atab)
    {
        if ($atab->sender_id) {
            $atab->sender()->update(['is_blocked' => true, 'blocked_at' => now()]);
        }
        return response()->json(['success' => true, 'message' => 'تم حظر المرسل']);
    }
}
