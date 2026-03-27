<?php

namespace App\Services;

use App\Models\Atab;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * إشعار المستلم بعتاب جديد
     */
    public static function notifyNewAtab(User $receiver, Atab $atab): void
    {
        if ($atab->is_anonymous) {
            $senderName = 'مجهول الهوية';
        } elseif ($atab->sender) {
            $senderName = $atab->sender->name;
        } else {
            $senderName = 'زائر';
        }

        self::create($receiver->id, 'new_atab', [
            'atab_id'     => $atab->id,
            'sender_name' => $senderName,
        ]);
    }

    /**
     * إشعار الطرف الآخر بالرد
     */
    public static function notifyReply(Atab $atab, int $replierId): void
    {
        // من سيتلقى الإشعار؟ الطرف الآخر
        $recipientId = $replierId === $atab->sender_id
            ? $atab->receiver_id
            : $atab->sender_id;

        if (!$recipientId) return;

        $replier     = User::find($replierId);
        $senderName  = $atab->is_anonymous && $replierId === $atab->sender_id
            ? 'مجهول الهوية'
            : ($replier?->name ?? 'شخص ما');

        self::create($recipientId, 'reply', [
            'atab_id'     => $atab->id,
            'sender_name' => $senderName,
        ]);
    }

    /**
     * إشعار الطرف الآخر بطلب صلح
     */
    public static function notifyReconcileRequest(Atab $atab, int $requesterId): void
    {
        $recipientId = $requesterId === $atab->sender_id
            ? $atab->receiver_id
            : $atab->sender_id;

        if (!$recipientId) return;

        $requester = User::find($requesterId);

        self::create($recipientId, 'reconcile_request', [
            'atab_id'     => $atab->id,
            'sender_name' => $requester?->name ?? 'شخص ما',
        ]);
    }

    /**
     * إشعار صاحب الطلب بقبول الصلح
     */
    public static function notifyReconcileAccepted(Atab $atab, int $accepterId): void
    {
        $requesterId = $atab->reconciliation_requested_by;
        if (!$requesterId || $requesterId === $accepterId) return;

        $accepter = User::find($accepterId);

        self::create($requesterId, 'reconcile_accepted', [
            'atab_id'     => $atab->id,
            'sender_name' => $accepter?->name ?? 'شخص ما',
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────

    private static function create(int $userId, string $type, array $data): void
    {
        Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'data'    => $data,
        ]);
    }
}
