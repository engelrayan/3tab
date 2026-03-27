<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMood extends Model
{
    protected $fillable = [
        'user_id',
        'mood_id',
        'custom_message',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
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
}
