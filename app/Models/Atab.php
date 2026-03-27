<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Atab extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id', 'is_anonymous', 'is_flagged',
        'is_one_time', 'opened_at',
        'status',
        'reconciliation_requested_by', 'reconciliation_status',
        'reconciliation_requested_at', 'reconciliation_confirmed_at',
        'token', 'guest_token',
        'views_count', 'claimed_at', 'expires_at', 'seen_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous'               => 'boolean',
            'is_flagged'                 => 'boolean',
            'is_one_time'                => 'boolean',
            'opened_at'                  => 'datetime',
            'claimed_at'                 => 'datetime',
            'expires_at'                 => 'datetime',
            'seen_at'                    => 'datetime',
            'reconciliation_requested_at'  => 'datetime',
            'reconciliation_confirmed_at'  => 'datetime',
        ];
    }

    const STATUS_PENDING    = 'pending';
    const STATUS_ACTIVE     = 'active';
    const STATUS_RECONCILED = 'reconciled';
    const STATUS_CLOSED     = 'closed';

    const REC_NONE      = 'none';
    const REC_REQUESTED = 'requested';
    const REC_ACCEPTED  = 'accepted';
    const REC_REJECTED  = 'rejected';

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function reconciliationRequester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reconciliation_requested_by');
    }
    public function messages(): HasMany
    {
        return $this->hasMany(AtabMessage::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(\App\Models\Report::class);
    }

    public function isReconciled(): bool  { return $this->status === self::STATUS_RECONCILED; }
    public function isPending(): bool     { return $this->status === self::STATUS_PENDING; }
    public function isLinkBased(): bool   { return $this->token !== null; }
    public function isGuestSent(): bool   { return $this->guest_token !== null; }
    public function isClaimed(): bool     { return $this->receiver_id !== null; }
    public function isExpired(): bool     { return $this->expires_at && $this->expires_at->isPast(); }
    public function isSeen(): bool        { return $this->seen_at !== null; }
    public function isOneTimeConsumed(): bool { return $this->is_one_time && $this->opened_at !== null; }

    // Reconciliation helpers
    public function hasReconciliationRequest(): bool
    {
        return $this->reconciliation_status === self::REC_REQUESTED;
    }
    public function isReconciliationAccepted(): bool
    {
        return $this->reconciliation_status === self::REC_ACCEPTED;
    }
    public function isReconciliationRejected(): bool
    {
        return $this->reconciliation_status === self::REC_REJECTED;
    }
    public function iRequestedReconciliation(int $userId): bool
    {
        return $this->reconciliation_status === self::REC_REQUESTED
            && $this->reconciliation_requested_by === $userId;
    }
    public function otherPartyRequestedReconciliation(int $userId): bool
    {
        return $this->reconciliation_status === self::REC_REQUESTED
            && $this->reconciliation_requested_by !== null
            && $this->reconciliation_requested_by !== $userId;
    }

    // Legacy helpers (kept for backward compatibility)
    public function reconciliationRequestedBy(User $user): bool
    {
        return $this->reconciliation_requested_by === $user->id;
    }
    public function awaitingReconciliationFrom(User $user): bool
    {
        return $this->hasReconciliationRequest()
            && $this->reconciliation_requested_by !== $user->id;
    }
    public function getSenderNameAttribute(): string
    {
        if ($this->is_anonymous) return 'مجهول';
        return $this->sender?->name ?? 'مجهول';
    }

    public static function generateUniqueToken(): string
    {
        do { $token = Str::random(32); }
        while (self::where('token', $token)->exists());
        return $token;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
