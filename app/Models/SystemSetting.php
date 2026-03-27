<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $primaryKey = 'key';
    public    $incrementing = false;
    protected $keyType      = 'string';
    protected $fillable     = ['key', 'value'];

    private const CACHE_PREFIX = 'setting:';
    private const CACHE_TTL    = 3600; // 1 hour

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember(self::CACHE_PREFIX . $key, self::CACHE_TTL, function () use ($key, $default) {
            $row = static::find($key);
            return $row ? $row->value : $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::CACHE_PREFIX . $key);
    }

    public static function bool(string $key, bool $default = true): bool
    {
        $v = static::get($key);
        return $v === null ? $default : (bool)(int)$v;
    }

    public static function int(string $key, int $default = 0): int
    {
        return (int)(static::get($key) ?? $default);
    }

    public static function jsonArray(string $key, array $default = []): array
    {
        $v = static::get($key);
        if (!$v) return $default;
        $decoded = json_decode($v, true);
        return is_array($decoded) ? $decoded : $default;
    }

    public static function setArray(string $key, array $value): void
    {
        static::set($key, json_encode($value, JSON_UNESCAPED_UNICODE));
    }
}
