<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\UserMood;
use App\Services\MoodEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MoodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mood_id'        => ['required', 'exists:moods,id'],
            'custom_message' => ['nullable', 'string', 'max:200'],
        ], [
            'mood_id.required' => 'اختر حالتك أولاً',
            'mood_id.exists'   => 'الحالة غير صحيحة',
        ]);

        // Rate limit: مرة كل ساعة
        $rateCacheKey = 'mood_rate_' . Auth::id();
        if (Cache::has($rateCacheKey)) {
            return response()->json([
                'success' => false,
                'message' => 'تقدر تغير حالتك مرة كل ساعة — استنى شوية',
            ], 429);
        }

        $mood = Mood::find($request->mood_id);

        $userMood = UserMood::updateOrCreate(
            ['user_id' => Auth::id(), 'date' => today()],
            [
                'mood_id'        => $request->mood_id,
                'custom_message' => $request->custom_message,
                'expires_at'     => now()->addHours(24),
            ]
        );

        Cache::put($rateCacheKey, true, 3600);

        $engine         = MoodEngine::get($mood->name_en);
        $profileUrl     = route('profile.show', Auth::user()->username);
        $shareText      = MoodEngine::shareText($mood->name_en, $profileUrl);
        $smartSuggestion = $this->checkConsecutiveSad();

        return response()->json([
            'success'          => true,
            'message'          => 'تم تحديث حالتك لمدة 24 ساعة ✅',
            'mood'             => [
                'id'               => $mood->id,
                'name'             => $mood->name_ar,
                'emoji'            => $mood->emoji,
                'type'             => $mood->name_en,
                'hint'             => $mood->hint_ar,
                'note'             => $request->custom_message,
                'expires_at'       => $userMood->expires_at?->toIso8601String(),
                'seconds_remaining'=> $userMood->secondsRemaining(),
            ],
            'engine'           => $engine,
            'share_text'       => $shareText,
            'profile_url'      => $profileUrl,
            'smart_suggestion' => $smartSuggestion,
        ]);
    }

    public function history()
    {
        $history = UserMood::where('user_id', Auth::id())
            ->with('mood')
            ->whereBetween('date', [today()->subDays(6), today()])
            ->orderBy('date', 'asc')
            ->get()
            ->map(fn($um) => [
                'date'  => $um->date->format('Y-m-d'),
                'emoji' => $um->mood->emoji,
                'name'  => $um->mood->name_ar,
                'type'  => $um->mood->name_en,
            ]);

        return response()->json([
            'success' => true,
            'history' => $history,
            'smart'   => $this->checkConsecutiveSad(),
        ]);
    }

    public function analytics()
    {
        $userId = Auth::id();

        $data = UserMood::where('user_id', $userId)
            ->with('mood')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->map(function ($um) use ($userId) {
                $received = \App\Models\Atab::where('receiver_id', $userId)
                    ->whereDate('created_at', $um->date)
                    ->count();
                return [
                    'date'     => $um->date->format('Y-m-d'),
                    'mood'     => $um->mood->name_ar,
                    'emoji'    => $um->mood->emoji,
                    'type'     => $um->mood->name_en,
                    'received' => $received,
                ];
            });

        $byMood = $data->groupBy('type')->map(fn($g) => [
            'mood'  => $g->first()['mood'],
            'emoji' => $g->first()['emoji'],
            'total' => $g->sum('received'),
            'days'  => $g->count(),
        ])->sortByDesc('total')->values();

        return response()->json([
            'success' => true,
            'by_mood' => $byMood,
            'daily'   => $data->take(7),
        ]);
    }

    public static function getTodayEngine(): array
    {
        $userMood = UserMood::where('user_id', Auth::id())
            ->active()
            ->with('mood')->latest()->first();

        return MoodEngine::get($userMood?->mood?->name_en);
    }

    public function checkConsecutiveSadPublic(): ?string
    {
        return $this->checkConsecutiveSad();
    }

    protected function checkConsecutiveSad(): ?string
    {
        $last = UserMood::where('user_id', Auth::id())
            ->with('mood')->orderByDesc('date')->limit(3)->get();

        if ($last->count() < 3) return null;

        if ($last->every(fn($um) => in_array($um->mood->name_en, ['sad', 'angry', 'anxious']))) {
            return 'واضح إنك متضايق الفترة دي... تحب تفضفض؟ 💙';
        }

        return null;
    }
}
