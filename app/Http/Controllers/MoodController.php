<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\UserMood;
use App\Services\MoodEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mood_id'        => ['required', 'exists:moods,id'],
            'custom_message' => ['nullable', 'string', 'max:500'],
        ], [
            'mood_id.required' => 'اختر حالتك أولاً',
            'mood_id.exists'   => 'الحالة غير صحيحة',
        ]);

        $mood = Mood::find($request->mood_id);

        UserMood::updateOrCreate(
            ['user_id' => Auth::id(), 'date' => today()],
            ['mood_id' => $request->mood_id, 'custom_message' => $request->custom_message]
        );

        $engine          = MoodEngine::get($mood->name_en);
        $smartSuggestion = $this->checkConsecutiveSad();

        return response()->json([
            'success'          => true,
            'message'          => 'تم تسجيل حالتك 👍',
            'mood'             => [
                'id'    => $mood->id,
                'name'  => $mood->name_ar,
                'emoji' => $mood->emoji,
                'type'  => $mood->name_en,
                'hint'  => $mood->hint_ar,
                'note'  => $request->custom_message,
            ],
            'engine'           => $engine,
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

    public static function getTodayEngine(): array
    {
        $userMood = UserMood::where('user_id', Auth::id())
            ->whereDate('date', today())
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