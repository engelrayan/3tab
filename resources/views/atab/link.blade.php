<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>عندك عتاب · 3tab.app</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        :root {
            --p:#C6924A; --pl:#E8B96A; --pd:#A07035;
            --dark:#1a1008; --dark2:#120b04; --card:#1f1209;
            --b:rgba(198,146,74,.15); --bh:rgba(198,146,74,.4);
            --text:#F5EDE4; --muted:rgba(245,237,228,.5); --soft:rgba(245,237,228,.72);
            --glow:rgba(198,146,74,.2); --glow2:rgba(198,146,74,.38); --glow3:rgba(198,146,74,.55);
            --rose:#C2715A; --sage:#7A9E8E;
        }
        html, body { min-height:100vh; background:var(--dark2); color:var(--text); font-family:'Tajawal',sans-serif; }
        a { text-decoration:none; color:inherit; }

        /* ── Layout ── */
        .page {
            min-height:100vh;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding:2rem 1rem;
            position:relative; overflow:hidden;
        }

        /* ── BG effects ── */
        .bg-glow-1 { position:fixed; top:-100px; right:-100px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(198,146,74,.08),transparent 70%); pointer-events:none; }
        .bg-glow-2 { position:fixed; bottom:-100px; left:-100px; width:350px; height:350px; border-radius:50%; background:radial-gradient(circle,rgba(194,113,90,.06),transparent 70%); pointer-events:none; }
        .bg-orn { position:fixed; font-family:'Amiri',serif; font-size:22rem; color:rgba(198,146,74,.03); user-select:none; pointer-events:none; line-height:1; }
        .bg-orn.r { bottom:-3rem; left:-2rem; }
        .bg-orn.l { top:-3rem; right:-2rem; }

        /* ── Logo ── */
        .logo {
            position:absolute; top:1.5rem; right:50%; transform:translateX(50%);
            font-family:'Amiri',serif; font-size:1.6rem;
            background:linear-gradient(135deg,var(--pl),var(--p));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            background-clip:text; filter:drop-shadow(0 0 10px var(--glow));
            z-index:10;
        }

        /* ── Card ── */
        .card {
            width:100%; max-width:480px;
            background:linear-gradient(145deg,#221408,#1a0f06);
            border:1px solid var(--b); border-radius:28px;
            padding:2.5rem 2rem;
            box-shadow:0 20px 60px rgba(0,0,0,.6), 0 0 40px rgba(198,146,74,.08);
            position:relative; overflow:hidden;
            animation:fadeUp .6s ease both;
        }
        .card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,var(--p),var(--pl),var(--rose)); }
        .card-glow { position:absolute; top:-60px; right:-60px; width:200px; height:200px; border-radius:50%; background:radial-gradient(circle,rgba(198,146,74,.1),transparent 70%); pointer-events:none; }

        /* ── Sender info ── */
        .sender-wrap { display:flex; flex-direction:column; align-items:center; margin-bottom:1.8rem; }
        .sender-av {
            width:64px; height:64px; border-radius:50%;
            background:linear-gradient(135deg,var(--pl),var(--rose));
            display:flex; align-items:center; justify-content:center;
            font-family:'Amiri',serif; font-size:1.8rem; color:var(--dark2); font-weight:700;
            border:2px solid var(--p); margin-bottom:.9rem;
            box-shadow:0 0 0 5px rgba(198,146,74,.1), 0 0 24px var(--glow2);
            position:relative; z-index:1;
        }
        .sender-av.anon { background:linear-gradient(135deg,#3a2010,#2a1608); color:var(--muted); font-size:1.5rem; }
        .sender-tag {
            font-size:.78rem; color:var(--muted);
            background:rgba(198,146,74,.08); border:1px solid var(--b);
            border-radius:999px; padding:.28rem .85rem; margin-bottom:.5rem;
        }
        .sender-name { font-family:'Amiri',serif; font-size:1.1rem; color:var(--text); }

        /* ── Headline ── */
        .headline {
            text-align:center; margin-bottom:1.8rem;
        }
        .headline h1 { font-family:'Amiri',serif; font-size:1.7rem; color:var(--text); margin-bottom:.4rem; line-height:1.4; }
        .headline p  { font-size:.87rem; color:var(--muted); }

        /* ── Message bubble ── */
        .msg-bubble {
            background:rgba(0,0,0,.3);
            border:1px solid var(--b); border-radius:18px;
            padding:1.3rem 1.5rem;
            margin-bottom:1.8rem;
            position:relative;
        }
        .msg-bubble::before {
            content:'"'; font-family:'Amiri',serif; font-size:3rem;
            color:rgba(198,146,74,.15); position:absolute;
            top:-.5rem; right:1rem; line-height:1;
        }
        .msg-text {
            font-size:.98rem; color:var(--soft); line-height:1.85;
            font-family:'Tajawal',sans-serif;
        }

        /* ── Meta ── */
        .msg-meta {
            display:flex; align-items:center; justify-content:space-between;
            margin-top:1rem; flex-wrap:wrap; gap:.5rem;
        }
        .meta-item { display:flex; align-items:center; gap:.4rem; font-size:.75rem; color:var(--muted); }
        .meta-dot  { width:5px; height:5px; border-radius:50%; background:var(--p); display:inline-block; }

        /* ── CTA ── */
        .cta-section { display:flex; flex-direction:column; gap:.75rem; }
        .btn-main {
            width:100%; padding:.85rem; border-radius:14px; border:none;
            background:linear-gradient(135deg,var(--pl),var(--p));
            color:var(--dark2); font-family:'Tajawal',sans-serif;
            font-size:.97rem; font-weight:700; cursor:pointer;
            transition:all .3s; box-shadow:0 4px 18px var(--glow2);
            text-align:center; display:block;
        }
        .btn-main:hover { transform:translateY(-2px); box-shadow:0 8px 28px var(--glow3); }
        .btn-outline {
            width:100%; padding:.8rem; border-radius:14px;
            background:rgba(198,146,74,.07); border:1px solid var(--bh);
            color:var(--pl); font-family:'Tajawal',sans-serif;
            font-size:.92rem; font-weight:600; cursor:pointer;
            transition:all .25s; text-align:center; display:block;
        }
        .btn-outline:hover { background:rgba(198,146,74,.15); box-shadow:0 0 18px var(--glow); }

        .cta-hint { text-align:center; font-size:.78rem; color:var(--muted); margin-top:.4rem; }
        .cta-hint a { color:var(--p); transition:color .2s; }
        .cta-hint a:hover { color:var(--pl); }

        /* ── Views counter ── */
        .views-badge {
            display:inline-flex; align-items:center; gap:.35rem;
            background:rgba(198,146,74,.06); border:1px solid var(--b);
            border-radius:999px; padding:.28rem .85rem;
            font-size:.73rem; color:var(--muted);
            margin:0 auto 1.5rem; display:flex; width:fit-content; margin-left:auto; margin-right:auto;
        }

        /* ── One-Time badge ── */
        .ot-badge {
            display:flex; align-items:center; gap:.5rem;
            background:linear-gradient(135deg,rgba(194,113,90,.18),rgba(194,113,90,.08));
            border:1px solid rgba(194,113,90,.35); border-radius:14px;
            padding:.7rem 1rem; margin-bottom:1.4rem;
            animation: otPulse 2.5s ease-in-out infinite;
        }
        .ot-badge-icon { font-size:1.1rem; flex-shrink:0; }
        .ot-badge-text { font-size:.8rem; color:rgba(245,237,228,.75); line-height:1.5; }
        .ot-badge-text strong { color:#E8956D; font-size:.83rem; }
        @keyframes otPulse {
            0%,100% { box-shadow:0 0 0 0 rgba(194,113,90,0); }
            50%      { box-shadow:0 0 12px 3px rgba(194,113,90,.18); }
        }

        /* ── Footer ── */
        .footer-brand {
            margin-top:2rem; text-align:center;
            font-size:.78rem; color:rgba(245,237,228,.25);
        }
        .footer-brand a { color:var(--p); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)} }

        @media(max-width:500px) {
            .card { padding:2rem 1.3rem; border-radius:22px; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    <span class="bg-orn r">ب</span>
    <span class="bg-orn l">ع</span>

    <a href="{{ route('home') }}" class="logo">عتاب</a>

    <div class="card">
        <div class="card-glow"></div>

        {{-- Sender --}}
        <div class="sender-wrap">
            <div class="sender-av {{ $atab->is_anonymous ? 'anon' : '' }}">
                @if($atab->is_anonymous) 🎭
                @else {{ mb_substr($atab->sender?->name ?? '؟', 0, 1) }}
                @endif
            </div>
            <span class="sender-tag">
                @if($atab->is_anonymous) مجهول الهوية
                @else {{ $atab->sender?->name ?? 'شخص ما' }}
                @endif
            </span>
            <span class="sender-name">بعتلك عتاب 💌</span>
        </div>

        {{-- Views --}}
        <div class="views-badge">
            👁 {{ $atab->views_count }} {{ $atab->views_count === 1 ? 'مشاهدة' : 'مشاهدات' }}
        </div>

        {{-- Headline --}}
        <div class="headline">
            <h1>عندك عتاب من<br>
                @if($atab->is_anonymous)
                    <span style="color:var(--pl);">شخص يهتم بك</span>
                @else
                    <span style="color:var(--pl);">{{ $atab->sender?->name ?? 'شخص ما' }}</span>
                @endif
            </h1>
            <p>"ما محبة إلا بعد عتاب"</p>
        </div>

        {{-- One-Time warning --}}
        @if($atab->is_one_time)
        <div class="ot-badge">
            <span class="ot-badge-icon">⚠️</span>
            <div class="ot-badge-text">
                <strong>رسالة تُعرض مرة واحدة فقط</strong><br>
                بمجرد ما تغلق هذه الصفحة لن تتمكن من رؤيتها مجدداً إلا بالتسجيل
            </div>
        </div>
        @endif

        {{-- Message --}}
        <div class="msg-bubble">
            <p class="msg-text">{{ $firstMessage?->body ?? '...' }}</p>
            <div class="msg-meta">
                <span class="meta-item">
                    <span class="meta-dot"></span>
                    {{ $atab->created_at->diffForHumans() }}
                </span>
                @if($atab->is_anonymous)
                    <span class="meta-item">🎭 مجهول الهوية</span>
                @endif
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-section">
            @if($atab->is_one_time)
                <a href="{{ route('register') }}" class="btn-main">
                    💬 سجّل حسابك علشان ترد وتشوف الرسالة تاني
                </a>
                <a href="{{ route('login') }}" class="btn-outline">
                    تسجيل الدخول
                </a>
                <p class="cta-hint" style="margin-top:.5rem;color:rgba(194,113,90,.8);">
                    ⏳ لو مسجّلتش دلوقتي، مش هتقدر تشوف الرسالة تاني
                </p>
            @else
                <a href="{{ route('register') }}" class="btn-main">
                    ✨ سجّل حساب وردّ على العتاب
                </a>
                <a href="{{ route('login') }}" class="btn-outline">
                    تسجيل الدخول للرد
                </a>
                <p class="cta-hint" style="margin-top:.9rem;">
                    بالتسجيل، العتاب هيتضاف لحسابك تلقائياً<br>
                    <a href="{{ route('home') }}">تعرف أكثر عن عتاب</a>
                </p>
            @endif
        </div>
    </div>

    <div class="footer-brand">
        <a href="{{ route('home') }}">عتاب</a> · مساحة للصدق العاطفي
    </div>
</div>
</body>
</html>
