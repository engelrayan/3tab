<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Atab;
use App\Models\UserMood;

#[Fillable(['name', 'email', 'password', 'username', 'bio', 'mood', 'allow_anonymous', 'send_permission', 'is_admin', 'is_blocked', 'blocked_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function sentAtabs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Atab::class, 'sender_id');
    }

    public function receivedAtabs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Atab::class, 'receiver_id');
    }

    public function moods(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserMood::class);
    }

    // حالة المزاج اليوم
    public function todayMood(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserMood::class)
                    ->whereDate('date', today())
                    ->latest();
    }

// المستخدمون الذين تجاهلهم هذا المستخدم
public function ignoredUsers(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(\App\Models\IgnoredUser::class, 'user_id');
}

// هل يقبل هذا المستخدم رسائل من الزوار؟
public function acceptsGuestMessages(): bool
{
    return ($this->send_permission ?? 'everyone') === 'everyone';
}

// هل تجاهل هذا المستخدم شخصاً معيناً؟
public function hasIgnored(int $userId): bool
{
    return $this->ignoredUsers()->where('ignored_user_id', $userId)->exists();
}

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'blocked_at'        => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'is_blocked'        => 'boolean',
        ];
    }
}
