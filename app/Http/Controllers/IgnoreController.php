<?php

namespace App\Http\Controllers;

use App\Models\Atab;
use App\Models\IgnoredUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IgnoreController extends Controller
{
    /**
     * Ignore the sender of a given atab.
     * Only allowed when the sender is known (not anonymous).
     */
    public function store(Atab $atab)
    {
        // Only the receiver can ignore the sender
        abort_unless(Auth::id() === $atab->receiver_id, 403);
        abort_if($atab->is_anonymous || !$atab->sender_id, 422, 'لا يمكن تجاهل مرسل مجهول');

        $senderId = $atab->sender_id;
        abort_if($senderId === Auth::id(), 422);

        IgnoredUser::firstOrCreate([
            'user_id'         => Auth::id(),
            'ignored_user_id' => $senderId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تجاهل هذا الشخص · لن تصلك رسائله مستقبلاً',
        ]);
    }

    /**
     * Remove a user from the ignore list.
     */
    public function destroy(int $ignoredUserId)
    {
        IgnoredUser::where('user_id', Auth::id())
            ->where('ignored_user_id', $ignoredUserId)
            ->delete();

        return response()->json(['success' => true]);
    }
}
