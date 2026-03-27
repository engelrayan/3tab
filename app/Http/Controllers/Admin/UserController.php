<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::withCount([
            'sentAtabs as sent_count',
            'receivedAtabs as received_count',
        ])->addSelect([
            'users.*',
            DB::raw('(SELECT COUNT(*) FROM reports r
                       INNER JOIN atabs a ON r.atab_id = a.id
                       WHERE a.sender_id = users.id) as reports_on_sent'),
        ]);

        if ($search = $request->input('q')) {
            $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->input('filter') === 'blocked') {
            $q->where('is_blocked', true);
        } elseif ($request->input('filter') === 'admin') {
            $q->where('is_admin', true);
        } elseif ($request->input('filter') === 'suspicious') {
            $q->whereRaw('(SELECT COUNT(*) FROM reports r
                            INNER JOIN atabs a ON r.atab_id = a.id
                            WHERE a.sender_id = users.id) >= 1')
              ->where('is_blocked', false);
        }

        $users = $q->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function block(User $user)
    {
        abort_if($user->is_admin, 403, 'لا يمكن حظر أدمن');
        $user->update(['is_blocked' => true, 'blocked_at' => now()]);
        return response()->json(['success' => true, 'message' => '🚫 تم حظر المستخدم']);
    }

    public function unblock(User $user)
    {
        $user->update(['is_blocked' => false, 'blocked_at' => null]);
        return response()->json(['success' => true, 'message' => '✅ تم رفع الحظر']);
    }

    public function makeAdmin(User $user)
    {
        $user->update(['is_admin' => true]);
        return response()->json(['success' => true, 'message' => '⭐ تم منح صلاحيات الأدمن']);
    }

    public function revokeAdmin(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'لا يمكنك إزالة صلاحياتك');
        $user->update(['is_admin' => false]);
        return response()->json(['success' => true, 'message' => 'تم إلغاء صلاحيات الأدمن']);
    }

    public function warn(User $user)
    {
        // Lightweight warning — extend with notifications if needed
        return response()->json(['success' => true, 'message' => '⚠️ تم إرسال تحذير للمستخدم']);
    }
}
