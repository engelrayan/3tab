<?php

namespace App\Services;

/**
 * Smart Share Message Generator
 *
 * Generates dynamic, human-friendly Arabic share messages based on
 * the user's emotional state. Tracks per-user history in session to
 * avoid repeating the same message in consecutive requests.
 */
class ShareMessageService
{
    /** How many recent messages to remember (avoid repeating them) */
    private const HISTORY_SIZE = 3;

    /**
     * Generate a randomised share message for a given mood.
     *
     * @param string      $username      Used as part of the session key
     * @param string      $profileUrl    Replaces {link} in templates
     * @param string      $mood          Mood key: happy|calm|sad|angry|anxious|neutral
     * @param string|null $customMessage Optional personal note (replaces {custom})
     */
    public static function generate(
        string  $username,
        string  $profileUrl,
        string  $mood = 'neutral',
        ?string $customMessage = null
    ): string {
        // ── Load templates ────────────────────────────────────────────
        $moodConfig = config("share_messages.{$mood}")
                   ?? config('share_messages.neutral');

        $hasCustom = trim($customMessage ?? '') !== '';
        $templates = ($hasCustom && !empty($moodConfig['custom_templates']))
            ? $moodConfig['custom_templates']
            : $moodConfig['templates'];

        // ── Anti-repetition via session ───────────────────────────────
        $sessionKey = "ssg_{$username}_{$mood}" . ($hasCustom ? '_c' : '');
        /** @var int[] $history */
        $history    = session($sessionKey, []);

        $allIndices = range(0, count($templates) - 1);
        $available  = array_values(
            array_filter($allIndices, fn ($i) => ! in_array($i, $history, true))
        );

        // Reset history when all options exhausted
        if (empty($available)) {
            $history   = [];
            $available = $allIndices;
        }

        $chosen = $available[array_rand($available)];

        // Persist updated history
        $history[] = $chosen;
        if (count($history) > self::HISTORY_SIZE) {
            array_shift($history);
        }
        session([$sessionKey => $history]);

        // ── Build message ─────────────────────────────────────────────
        $message = $templates[$chosen];
        $message = str_replace('{link}', $profileUrl, $message);

        if ($hasCustom) {
            $message = str_replace('{custom}', trim($customMessage), $message);
        }

        return $message;
    }
}
