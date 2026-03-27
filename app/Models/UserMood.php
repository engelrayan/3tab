<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class UserMood extends Model
{
    protected $fillable = [
        'user_id',
        'mood_id',
        'custom_message',
        'date',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'date'       => 'date',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mood(): BelongsTo
    {
        return $this->belongsTo(Mood::class);
    }

    /** الحالة لا تزال نشطة (لم تنتهِ) */
    public function isActive(): bool
    {
        return $this->expires_at === null || $this->expires_at->isFuture();
    }

    /** نطاق: الحالات النشطة فقط */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /** ثواني متبقية قبل الانتهاء */
    public function secondsRemaining(): int
    {
        if ($this->expires_at === null) return 86400;
        return max(0, (int) now()->diffInSeconds($this->expires_at, false));
    }
}
