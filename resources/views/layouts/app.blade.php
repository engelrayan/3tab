<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? 'عتاب' }} · 3tab.app</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />

    {{-- Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sand:        #F5EFE6;
            --sand-dark:   #E0D5C5;
            --amber:       #C8923A;
            --amber-light: #E8B96A;
            --ink:         #2C1F0E;
            --ink-soft:    #6B5740;
            --rose:        #C2715A;
            --sage:        #7A9E8E;
            --cream:       #FDFAF5;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
        }

        .font-amiri { font-family: 'Amiri', serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--sand); }
        ::-webkit-scrollbar-thumb { background: var(--amber-light); border-radius: 3px; }

        /* Flash messages */
        .flash-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #166534; border-radius: 12px; padding: .75rem 1.2rem;
            font-size: .9rem;
        }
        .flash-error {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #991b1b; border-radius: 12px; padding: .75rem 1.2rem;
            font-size: .9rem;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen">

    {{-- Nav --}}
    <nav class="sticky top-0 z-50 border-b"
         style="background:rgba(253,250,245,.88);backdrop-filter:blur(12px);border-color:var(--sand-dark);">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}"
               class="font-amiri text-2xl"
               style="color:var(--amber);">عتاب</a>

            {{-- Links --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-sm px-4 py-2 rounded-full border transition"
                       style="border-color:var(--sand-dark);color:var(--ink-soft);"
                       onmouseover="this.style.borderColor='var(--amber)';this.style.color='var(--amber)'"
                       onmouseout="this.style.borderColor='var(--sand-dark)';this.style.color='var(--ink-soft)'">
                        صندوقي
                    </a>
                    <a href="{{ route('profile.show', auth()->user()->username) }}"
                       class="w-9 h-9 rounded-full flex items-center justify-center text-white font-amiri text-lg"
                       style="background:linear-gradient(135deg,var(--amber-light),var(--rose));">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm px-4 py-2 rounded-full border transition"
                                style="border-color:var(--sand-dark);color:var(--ink-soft);">
                            خروج
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm px-4 py-2 rounded-full border transition"
                       style="border-color:var(--sand-dark);color:var(--ink-soft);"
                       onmouseover="this.style.borderColor='var(--amber)';this.style.color='var(--amber)'"
                       onmouseout="this.style.borderColor='var(--sand-dark)';this.style.color='var(--ink-soft)'">
                        دخول
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-sm px-5 py-2 rounded-full text-white font-medium transition"
                       style="background:var(--amber);box-shadow:0 2px 12px rgba(200,146,58,.35);"
                       onmouseover="this.style.background='#b5812e'"
                       onmouseout="this.style.background='var(--amber)'">
                        ابدأ الآن
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="max-w-5xl mx-auto px-4 mt-4">
            <div class="flash-success">✓ {{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="max-w-5xl mx-auto px-4 mt-4">
            <div class="flash-error">{{ session('error') }}</div>
        </div>
    @endif

    {{-- Content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="text-center py-10 mt-16 border-t text-sm"
            style="border-color:var(--sand-dark);color:var(--ink-soft);">
        <p class="font-amiri text-xl mb-1" style="color:var(--amber);">عتاب</p>
        <p class="font-amiri italic mb-1" style="color:var(--ink);">"ما محبة إلا بعد عتاب"</p>
        <p>3tab.app · جميع الحقوق محفوظة</p>
    </footer>

    @stack('scripts')
</body>
</html>
