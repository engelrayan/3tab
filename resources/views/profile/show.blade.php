<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>قول لـ {{ $user->name }} اللي جواك · عتاب</title>
    <meta property="og:title" content="قول لـ {{ $user->name }} اللي جواك بصراحة 👀" />
    <meta property="og:description" content="🔒 تقدر تبعت بدون اسم… محدش هيعرفك · ما محبة إلا بعد عتاب" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary:       #C6924A; --primary-light: #E8B96A; --primary-dark: #A07035;
            --dark:          #1a1008; --dark-2:        #120b04;
            --dark-card:     #1f1209; --dark-card2:    #261609;
            --border:        rgba(198,146,74,.15); --border-h: rgba(198,146,74,.4);
            --text:          #F5EDE4; --muted: rgba(245,237,228,.5); --soft: rgba(245,237,228,.72);
            --glow:          rgba(198,146,74,.2); --glow2: rgba(198,146,74,.38); --glow3: rgba(198,146,74,.55);
            --rose:          #C2715A; --sage: #7A9E8E;
        }
        html,body{min-height:100vh;background:var(--dark-2);color:var(--text);font-family:'Tajawal',sans-serif}
        a{text-decoration:none;color:inherit}
        ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:var(--dark)}::-webkit-scrollbar-thumb{background:var(--primary-dark);border-radius:3px}

        /* ── NAV ─────────────────────────────────────────── */
        .nav{position:sticky;top:0;z-index:100;height:60px;background:rgba(18,11,4,.93);backdrop-filter:blur(20px);border-bottom:1px solid var(--border);padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between}
        .nav-logo{font-family:'Amiri',serif;font-size:1.9rem;background:linear-gradient(135deg,var(--primary-light),var(--primary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 10px var(--glow))}
        .nav-actions{display:flex;gap:.55rem;align-items:center}
        .btn-nav{padding:.42rem 1.1rem;border-radius:999px;font-family:'Tajawal',sans-serif;font-size:.83rem;font-weight:500;cursor:pointer;transition:all .3s}
        .btn-nav-ghost{background:transparent;border:1px solid var(--border);color:var(--muted)}
        .btn-nav-ghost:hover{border-color:var(--primary);color:var(--primary)}
        .btn-nav-gold{border:none;background:linear-gradient(135deg,var(--primary-light),var(--primary));color:var(--dark-2);font-weight:700;box-shadow:0 3px 14px var(--glow2)}
        .btn-nav-gold:hover{transform:translateY(-1px);box-shadow:0 6px 22px var(--glow3)}
        .nav-avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--primary-light),var(--rose));display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:1rem;color:var(--dark-2);font-weight:700;border:1.5px solid var(--border-h);cursor:pointer;transition:all .3s}
        .nav-avatar:hover{box-shadow:0 0 16px var(--glow2);transform:scale(1.06)}

        /* ── PAGE WRAPPER ─────────────────────────────────── */
        .page{max-width:580px;margin:0 auto;padding:2rem 1.2rem 6rem;display:flex;flex-direction:column;gap:1.4rem}

        /* ── HERO ─────────────────────────────────────────── */
        .hero{text-align:center;padding:2rem 1.5rem 1.6rem;background:linear-gradient(160deg,#2a1508,#1a0d06);border:1px solid var(--border);border-radius:28px;position:relative;overflow:hidden;box-shadow:0 14px 50px rgba(0,0,0,.55)}
        .hero::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--rose),var(--primary),var(--primary-light),var(--primary),var(--rose))}
        .hero-glow{position:absolute;top:-60px;left:50%;transform:translateX(-50%);width:340px;height:340px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.1),transparent 70%);pointer-events:none}
        .hero-avatar-wrap{position:relative;display:inline-block;margin-bottom:1.1rem}
        .hero-avatar{width:86px;height:86px;border-radius:50%;background:linear-gradient(135deg,var(--primary-light),var(--rose));display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:2.4rem;color:var(--dark-2);font-weight:700;border:2px solid var(--primary);box-shadow:0 0 0 5px rgba(198,146,74,.1),0 0 28px var(--glow2);overflow:hidden;margin:0 auto}
        .hero-avatar img{width:100%;height:100%;object-fit:cover}
        .hero-avatar-pulse{position:absolute;inset:-8px;border-radius:50%;border:1px solid rgba(198,146,74,.3);animation:pulse 2.8s ease-in-out infinite}
        @if($todayMood)
        .hero-mood{position:absolute;bottom:-4px;left:50%;transform:translateX(-50%);background:rgba(198,146,74,.15);border:1px solid var(--border-h);border-radius:999px;padding:.15rem .65rem;font-size:.75rem;white-space:nowrap}
        @endif

        .hero-hook{font-family:'Amiri',serif;font-size:1.75rem;line-height:1.35;color:var(--text);margin-bottom:.55rem;position:relative;z-index:1}
        .hero-hook span{background:linear-gradient(135deg,var(--primary-light),var(--primary));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero-trust{font-size:.84rem;color:var(--muted);position:relative;z-index:1;display:inline-flex;align-items:center;gap:.4rem;background:rgba(0,0,0,.25);border:1px solid var(--border);border-radius:999px;padding:.35rem 1rem}

        @if($todayMood)
        .hero-mood-line{font-size:.82rem;color:var(--muted);margin-top:.75rem;position:relative;z-index:1}
        @endif

        /* ── SEND CARD ────────────────────────────────────── */
        .send-card{background:var(--dark-card);border:2px solid var(--border);border-radius:24px;padding:1.8rem;box-shadow:0 10px 40px rgba(0,0,0,.45);transition:border-color .3s,box-shadow .3s}
        .send-card:focus-within{border-color:rgba(198,146,74,.5);box-shadow:0 10px 40px rgba(0,0,0,.45),0 0 30px var(--glow)}

        .send-textarea{width:100%;min-height:130px;background:rgba(0,0,0,.3);border:1.5px solid var(--border);border-radius:16px;padding:1rem 1.1rem;color:var(--text);font-family:'Tajawal',sans-serif;font-size:.97rem;resize:none;outline:none;transition:border-color .25s,box-shadow .25s;direction:rtl;line-height:1.75;letter-spacing:.01em}
        .send-textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(198,146,74,.1)}
        .send-textarea::placeholder{color:rgba(245,237,228,.2)}
        .send-error{font-size:.78rem;color:#f87171;margin-top:.4rem;display:none}

        /* urgency line */
        .urgency-line{display:flex;align-items:center;gap:.4rem;font-size:.78rem;color:rgba(245,237,228,.35);margin-top:.6rem}
        .urgency-dot{width:6px;height:6px;border-radius:50%;background:#ef4444;animation:blink 1.4s ease-in-out infinite}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:.25}}

        /* anon toggle */
        .anon-row{display:flex;align-items:center;gap:.55rem;margin-top:.95rem;background:rgba(0,0,0,.2);border:1px solid var(--border);border-radius:14px;padding:.65rem .9rem}
        .anon-btn{flex:1;padding:.48rem .7rem;border-radius:10px;border:none;font-family:'Tajawal',sans-serif;font-size:.82rem;font-weight:600;cursor:pointer;transition:all .25s;background:transparent;color:var(--muted)}
        .anon-btn.active-anon{background:linear-gradient(135deg,var(--primary-light),var(--primary));color:var(--dark-2);box-shadow:0 2px 10px var(--glow2)}
        .anon-btn.active-named{background:rgba(122,158,142,.18);color:var(--sage);border:1px solid rgba(122,158,142,.3)}

        /* CTA */
        .btn-send-big{display:block;width:100%;margin-top:1.1rem;padding:.9rem 1.5rem;border:none;border-radius:16px;background:linear-gradient(135deg,var(--primary-light),var(--primary));color:var(--dark-2);font-family:'Tajawal',sans-serif;font-size:1.05rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 5px 22px var(--glow2);position:relative;overflow:hidden;letter-spacing:.02em}
        .btn-send-big::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.12),transparent);opacity:0;transition:opacity .3s}
        .btn-send-big:hover{transform:translateY(-2px);box-shadow:0 10px 34px var(--glow3)}
        .btn-send-big:hover::after{opacity:1}
        .btn-send-big:disabled{opacity:.5;cursor:not-allowed;transform:none;box-shadow:none}
        .btn-send-big:active{transform:scale(.985)}

        .send-footer-meta{display:flex;align-items:center;justify-content:space-between;margin-top:.55rem}
        .char-c{font-size:.73rem;color:var(--muted)}

        /* ── SOCIAL PROOF ─────────────────────────────────── */
        .social-proof{display:flex;align-items:center;gap:.55rem;padding:.75rem 1.1rem;background:rgba(198,146,74,.04);border:1px solid var(--border);border-radius:14px;font-size:.8rem;color:var(--muted)}
        .proof-fire{font-size:1.1rem;flex-shrink:0}
        .proof-avatars{display:flex;margin-left:.3rem}
        .proof-av{width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--rose));border:1.5px solid var(--dark-2);margin-right:-6px;font-size:.6rem;display:flex;align-items:center;justify-content:center;color:var(--dark-2);font-weight:700}

        /* ── OWNER NOTICE ─────────────────────────────────── */
        .owner-notice{background:rgba(198,146,74,.06);border:1px dashed var(--border-h);border-radius:16px;padding:1.1rem 1.4rem;text-align:center}
        .owner-notice p{font-size:.87rem;color:var(--muted);line-height:1.7}
        .owner-notice a{color:var(--primary);font-weight:600}

        /* ── STATS STRIP ──────────────────────────────────── */
        .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem}
        .sstat{background:var(--dark-card);border:1px solid var(--border);border-radius:16px;padding:1rem;text-align:center;transition:transform .3s,box-shadow .3s}
        .sstat:hover{transform:translateY(-4px);box-shadow:0 10px 30px rgba(0,0,0,.4),0 0 16px var(--glow);border-color:var(--border-h)}
        .sstat-val{font-family:'Amiri',serif;font-size:2rem;color:var(--primary);line-height:1;margin-bottom:.2rem}
        .sstat-label{font-size:.73rem;color:var(--muted)}

        /* ── POST-SEND MODAL ──────────────────────────────── */
        .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.75);backdrop-filter:blur(6px);z-index:9999;display:flex;align-items:center;justify-content:center;padding:1.5rem;opacity:0;pointer-events:none;transition:opacity .3s}
        .modal-overlay.open{opacity:1;pointer-events:all}
        .modal-box{background:linear-gradient(160deg,#2a1508,#1a0d06);border:1px solid rgba(198,146,74,.3);border-radius:28px;padding:2.2rem 1.8rem;max-width:420px;width:100%;text-align:center;box-shadow:0 30px 80px rgba(0,0,0,.8),0 0 0 1px rgba(198,146,74,.08);transform:translateY(20px) scale(.96);transition:transform .35s cubic-bezier(.34,1.2,.64,1);position:relative;overflow:hidden}
        .modal-overlay.open .modal-box{transform:translateY(0) scale(1)}
        .modal-box::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--rose),var(--primary-light),var(--rose))}
        .modal-glow{position:absolute;top:-50px;left:50%;transform:translateX(-50%);width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.12),transparent 70%);pointer-events:none}
        .modal-icon{font-size:3.5rem;line-height:1;margin-bottom:.8rem;position:relative;z-index:1;animation:popIn .5s cubic-bezier(.34,1.3,.64,1) .15s both}
        @keyframes popIn{from{transform:scale(0) rotate(-15deg)}to{transform:scale(1) rotate(0)}}
        .modal-title{font-family:'Amiri',serif;font-size:1.8rem;color:var(--text);margin-bottom:.45rem;position:relative;z-index:1}
        .modal-sub{font-size:.88rem;color:var(--muted);line-height:1.75;margin-bottom:1.4rem;position:relative;z-index:1}
        .modal-sub strong{color:var(--primary-light)}
        .btn-modal-reg{display:block;width:100%;padding:.88rem 1.5rem;border:none;border-radius:14px;background:linear-gradient(135deg,var(--primary-light),var(--primary));color:var(--dark-2);font-family:'Tajawal',sans-serif;font-size:1rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 4px 18px var(--glow2);margin-bottom:.7rem;position:relative;z-index:1}
        .btn-modal-reg:hover{transform:translateY(-2px);box-shadow:0 8px 28px var(--glow3)}
        .modal-share-row{display:flex;gap:.6rem;margin-bottom:.7rem;position:relative;z-index:1}
        .btn-modal-share{flex:1;padding:.7rem;border:1px solid var(--border);border-radius:12px;background:rgba(198,146,74,.08);color:var(--primary-light);font-family:'Tajawal',sans-serif;font-size:.86rem;font-weight:600;cursor:pointer;transition:all .25s}
        .btn-modal-share:hover{background:rgba(198,146,74,.15);border-color:var(--border-h)}
        .btn-modal-skip{background:none;border:none;color:var(--muted);font-family:'Tajawal',sans-serif;font-size:.82rem;cursor:pointer;transition:color .2s;padding:.4rem;position:relative;z-index:1}
        .btn-modal-skip:hover{color:var(--primary-light)}

        /* ── AUTH SENT NOTICE ─────────────────────────────── */
        .auth-sent-notice{display:none;align-items:center;gap:1rem;padding:1rem 1.3rem;background:rgba(74,222,128,.06);border:1px solid rgba(74,222,128,.18);border-radius:14px}
        .auth-sent-notice.show{display:flex;animation:fadeUp .4s ease both}

        /* ── VIRAL SHARE STRIP ────────────────────────────── */
        .viral-share{display:none;flex-direction:column;align-items:center;gap:.85rem;padding:1.5rem;background:rgba(198,146,74,.04);border:1px solid var(--border);border-radius:18px;text-align:center}
        .viral-share.show{display:flex;animation:fadeUp .45s ease both}
        .viral-share-title{font-family:'Amiri',serif;font-size:1.1rem;color:var(--text)}
        .viral-share-sub{font-size:.82rem;color:var(--muted);line-height:1.6;max-width:320px}
        .btn-viral-share{padding:.7rem 1.8rem;border:none;border-radius:12px;background:linear-gradient(135deg,var(--primary-light),var(--primary));color:var(--dark-2);font-family:'Tajawal',sans-serif;font-size:.9rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 4px 16px var(--glow2)}
        .btn-viral-share:hover{transform:translateY(-2px);box-shadow:0 8px 24px var(--glow3)}
        .viral-copy-row{display:flex;align-items:center;gap:.5rem;background:rgba(0,0,0,.25);border:1px solid var(--border);border-radius:9px;padding:.45rem .85rem;width:100%;max-width:320px}
        .viral-copy-url{flex:1;font-size:.76rem;color:var(--muted);direction:ltr;text-align:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .viral-copy-btn{background:rgba(198,146,74,.12);border:1px solid var(--border);border-radius:7px;padding:.25rem .6rem;font-size:.72rem;color:var(--primary);cursor:pointer;transition:all .25s;font-family:'Tajawal',sans-serif;white-space:nowrap}
        .viral-copy-btn:hover{background:rgba(198,146,74,.22);border-color:var(--primary)}

        /* ── ANIMATIONS ───────────────────────────────────── */
        @keyframes pulse{0%,100%{transform:scale(1);opacity:.35}50%{transform:scale(1.08);opacity:.75}}
        @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        @keyframes shimmer{0%{background-position:200% center}100%{background-position:-200% center}}

        .page > *{animation:fadeUp .5s ease both}
        .page > *:nth-child(1){animation-delay:.05s}
        .page > *:nth-child(2){animation-delay:.12s}
        .page > *:nth-child(3){animation-delay:.18s}
        .page > *:nth-child(4){animation-delay:.24s}
        .page > *:nth-child(5){animation-delay:.3s}

        /* ── MOOD CONTEXT BLOCK ── */
        .mood-context-block{
            display:flex;align-items:flex-start;gap:.75rem;
            padding:.8rem 1rem;border-radius:14px;margin-bottom:1rem;
            background:rgba(100,149,237,.07);border:1px solid rgba(100,149,237,.2);
            animation:fadeUp .4s ease both;
        }
        .mood-context-block.happy{background:rgba(122,158,142,.07);border-color:rgba(122,158,142,.2)}
        .mood-context-block.calm{background:rgba(122,158,142,.07);border-color:rgba(122,158,142,.2)}
        .mood-context-block.angry{background:rgba(198,146,74,.07);border-color:rgba(198,146,74,.25)}
        .mood-context-block.anxious{background:rgba(194,113,90,.07);border-color:rgba(194,113,90,.22)}
        .mood-context-block.sad{background:rgba(100,149,237,.08);border-color:rgba(100,149,237,.25);animation:moodPulse 3s ease-in-out infinite}
        @keyframes moodPulse{0%,100%{box-shadow:0 0 0 0 rgba(100,149,237,0)}50%{box-shadow:0 0 12px 3px rgba(100,149,237,.1)}}
        .mood-ctx-emoji{font-size:1.4rem;flex-shrink:0;line-height:1.3}
        .mood-ctx-text{font-size:.83rem;color:var(--soft);line-height:1.6}
        .mood-ctx-cta{font-size:.82rem;font-weight:700;color:var(--primary-light);margin-top:.15rem;display:block}

        /* ── MOOD EXPIRY PILL ── */
        .mood-expiry-pill{
            display:inline-flex;align-items:center;gap:.4rem;
            background:rgba(0,0,0,.25);border:1px solid var(--border);
            border-radius:999px;padding:.22rem .75rem;
            font-size:.72rem;color:var(--muted);margin-top:.55rem;
        }
        .expiry-dot{width:5px;height:5px;border-radius:50%;background:var(--sage);flex-shrink:0}

        /* ── MOOD SHARE CARD ── */
        .mood-share-card{
            background:var(--dark-card);border:1px solid var(--border);
            border-radius:20px;padding:1.3rem 1.4rem;
        }
        .mood-share-title{font-family:'Amiri',serif;font-size:1.1rem;color:var(--text);margin-bottom:.3rem}
        .mood-share-sub{font-size:.79rem;color:var(--muted);margin-bottom:.9rem;line-height:1.6}
        .mood-share-preview{
            background:rgba(0,0,0,.3);border:1px dashed rgba(198,146,74,.2);
            border-radius:10px;padding:.65rem .9rem;font-size:.79rem;
            color:var(--soft);line-height:1.7;margin-bottom:.9rem;
            font-style:italic;white-space:pre-wrap;
        }
        .mood-share-btns{display:flex;gap:.5rem;flex-wrap:wrap}
        .mood-sbtn{
            padding:.5rem .95rem;border-radius:10px;border:1px solid;
            font-family:'Tajawal',sans-serif;font-size:.8rem;font-weight:600;
            cursor:pointer;transition:all .22s;display:inline-flex;align-items:center;gap:.35rem;
        }
        .ms-wa{background:rgba(37,211,102,.08);border-color:rgba(37,211,102,.22);color:#25d366}
        .ms-wa:hover{background:rgba(37,211,102,.18)}
        .ms-tw{background:rgba(29,161,242,.08);border-color:rgba(29,161,242,.22);color:#1da1f2}
        .ms-tw:hover{background:rgba(29,161,242,.18)}
        .ms-cp{background:rgba(198,146,74,.08);border-color:rgba(198,146,74,.22);color:var(--primary-light)}
        .ms-cp:hover{background:rgba(198,146,74,.18)}

        @media(max-width:500px){
            .hero-hook{font-size:1.45rem}
            .stats-strip{grid-template-columns:repeat(3,1fr);gap:.5rem}
            .sstat-val{font-size:1.6rem}
            .mood-share-btns{gap:.4rem}
        }
    </style>
</head>
<body>

{{-- ══ NAV ══ --}}
<nav class="nav">
    <a href="{{ route('home') }}" class="nav-logo">عتاب</a>
    <div class="nav-actions">
        @auth
            <a href="{{ route('dashboard') }}"><button class="btn-nav btn-nav-ghost">صندوقي</button></a>
            <a href="{{ route('profile.show', auth()->user()->username) }}">
                <div class="nav-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
            </a>
        @else
            <a href="{{ route('login') }}"><button class="btn-nav btn-nav-ghost">دخول</button></a>
            <a href="{{ route('register') }}"><button class="btn-nav btn-nav-gold">ابدأ الآن</button></a>
        @endauth
    </div>
</nav>

<div class="page">

    {{-- ══ HERO ══ --}}
    <div class="hero">
        <div class="hero-glow"></div>
        <div class="hero-avatar-wrap">
            <div class="hero-avatar">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}">
                @else
                    {{ mb_substr($user->name, 0, 1) }}
                @endif
            </div>
            <div class="hero-avatar-pulse"></div>
            @if($todayMood)
            <div class="hero-mood" style="background:rgba({{ $todayMood->mood->color ?? '198,146,74' }},.18);border-color:rgba({{ $todayMood->mood->color ?? '198,146,74' }},.4)">
                {{ $todayMood->mood->emoji }} {{ $todayMood->mood->name_ar }}
            </div>
            @endif
        </div>

        <h1 class="hero-hook">
            💬 قول لـ <span>{{ $user->name }}</span><br>اللي جواك
        </h1>

        <div class="hero-trust">
            🔒 تقدر تبعت بدون اسم… محدش هيعرفك
        </div>

        @if($activeMood)
        <p class="hero-mood-line">
            {{ $user->name }} حاسس/ة إنه
            <strong style="color:var(--primary-light)">{{ $activeMood->mood->name_ar }} {{ $activeMood->mood->emoji }}</strong>
            @if($activeMood->custom_message)
            — "{{ $activeMood->custom_message }}"
            @endif
        </p>
        @if($activeMood->expires_at)
        <div class="mood-expiry-pill">
            <span class="expiry-dot"></span>
            <span id="mood-expiry-text">الحالة نشطة</span>
        </div>
        @endif
        @endif
    </div>

    {{-- ══ SEND CARD (shown unless owner) ══ --}}
    @if(auth()->check() && auth()->id() === $user->id)
    <div class="owner-notice">
        <p>
            دي صفحتك الشخصية 🪞<br>
            شاركها وخلي الناس تبعتلك اللي جواها ❤️<br>
            <a href="{{ route('dashboard') }}">روح لصندوقك</a>
            &nbsp;·&nbsp;
            انسخ لينكك: <strong style="color:var(--primary-light)">3tab.app/{{ $user->username }}</strong>
        </p>
    </div>
    @else

    <div class="send-card" id="send-card">

        {{-- ── The form itself ── --}}
        <div id="send-form-wrap">

            {{-- Mood context block --}}
            @if($activeMood)
            <div class="mood-context-block {{ $activeMood->mood->name_en }}">
                <span class="mood-ctx-emoji">{{ $activeMood->mood->emoji }}</span>
                <div>
                    <div class="mood-ctx-text">{{ $moodEngine['profile_sub'] }}</div>
                    <span class="mood-ctx-cta">{{ $moodEngine['profile_cta'] }}</span>
                </div>
            </div>
            @endif

            <textarea
                id="atab-body"
                class="send-textarea"
                maxlength="1000"
                placeholder="{{ $activeMood ? $moodEngine['placeholder'] : 'قول اللي نفسك تقوله ومش عارف تقوله وش لوش…' }}"
                oninput="onBodyInput(this)"
                autofocus
            ></textarea>
            <div class="send-error" id="send-error">⚠️ اكتب على الأقل 3 حروف قبل ما تبعت</div>

            <p class="urgency-line">
                <span class="urgency-dot"></span>
                ⏳ متفكرش كتير… قولها قبل ما تندم
            </p>

            <div class="anon-row">
                <button class="anon-btn active-anon" id="btn-anon" type="button" onclick="setAnon(true)">🎭 بدون اسم</button>
                <button class="anon-btn" id="btn-named" type="button" onclick="setAnon(false)">👤 باسمي</button>
            </div>

            <button class="btn-send-big" id="btn-send" onclick="submitAtab()">
                💌 ابعت اللي جواك دلوقتي
            </button>

            <div class="send-footer-meta">
                <span class="char-c" id="char-c">0 / 1000</span>
                @auth
                <span style="font-size:.73rem;color:var(--muted)">بتبعت باسم <strong style="color:var(--primary-light)">{{ auth()->user()->name }}</strong></span>
                @endauth
            </div>
        </div>

        {{-- ── Auth-sent notice (logged in users) ── --}}
        <div class="auth-sent-notice" id="auth-sent-notice">
            <span style="font-size:1.8rem">✅</span>
            <div>
                <p style="font-size:.92rem;font-weight:600;color:var(--text)">اتبعت عتابك!</p>
                <p style="font-size:.8rem;color:var(--muted)">هيوصله وتعرف لما يقراه 👀</p>
            </div>
        </div>

    </div>

    {{-- ── Social proof ── --}}
    <div class="social-proof" id="social-proof">
        <span class="proof-fire">🔥</span>
        <div class="proof-avatars">
            <div class="proof-av">م</div>
            <div class="proof-av">أ</div>
            <div class="proof-av">س</div>
        </div>
        <span>
            @if($stats['today'] > 0)
                <strong style="color:var(--primary-light)">{{ $stats['today'] }}</strong> بعتوا عتاباتهم النهاردة
            @elseif($stats['total'] > 0)
                <strong style="color:var(--primary-light)">{{ $stats['total'] }}</strong> شخص بعت لـ {{ $user->name }} من قبل
            @else
                كون أول واحد يقول اللي جواه لـ {{ $user->name }} 👀
            @endif
        </span>
    </div>

    {{-- ── Post-send viral share (guest) ── --}}
    @guest
    <div class="viral-share" id="viral-share">
        <p class="viral-share-title">📤 شارك صفحتك وخلي الناس تقولك اللي جوّاها</p>
        <p class="viral-share-sub">سجّل حسابك وانشر لينكك — وخلي كل الناس اللي عندهم كلام يبعتوهولك بصراحة 🔥</p>
        <button class="btn-viral-share" onclick="viralShare()">📤 شارك وخلي الناس تتكلم</button>
        <div class="viral-copy-row">
            <span class="viral-copy-url">3tab.app/{{ $user->username }}</span>
            <button class="viral-copy-btn" onclick="copyProfileUrl(this)">نسخ اللينك</button>
        </div>
    </div>
    @endguest

    @endif {{-- end owner check --}}

    {{-- ══ MOOD SHARE CARD (owner only) ══ --}}
    @if(auth()->check() && auth()->id() === $user->id && $activeMood)
    <div class="mood-share-card">
        <div class="mood-share-title">{{ $activeMood->mood->emoji }} شارك حالتك وخلي الناس تتكلم</div>
        <div class="mood-share-sub">الرسالة دي هتتبعت مع رابطك — اضغط ونشر</div>
        <div class="mood-share-preview" id="mood-share-preview">{{ $shareText }}</div>
        <div class="mood-share-btns">
            <button class="mood-sbtn ms-wa" onclick="moodShareWa()">📱 واتساب</button>
            <button class="mood-sbtn ms-tw" onclick="moodShareTw()">𝕏 تويتر</button>
            <button class="mood-sbtn ms-cp" id="ms-cp-btn" onclick="moodShareCopy()">📋 نسخ</button>
        </div>
    </div>
    @endif

    {{-- ══ STATS STRIP ══ --}}
    @if($stats['total'] > 0)
    <div class="stats-strip">
        <div class="sstat">
            <div class="sstat-val">{{ $stats['total'] }}</div>
            <div class="sstat-label">عتاب كلي</div>
        </div>
        <div class="sstat" style="--primary:#7A9E8E;--glow:rgba(122,158,142,.2);--glow2:rgba(122,158,142,.35)">
            <div class="sstat-val" style="color:var(--sage)">{{ $stats['reconciled'] }}</div>
            <div class="sstat-label">صافي يا لبن 🥛</div>
        </div>
        <div class="sstat">
            <div class="sstat-val" style="color:var(--muted);font-size:1.5rem">{{ $stats['anonymous_pct'] }}%</div>
            <div class="sstat-label">مجهولين 🎭</div>
        </div>
    </div>
    @endif

</div>{{-- .page --}}

{{-- ══ POST-SEND MODAL (guest) ══ --}}
@guest
<div class="modal-overlay" id="postsend-modal">
    <div class="modal-box">
        <div class="modal-glow"></div>
        <div class="modal-icon">✅</div>
        <h2 class="modal-title">اتبعت رسالتك ❤️</h2>
        <p class="modal-sub">
            👀 تحب تعرف الرد؟<br>
            <strong>سجّل حسابك دلوقتي</strong> وهتشوف لما يردّ عليك
        </p>
        <a href="{{ route('register') }}">
            <button class="btn-modal-reg">🚀 سجّل وشوف الرد</button>
        </a>
        <div class="modal-share-row">
            <button class="btn-modal-share" onclick="modalShare()">📤 شارك صفحتك</button>
            <button class="btn-modal-share" onclick="modalCopy()">🔗 انسخ لينكك</button>
        </div>
        <button class="btn-modal-skip" onclick="closeModal()">مش دلوقتي</button>
    </div>
</div>
@endguest

<script>
(function(){
    /* ── state ── */
    let isAnon  = true;
    let sending = false;

    const CSRF      = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
    const $         = id => document.getElementById(id);

    /* ── anon toggle ── */
    window.setAnon = function(val) {
        isAnon = val;
        $('btn-anon' )?.classList.toggle('active-anon' ,  val);
        $('btn-named')?.classList.toggle('active-anon' ,  false);
        $('btn-anon' )?.classList.toggle('active-named',  false);
        $('btn-named')?.classList.toggle('active-named', !val);
    };

    /* ── char counter ── */
    window.onBodyInput = function(ta) {
        const n = ta.value.length;
        $('char-c').textContent = n + ' / 1000';
        if (n >= 3) $('send-error').style.display = 'none';
    };

    /* ── submit ── */
    window.submitAtab = async function() {
        if (sending) return;
        const body = $('atab-body')?.value?.trim() || '';
        if (body.length < 3) {
            $('send-error').style.display = 'block';
            $('atab-body')?.focus();
            return;
        }

        sending = true;
        const btn = $('btn-send');
        if (btn) { btn.disabled = true; btn.textContent = '⏳ جاري الإرسال…'; }

        try {
            const guestToken = localStorage.getItem('guest_token') || '';
            const r = await fetch('{{ route("guest.atab.store", $user->username) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF()
                },
                body: JSON.stringify({
                    body,
                    is_anonymous: isAnon,
                    guest_token: guestToken || undefined
                })
            });

            const d = await r.json();
            if (!r.ok) throw new Error(d.message || 'خطأ');

            /* save guest token */
            if (d.guest_token) localStorage.setItem('guest_token', d.guest_token);

            onSendSuccess();
        } catch(err) {
            sending = false;
            if (btn) { btn.disabled = false; btn.textContent = '💌 ابعت اللي جواك دلوقتي'; }
            $('send-error').style.display = 'block';
            $('send-error').textContent = '⚠️ ' + (err.message || 'في مشكلة، حاول تاني');
        }
    };

    /* ── success handler ── */
    function onSendSuccess() {
        @auth
            /* logged-in: show inline notice, no modal */
            const wrap = $('send-form-wrap');
            const notice = $('auth-sent-notice');
            if (wrap)   { wrap.style.opacity = '0'; wrap.style.pointerEvents = 'none'; setTimeout(() => wrap.style.display = 'none', 300); }
            if (notice) notice.classList.add('show');
        @else
            /* guest: hide form, show modal + viral strip */
            const wrap = $('send-form-wrap');
            if (wrap) wrap.style.display = 'none';
            $('social-proof')?.style && ($('social-proof').style.display = 'none');
            setTimeout(() => openModal(), 400);
        @endauth
    }

    /* ── modal ── */
    window.openModal  = function() { $('postsend-modal')?.classList.add('open'); };
    window.closeModal = function() {
        $('postsend-modal')?.classList.remove('open');
        /* show viral share strip after closing modal */
        const vs = $('viral-share');
        if (vs) vs.classList.add('show');
    };

    window.modalShare = function() {
        const url  = '{{ url("/".$user->username) }}';
        const text = 'قول لـ {{ $user->name }} اللي جواك بصراحة 👀\n' + url;
        if (navigator.share) { navigator.share({ title: 'عتاب', text, url }); }
        else { copyText(url); alert('✅ اتنسخ اللينك!'); }
    };

    window.modalCopy = function() {
        copyText('{{ url("/".$user->username) }}');
        const btn = document.querySelectorAll('.btn-modal-share')[1];
        if (btn) { btn.textContent = '✅ اتنسخ!'; setTimeout(() => btn.textContent = '🔗 انسخ لينكك', 2000); }
    };

    /* ── viral share ── */
    window.viralShare = function() {
        const url  = '{{ url("/".$user->username) }}';
        const text = 'قول لـ {{ $user->name }} اللي جواك بصراحة 👀\n' + url;
        if (navigator.share) { navigator.share({ title: 'عتاب', text, url }).catch(()=>{}); }
        else { copyText(url); alert('✅ اتنسخ اللينك!'); }
    };

    window.copyProfileUrl = function(btnEl) {
        copyText('{{ url("/".$user->username) }}');
        if (btnEl) { btnEl.textContent = '✅ اتنسخ!'; setTimeout(() => btnEl.textContent = 'نسخ اللينك', 2000); }
    };

    function copyText(txt) {
        if (navigator.clipboard) { navigator.clipboard.writeText(txt).catch(()=>{}); }
        else {
            const el = document.createElement('textarea');
            el.value = txt; el.style.position = 'fixed'; el.style.opacity = '0';
            document.body.appendChild(el); el.select(); document.execCommand('copy');
            document.body.removeChild(el);
        }
    }

    /* ── close modal on overlay click ── */
    $('postsend-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    /* ── mood expiry countdown ── */
    @if($activeMood && $activeMood->expires_at)
    (function(){
        const expiresAt = new Date('{{ $activeMood->expires_at->toIso8601String() }}');
        function updateExpiry() {
            const el = $('mood-expiry-text'); if (!el) return;
            const diff = Math.floor((expiresAt - Date.now()) / 1000);
            if (diff <= 0) { el.textContent = 'انتهت الحالة'; return; }
            const h = Math.floor(diff / 3600);
            const m = Math.floor((diff % 3600) / 60);
            el.textContent = h > 0
                ? `الحالة هتختفي بعد ${h} ساعة${m > 0 ? ` و${m} دقيقة` : ''}`
                : `الحالة هتختفي بعد ${m} دقيقة`;
        }
        updateExpiry();
        setInterval(updateExpiry, 60000);
    })();
    @endif

    /* ── mood share (owner) ── */
    @auth
    @if(auth()->id() === $user->id)
    const MOOD_SHARE_TEXT = {{ json_encode($shareText) }};
    const MOOD_PROFILE_URL = '{{ $profileUrl }}';
    window.moodShareWa   = () => window.open('https://wa.me/?text=' + encodeURIComponent(MOOD_SHARE_TEXT), '_blank');
    window.moodShareTw   = () => window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(MOOD_SHARE_TEXT), '_blank');
    window.moodShareCopy = function() {
        copyText(MOOD_SHARE_TEXT);
        const btn = $('ms-cp-btn');
        if (btn) { btn.textContent = '✅ اتنسخ!'; setTimeout(() => btn.textContent = '📋 نسخ', 2000); }
    };
    @endif
    @endauth

    /* ── link guest atabs on load (if logged in + guest_token) ── */
    @auth
    (function(){
        const gt = localStorage.getItem('guest_token');
        if (!gt) return;
        fetch('{{ route("atab.link.guest") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify({ guest_token: gt })
        }).then(() => localStorage.removeItem('guest_token')).catch(()=>{});
    })();
    @endauth

})();
</script>
</body>
</html>
