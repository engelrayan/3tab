<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PasswordResetOtp extends Model
{
    protected $table = 'password_resets_otp';

    protected $fillable = [
        'email',
        'otp_code',
        'attempts',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'attempts'   => 'integer',
    ];

    /** OTP has passed its 10-minute window */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /** Verify a plain-text OTP against the stored hash */
    public function verify(string $plainOtp): bool
    {
        return ! $this->isExpired()
            && $this->attempts < 5
            && Hash::check($plainOtp, $this->otp_code);
    }
}
