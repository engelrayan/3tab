<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mood extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'emoji',
        'color',
        'hint_ar',
    ];

    public function userMoods(): HasMany
    {
        return $this->hasMany(UserMood::class);
    }

    /** عرض الـ mood كنص كامل */
    public function getLabelAttribute(): string
    {
        return "{$this->emoji} {$this->name_ar}";
    }
}
