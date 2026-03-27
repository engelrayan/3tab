<?php

namespace Database\Seeders;

use App\Models\Mood;
use Illuminate\Database\Seeder;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        $moods = [
            [
                'name_ar' => 'مبسوط',
                'name_en' => 'happy',
                'emoji'   => '☀️',
                'color'   => '#C8923A',
                'hint_ar' => 'في مزاج حلو اليوم!',
            ],
            [
                'name_ar' => 'هادي',
                'name_en' => 'calm',
                'emoji'   => '🌿',
                'color'   => '#7A9E8E',
                'hint_ar' => 'محتاج هدوء.',
            ],
            [
                'name_ar' => 'حزين',
                'name_en' => 'sad',
                'emoji'   => '🌧️',
                'color'   => '#7A8FA6',
                'hint_ar' => 'كن رفيقاً في كلامك.',
            ],
            [
                'name_ar' => 'متوتر',
                'name_en' => 'stressed',
                'emoji'   => '🔥',
                'color'   => '#C2715A',
                'hint_ar' => 'اليوم صعب، تمهّل قبل ما تكتب.',
            ],
            [
                'name_ar' => 'قلقان',
                'name_en' => 'anxious',
                'emoji'   => '😶‍🌫️',
                'color'   => '#9E8EA0',
                'hint_ar' => 'أشياء كثيرة تشغل باله.',
            ],
        ];

        foreach ($moods as $mood) {
            Mood::firstOrCreate(['name_en' => $mood['name_en']], $mood);
        }
    }
}
