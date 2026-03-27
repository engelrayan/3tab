<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtabMessage extends Model
{
    protected $fillable = [
        'atab_id',
        'sender_id',
        'body',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function atab(): BelongsTo
    {
        return $this->belongsTo(Atab::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // ── Helpers ────────────────────────────────────────────────

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function markAsRead(): void
    {
        if (! $this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    /** هل الرسالة من المستخدم الحالي؟ */
    public function isFromUser(User $user): bool
    {
        return $this->sender_id === $user->id;
    }
}
