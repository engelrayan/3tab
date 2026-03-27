<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'data', 'read_at'];

    protected function casts(): array
    {
        return [
            'data'    => 'array',
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function getMessage(): string
    {
        $name = $this->data['sender_name'] ?? 'شخص ما';

        return match ($this->type) {
            'new_atab'           => "وصلك عتاب جديد من {$name}",
            'reply'              => "{$name} رد على عتابك",
            'reconcile_request'  => "{$name} طلب منك الصلح",
            'reconcile_accepted' => "{$name} قبل طلب الصلح! رجعتم أصحاب 🤍",
            default              => 'إشعار جديد',
        };
    }

    public function getIcon(): string
    {
        return match ($this->type) {
            'new_atab'           => '📩',
            'reply'              => '💬',
            'reconcile_request'  => '🤝',
            'reconcile_accepted' => '🎉',
            default              => '🔔',
        };
    }

    public function getUrl(): string
    {
        $atabId = $this->data['atab_id'] ?? null;

        if (!$atabId) {
            return route('dashboard');
        }

        if ($this->type === 'reconcile_request') {
            return route('reconciliations.index');
        }

        return route('atab.show', $atabId);
    }
}
