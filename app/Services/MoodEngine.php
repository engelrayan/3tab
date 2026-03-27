<?php

namespace App\Services;

class MoodEngine
{
    const MOODS = [
        'happy'   => [
            'cta'              => 'ابعت كلمة حلوة ❤️',
            'cta_action'       => 'send',
            'suggestion'       => 'في حد محتاج منك كلمة حلوة؟ 😊',
            'empty'            => 'ابدأ بكلمة حلوة وخلي يوم حد أحسن ❤️',
            'toast'            => 'يوم حلو يستاهل كلمة حلوة 😊',
            'profile_cta'      => 'شاركه كلمة حلوة ❤️',
            'profile_sub'      => 'صاحب الصفحة مبسوط النهاردة — ابعتله حاجة حلوة',
            'placeholder'      => 'ابعتله كلمة حلوة تزود فرحته 😊',
            'profile_badge_bg' => '122,158,142',
            'share_ar'         => "أنا مبسوط النهاردة 😊\nلو عندك حاجة حلوة تقولها ليا، قولها هنا:\n👉 {link}",
        ],
        'calm'    => [
            'cta'              => 'تابع عتاباتك بهدوء 🌿',
            'cta_action'       => 'inbox',
            'suggestion'       => 'يوم هادي... تحب تراجع عتاباتك؟ 🌿',
            'empty'            => 'الهدوء وقت كويس تبدأ فيه 🌿',
            'toast'            => 'الهدوء نعمة، حافظ عليه 🌿',
            'profile_cta'      => 'ابعتله رسالة هادية 🌿',
            'profile_sub'      => 'صاحب الصفحة هادي النهاردة — الوقت مناسب للكلام الصادق',
            'placeholder'      => 'قول اللي في قلبك بهدوء 🌿',
            'profile_badge_bg' => '122,158,142',
            'share_ar'         => "أنا هادي النهاردة 🌿\nلو في حاجة عايز تقولها ليا بصراحة:\n👉 {link}",
        ],
        'sad'     => [
            'cta'              => 'فضفض وابعت عتاب 💬',
            'cta_action'       => 'send',
            'suggestion'       => 'حاسس إنك محتاج تتكلم؟ ابعت عتاب 💙',
            'empty'            => 'فضفض... يمكن ترتاح 💔',
            'toast'            => 'التعبير بيريّح، قول اللي جواك 💙',
            'profile_cta'      => 'ابعتله كلمة تريّحه 💙',
            'profile_sub'      => 'صاحب الصفحة زعلان — كلمة منك ممكن تفرق',
            'placeholder'      => 'قول اللي في قلبك، يمكن تفرق معاه 💙',
            'profile_badge_bg' => '100,149,237',
            'share_ar'         => "أنا حاسس إني زعلان النهاردة 😔\nلو في حاجة في قلبك ناحيتي، قولها هنا:\n👉 {link}",
        ],
        'angry'   => [
            'cta'              => 'طلع اللي جواك 😤',
            'cta_action'       => 'send',
            'suggestion'       => 'خد نفس... واكتب اللي جواك ✍️',
            'empty'            => 'قول اللي جواك بصراحة 😤',
            'toast'            => 'الكتابة أحسن من الصمت ✍️',
            'profile_cta'      => 'ابعتله كلمة تهدّيه 💛',
            'profile_sub'      => 'صاحب الصفحة متضايق — ممكن كلمتك تعمل فرق',
            'placeholder'      => 'قول اللي جواك، الكلام بيريّح 💛',
            'profile_badge_bg' => '198,146,74',
            'share_ar'         => "أنا متضايق النهاردة 😤\nلو عندك حاجة عايز تقولها ليا:\n👉 {link}",
        ],
        'anxious' => [
            'cta'              => 'اكتب اللي بيشغل بالك 📝',
            'cta_action'       => 'send',
            'suggestion'       => 'أشياء تشغل بالك؟ الكتابة بتساعد 📝',
            'empty'            => 'اكتب اللي بيشغلك، هيريّحك 📝',
            'toast'            => 'مش لازم تشيل كل حاجة لوحدك 📝',
            'profile_cta'      => 'ابعتله كلمة طمن باله 🤍',
            'profile_sub'      => 'صاحب الصفحة قلقان — رسالتك ممكن تريّحه',
            'placeholder'      => 'اكتب اللي جواك، ربما يريّحه 🤍',
            'profile_badge_bg' => '194,113,90',
            'share_ar'         => "أنا قلقان شوية النهاردة 😟\nلو عندك حاجة حلوة تقولها ليا:\n👉 {link}",
        ],
    ];

    const DEFAULT_MOOD = [
        'cta'              => 'ابدأ عتاب جديد ✉️',
        'cta_action'       => 'send',
        'suggestion'       => 'جرب تبدأ عتاب جديد مع شخص تهتم به 🤍',
        'empty'            => 'ابدأ أول عتاب وخلي الأمور تتحسن ❤️',
        'toast'            => 'خطوة كويسة 👏 التعبير بيريّح',
        'profile_cta'      => 'ابعتله رسالة صادقة 💬',
        'profile_sub'      => 'قول اللي في قلبك بصراحة',
        'placeholder'      => 'اكتب اللي جواك بصدق 💬',
        'profile_badge_bg' => '198,146,74',
        'share_ar'         => "قولّي اللي في قلبك بصراحة 👇\n{link}",
    ];

    public static function get(?string $type): array
    {
        return self::MOODS[$type ?? ''] ?? self::DEFAULT_MOOD;
    }

    public static function allAsJson(): string
    {
        return json_encode(array_merge(self::MOODS, ['default' => self::DEFAULT_MOOD]));
    }

    /** نص المشاركة مع رابط البروفايل */
    public static function shareText(?string $moodType, string $profileUrl): string
    {
        $engine = self::get($moodType);
        return str_replace('{link}', $profileUrl, $engine['share_ar']);
    }
}
