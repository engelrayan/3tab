<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atab;
use Illuminate\Http\Request;

class AtabManageController extends Controller
{
    public function index(Request $request)
    {
        $q = Atab::with(['sender', 'receiver'])
            ->withCount('reports');

        if ($search = $request->input('q')) {
            $q->whereHas('messages', fn($m) => $m->where('body', 'like', "%{$search}%"));
        }

        if ($request->input('filter') === 'flagged') {
            $q->where('is_flagged', true);
        } elseif ($request->input('filter') === 'reported') {
            $q->whereHas('reports');
        } elseif ($request->input('filter') === 'anonymous') {
            $q->where('is_anonymous', true);
        }

        $atabs = $q->latest()->paginate(20)->withQueryString();

        return view('admin.atabs.index', compact('atabs'));
    }

    public function destroy(Atab $atab)
    {
        $atab->delete();
        return response()->json(['success' => true, 'message' => 'تم حذف العتاب']);
    }

    public function flag(Atab $atab)
    {
        $atab->update(['is_flagged' => true]);
        return response()->json(['success' => true]);
    }

    public function unflag(Atab $atab)
    {
        $atab->update(['is_flagged' => false]);
        return response()->json(['success' => true]);
    }
}
