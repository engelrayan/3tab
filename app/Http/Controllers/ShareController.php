<?php

namespace App\Http\Controllers;

use App\Services\ShareMessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * GET /share/message
     *
     * Returns a randomised share message for the authenticated user.
     * Accepts optional query params:
     *   - mood           (string)  happy|calm|sad|angry|anxious|neutral
     *   - custom_message (string)  personal note to inject into the message
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'mood'           => 'nullable|string|max:20',
            'custom_message' => 'nullable|string|max:200',
        ]);

        /** @var \App\Models\User $user */
        $user    = auth()->user();
        $mood    = $request->input('mood', 'neutral') ?: 'neutral';
        $custom  = $request->input('custom_message');

        // Validate mood key exists in config (fall back to neutral)
        $validMoods = ['happy', 'calm', 'sad', 'angry', 'anxious', 'neutral'];
        if (! in_array($mood, $validMoods, true)) {
            $mood = 'neutral';
        }

        $profileUrl = url('/' . $user->username);

        $message = ShareMessageService::generate(
            $user->username,
            $profileUrl,
            $mood,
            $custom
        );

        return response()->json([
            'message'     => $message,
            'profile_url' => $profileUrl,
            'mood'        => $mood,
        ]);
    }
}
