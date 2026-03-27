<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? 'عتاب' }} · 3tab.app</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }

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

        html, body {
            height: 100%;
            font-family: 'Tajawal', sans-serif;
            background: var(--cream);
            color: var(--ink);
        }

        .font-amiri { font-family: 'Amiri', serif; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--sand); }
        ::-webkit-scrollbar-thumb { background: var(--amber-light); border-radius: 3px; }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>
