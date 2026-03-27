<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IgnoredUser extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'ignored_user_id'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ignoredUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ignored_user_id');
    }
}
