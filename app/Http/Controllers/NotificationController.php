<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * جلب قائمة الإشعارات (JSON)
     */
    public function fetch()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'notifications' => $notifications->map(fn($n) => [
                'id'      => $n->id,
                'type'    => $n->type,
                'icon'    => $n->getIcon(),
                'message' => $n->getMessage(),
                'url'     => $n->getUrl(),
                'read'    => $n->isRead(),
                'time'    => $n->created_at->diffForHumans(),
            ]),
        ]);
    }

    /**
     * تعليم إشعار واحد كمقروء
     */
    public function markRead(Notification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);

        $notification->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'url'     => $notification->getUrl(),
        ]);
    }

    /**
     * تعليم كل الإشعارات كمقروءة
     */
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * صفحة الإشعارات الكاملة
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(50)
            ->get();

        $unreadCount = $notifications->whereNull('read_at')->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * عدد الإشعارات غير المقروءة
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }
}
