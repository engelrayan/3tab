<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ModerationService
{
    /**
     * Hard-block: returns the matched word or null if clean.
     */
    public static function findBlockedWord(string $body): ?string
    {
        $normalised = self::normalise($body);
        foreach (config('abuse.blocked_words', []) as $word) {
            if (str_contains($normalised, self::normalise($word))) {
                return $word;
            }
        }
        return null;
    }

    /**
     * Soft-flag: returns true if body contains suspicious (but not hard-blocked) words.
     */
    public static function isSuspicious(string $body): bool
    {
        $normalised = self::normalise($body);
        foreach (config('abuse.suspicious_words', []) as $word) {
            if (str_contains($normalised, self::normalise($word))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Duplicate guard: same body hash from same IP within the configured window.
     * Returns true if this IS a duplicate (should be rejected).
     */
    public static function isDuplicate(string $body, string $ip): bool
    {
        $key     = 'spam:' . $ip . ':' . md5(mb_strtolower(trim($body)));
        $window  = config('abuse.duplicate_window_seconds', 30);

        if (Cache::has($key)) {
            return true;
        }

        Cache::put($key, 1, $window);
        return false;
    }

    /**
     * Clean input: trim + collapse repeated characters (e.g. "هههههه" → "ههه").
     * Max 3 consecutive identical characters.
     */
    public static function clean(string $body): string
    {
        $body = trim($body);
        // Collapse 4+ identical chars down to 3
        $body = preg_replace('/(.)\1{3,}/u', '$1$1$1', $body);
        // Collapse excessive whitespace/newlines
        $body = preg_replace('/[ \t]{2,}/', ' ', $body);
        $body = preg_replace('/\n{3,}/', "\n\n", $body);
        return $body;
    }

    // ── private ──────────────────────────────────────────────────────────────

    /**
     * Normalise Arabic text for comparison:
     * - lowercase
     * - remove tashkeel (diacritics)
     * - unify alef variants
     */
    private static function normalise(string $text): string
    {
        // Remove Arabic tashkeel
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}]/u', '', $text);
        // Unify alef forms
        $text = str_replace(['أ','إ','آ','ٱ'], 'ا', $text);
        // Unify ta marbuta
        $text = str_replace('ة', 'ه', $text);
        // lowercase (Latin)
        return mb_strtolower($text);
    }
}
