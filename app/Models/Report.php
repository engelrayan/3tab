<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'atab_id',
        'reporter_user_id',
        'reporter_ip',
        'reason',
    ];

    public function atab(): BelongsTo
    {
        return $this->belongsTo(Atab::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }
}
