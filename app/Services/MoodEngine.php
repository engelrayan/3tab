<?php

namespace App\Services;

class MoodEngine
{
    const MOODS = [
        'happy'   => [
            'cta'        => 'ابعت كلمة حلوة ❤️',
            'cta_action' => 'send',
            'suggestion' => 'في حد محتاج منك كلمة حلوة؟ 😊',
            'empty'      => 'ابدأ بكلمة حلوة وخلي يوم حد أحسن ❤️',
            'toast'      => 'يوم حلو يستاهل كلمة حلوة 😊',
        ],
        'calm'    => [
            'cta'        => 'تابع عتاباتك بهدوء 🌿',
            'cta_action' => 'inbox',
            'suggestion' => 'يوم هادي... تحب تراجع عتاباتك؟ 🌿',
            'empty'      => 'الهدوء وقت كويس تبدأ فيه 🌿',
            'toast'      => 'الهدوء نعمة، حافظ عليه 🌿',
        ],
        'sad'     => [
            'cta'        => 'فضفض وابعت عتاب 💬',
            'cta_action' => 'send',
            'suggestion' => 'حاسس إنك محتاج تتكلم؟ ابعت عتاب 💙',
            'empty'      => 'فضفض... يمكن ترتاح 💔',
            'toast'      => 'التعبير بيريّح، قول اللي جواك 💙',
        ],
        'angry'   => [
            'cta'        => 'طلع اللي جواك 😤',
            'cta_action' => 'send',
            'suggestion' => 'خد نفس... واكتب اللي جواك ✍️',
            'empty'      => 'قول اللي جواك بصراحة 😤',
            'toast'      => 'الكتابة أحسن من الصمت ✍️',
        ],
        'anxious' => [
            'cta'        => 'اكتب اللي بيشغل بالك 📝',
            'cta_action' => 'send',
            'suggestion' => 'أشياء تشغل بالك؟ الكتابة بتساعد 📝',
            'empty'      => 'اكتب اللي بيشغلك، هيريّحك 📝',
            'toast'      => 'مش لازم تشيل كل حاجة لوحدك 📝',
        ],
    ];

    const DEFAULT_MOOD = [
        'cta'        => 'ابدأ عتاب جديد ✉️',
        'cta_action' => 'send',
        'suggestion' => 'جرب تبدأ عتاب جديد مع شخص تهتم به 🤍',
        'empty'      => 'ابدأ أول عتاب وخلي الأمور تتحسن ❤️',
        'toast'      => 'خطوة كويسة 👏 التعبير بيريّح',
    ];

    public static function get(?string $type): array
    {
        return self::MOODS[$type ?? ''] ?? self::DEFAULT_MOOD;
    }

    public static function allAsJson(): string
    {
        return json_encode(array_merge(self::MOODS, ['default' => self::DEFAULT_MOOD]));
    }
}
