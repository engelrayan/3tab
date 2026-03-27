<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>عتاب · في حد زعلان منك ومش عارف يقولك 👀</title>
    <meta name="description" content="اعرف الناس حاسة بإيه ناحيتك… من غير إحراج. ابعت عتابك مجهول أو بالاسم وتابع الرد." />
    <meta property="og:title" content="في حد زعلان منك ومش عارف يقولك 👀" />
    <meta property="og:description" content="اعمل صفحتك واستقبل أول رسالة — عتاب.app" />
    <meta property="og:image" content="https://og-image.vercel.app/%D8%B9%D8%AA%D8%A7%D8%A8.png?theme=dark" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --p:#C6924A;--pl:#E8B96A;--pd:#A07035;
            --dark:#120b04;--dark2:#0e0802;--card:#1c1008;--card2:#221408;
            --b:rgba(198,146,74,.13);--bh:rgba(198,146,74,.38);
            --text:#F5EDE4;--muted:rgba(245,237,228,.48);--soft:rgba(245,237,228,.72);
            --glow:rgba(198,146,74,.18);--glow2:rgba(198,146,74,.35);--glow3:rgba(198,146,74,.52);
            --rose:#C2715A;--sage:#7A9E8E;--danger:#e05c5c;
        }
        html{scroll-behavior:smooth}
        body{min-height:100vh;background:var(--dark2);color:var(--text);font-family:'Tajawal',sans-serif;overflow-x:hidden}
        a{text-decoration:none;color:inherit}
        ::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:var(--dark)}::-webkit-scrollbar-thumb{background:var(--pd);border-radius:3px}

        /* ══ NAV ══ */
        .nav{
            position:sticky;top:0;z-index:200;height:62px;
            background:rgba(14,8,2,.88);backdrop-filter:blur(20px);
            border-bottom:1px solid var(--b);
            padding:0 clamp(1rem,4vw,2.5rem);
            display:flex;align-items:center;justify-content:space-between;
        }
        .nav-logo{font-family:'Amiri',serif;font-size:2rem;background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 10px var(--glow))}
        .nav-links{display:flex;align-items:center;gap:.55rem}
        .btn-ghost{padding:.45rem 1.2rem;border-radius:999px;font-family:'Tajawal',sans-serif;font-size:.86rem;font-weight:500;background:transparent;border:1px solid var(--b);color:var(--muted);cursor:pointer;transition:all .25s}
        .btn-ghost:hover{border-color:var(--p);color:var(--pl);box-shadow:0 0 12px var(--glow)}
        .btn-nav-cta{padding:.48rem 1.3rem;border-radius:999px;font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:700;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);cursor:pointer;transition:all .28s;box-shadow:0 3px 14px var(--glow2)}
        .btn-nav-cta:hover{transform:translateY(-1px);box-shadow:0 6px 20px var(--glow3)}

        /* ══ STICKY CTA (appears on scroll) ══ */
        .sticky-cta{
            position:fixed;bottom:1.2rem;left:50%;transform:translateX(-50%) translateY(100px);
            z-index:300;opacity:0;transition:all .4s cubic-bezier(.34,1.4,.64,1);
            padding:.78rem 2.2rem;border-radius:999px;border:none;
            background:linear-gradient(135deg,var(--pl),var(--p));
            color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.95rem;font-weight:800;
            cursor:pointer;box-shadow:0 8px 32px rgba(198,146,74,.55),0 2px 8px rgba(0,0,0,.5);
            white-space:nowrap;
        }
        .sticky-cta.show{opacity:1;transform:translateX(-50%) translateY(0)}
        .sticky-cta:hover{box-shadow:0 12px 40px rgba(198,146,74,.7)}

        /* ══ BG EFFECTS ══ */
        .bg-glow-top{position:fixed;top:-180px;right:-80px;width:550px;height:550px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.055),transparent 65%);pointer-events:none;z-index:0}
        .bg-glow-bot{position:fixed;bottom:-150px;left:-80px;width:480px;height:480px;border-radius:50%;background:radial-gradient(circle,rgba(194,113,90,.045),transparent 65%);pointer-events:none;z-index:0}

        /* ══ HERO ══ */
        .hero{
            max-width:760px;margin:0 auto;
            padding:clamp(3rem,7vw,5.5rem) 1.5rem clamp(2rem,4vw,3.5rem);
            text-align:center;position:relative;z-index:1;
        }
        /* urgency badge */
        .urgency-badge{
            display:inline-flex;align-items:center;gap:.5rem;
            background:rgba(224,92,92,.12);border:1px solid rgba(224,92,92,.3);
            border-radius:999px;padding:.38rem 1.1rem;
            font-size:.8rem;color:#ff8585;font-weight:600;
            margin-bottom:1.6rem;
            animation:badgePulse 2.5s ease-in-out infinite, fadeUp .5s ease both;
        }
        .urgency-dot{width:7px;height:7px;border-radius:50%;background:#e05c5c;box-shadow:0 0 6px #e05c5c;animation:blink 1.2s ease-in-out infinite}
        @keyframes badgePulse{0%,100%{box-shadow:0 0 0 0 rgba(224,92,92,0)}50%{box-shadow:0 0 12px 3px rgba(224,92,92,.12)}}
        @keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}

        .hero-title{
            font-family:'Amiri',serif;
            font-size:clamp(2.4rem,6.5vw,4.8rem);
            line-height:1.18;color:var(--text);
            margin-bottom:1rem;
            animation:fadeUp .55s .08s ease both;
        }
        .hero-title .hl{background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 18px var(--glow2))}
        .hero-sub{
            font-size:clamp(.95rem,2.5vw,1.12rem);color:var(--muted);
            line-height:1.9;max-width:520px;margin:0 auto 2rem;
            animation:fadeUp .55s .16s ease both;
        }
        .hero-cta{display:flex;gap:.8rem;justify-content:center;flex-wrap:wrap;animation:fadeUp .55s .24s ease both;margin-bottom:1.4rem}
        .btn-hero-main{
            padding:.9rem 2rem;border-radius:14px;border:none;
            background:linear-gradient(135deg,var(--pl),var(--p));
            color:var(--dark2);font-family:'Tajawal',sans-serif;
            font-size:1rem;font-weight:800;cursor:pointer;
            transition:all .3s;box-shadow:0 5px 24px var(--glow2);
            display:inline-block;
        }
        .btn-hero-main:hover{transform:translateY(-3px);box-shadow:0 10px 34px var(--glow3)}
        .btn-hero-ghost{
            padding:.88rem 1.7rem;border-radius:14px;
            background:transparent;border:1px solid var(--bh);color:var(--pl);
            font-family:'Tajawal',sans-serif;font-size:.95rem;font-weight:600;
            cursor:pointer;transition:all .25s;display:inline-block;
        }
        .btn-hero-ghost:hover{background:rgba(198,146,74,.08);box-shadow:0 0 18px var(--glow)}

        /* Social proof ticker */
        .social-proof-ticker{
            display:inline-flex;align-items:center;gap:.5rem;
            font-size:.78rem;color:var(--muted);
            animation:fadeUp .55s .32s ease both;
        }
        .sp-dot{width:6px;height:6px;border-radius:50%;background:var(--sage);box-shadow:0 0 5px var(--sage);flex-shrink:0}

        /* ══ BUBBLE MESSAGES ══ */
        .bubbles-wrap{
            max-width:700px;margin:0 auto;
            padding:0 1.5rem clamp(2.5rem,5vw,4.5rem);
            position:relative;z-index:1;
        }
        .bubbles-label{text-align:center;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:1.2rem}
        .bubbles-grid{display:flex;flex-direction:column;gap:.85rem}
        .bubble-item{
            display:flex;align-items:flex-end;gap:.75rem;
            animation:fadeUp .6s ease both;
        }
        .bubble-item:nth-child(2){animation-delay:.1s}
        .bubble-item:nth-child(3){animation-delay:.2s}
        .bubble-item.right{flex-direction:row-reverse}
        .bubble-av{
            width:38px;height:38px;border-radius:50%;flex-shrink:0;
            display:flex;align-items:center;justify-content:center;
            font-size:1.1rem;border:2px solid var(--b);
        }
        .bubble-body{max-width:76%}
        .bubble{
            border-radius:20px;padding:.8rem 1.15rem;
            line-height:1.75;font-size:.9rem;position:relative;
        }
        .bubble.incoming{
            background:linear-gradient(135deg,rgba(198,146,74,.15),rgba(198,146,74,.07));
            border:1px solid rgba(198,146,74,.2);border-top-right-radius:4px;
            color:var(--text);
        }
        .bubble.outgoing{
            background:rgba(0,0,0,.35);border:1px solid var(--b);
            border-top-left-radius:4px;color:var(--soft);
        }
        .bubble-time{font-size:.68rem;color:var(--muted);margin-top:.3rem;padding:0 .2rem}
        .bubble-item.right .bubble-time{text-align:left}

        /* read receipt */
        .read-receipt{display:inline-flex;align-items:center;gap:.3rem;font-size:.7rem;color:var(--sage);background:rgba(122,158,142,.1);border:1px solid rgba(122,158,142,.2);border-radius:999px;padding:.15rem .6rem;margin-top:.3rem}

        /* ══ HOW IT WORKS ══ */
        .section{padding:clamp(2rem,5vw,4rem) clamp(1rem,4vw,2.5rem);position:relative;z-index:1}
        .section-inner{max-width:1100px;margin:0 auto}
        .section-label{text-align:center;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem}
        .section-title{text-align:center;font-family:'Amiri',serif;font-size:clamp(1.7rem,4vw,2.5rem);color:var(--text);margin-bottom:.6rem}
        .section-sub{text-align:center;font-size:.9rem;color:var(--muted);max-width:480px;margin:0 auto 2.5rem;line-height:1.85}

        .steps{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
        .step-card{
            background:var(--card);border:1px solid var(--b);border-radius:20px;
            padding:1.6rem 1.3rem;position:relative;overflow:hidden;
            transition:all .35s cubic-bezier(.34,1.4,.64,1);
            box-shadow:0 4px 18px rgba(0,0,0,.35);
        }
        .step-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p),transparent);opacity:0;transition:opacity .3s}
        .step-card:hover{transform:translateY(-7px);border-color:var(--bh);box-shadow:0 16px 40px rgba(0,0,0,.5),0 0 20px var(--glow)}
        .step-card:hover::before{opacity:1}
        .step-num{
            width:34px;height:34px;border-radius:50%;
            background:linear-gradient(135deg,var(--pl),var(--p));
            display:flex;align-items:center;justify-content:center;
            font-family:'Amiri',serif;font-size:1rem;font-weight:700;
            color:var(--dark2);margin-bottom:.9rem;box-shadow:0 3px 10px var(--glow2);
        }
        .step-icon{font-size:1.7rem;margin-bottom:.7rem;line-height:1;display:block}
        .step-title{font-family:'Amiri',serif;font-size:1.1rem;color:var(--text);margin-bottom:.4rem}
        .step-desc{font-size:.81rem;color:var(--muted);line-height:1.75}

        /* ══ CURIOSITY BLOCK ══ */
        .curiosity-block{
            max-width:700px;margin:0 auto;
            padding:clamp(1.5rem,4vw,3rem) clamp(1rem,4vw,2rem);
            text-align:center;position:relative;z-index:1;
        }
        .curiosity-inner{
            background:linear-gradient(145deg,rgba(198,146,74,.08),rgba(194,113,90,.05));
            border:1px solid rgba(198,146,74,.2);border-radius:24px;
            padding:2.5rem 2rem;position:relative;overflow:hidden;
        }
        .curiosity-inner::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--rose),var(--p),var(--pl))}
        .curiosity-quote{font-family:'Amiri',serif;font-size:clamp(1.3rem,3.5vw,2rem);color:var(--text);line-height:1.55;margin-bottom:1rem}
        .curiosity-sub{font-size:.85rem;color:var(--muted);line-height:1.8}

        /* ══ FEATURES ══ */
        .features{display:grid;grid-template-columns:repeat(2,1fr);gap:.85rem}
        .feat-card{
            background:var(--card);border:1px solid var(--b);border-radius:18px;
            padding:1.25rem 1.2rem;display:flex;gap:.9rem;align-items:flex-start;
            transition:all .28s;box-shadow:0 3px 14px rgba(0,0,0,.28);
        }
        .feat-card:hover{border-color:var(--bh);transform:translateY(-4px);box-shadow:0 10px 28px rgba(0,0,0,.42),0 0 14px var(--glow)}
        .feat-icon{font-size:1.5rem;flex-shrink:0;margin-top:.05rem}
        .feat-body h4{font-family:'Amiri',serif;font-size:1rem;color:var(--text);margin-bottom:.25rem}
        .feat-body p{font-size:.79rem;color:var(--muted);line-height:1.7}

        /* ══ SHARE SECTION ══ */
        .share-section{
            background:linear-gradient(145deg,var(--card2),var(--card));
            border-top:1px solid var(--b);border-bottom:1px solid var(--b);
            padding:clamp(2rem,5vw,3.5rem) clamp(1rem,4vw,2rem);
            position:relative;z-index:1;
        }
        .share-inner{max-width:700px;margin:0 auto;text-align:center}
        .share-title{font-family:'Amiri',serif;font-size:clamp(1.6rem,4vw,2.3rem);color:var(--text);margin-bottom:.5rem}
        .share-sub{font-size:.88rem;color:var(--muted);margin-bottom:1.8rem;line-height:1.8}
        .share-msg-preview{
            background:rgba(0,0,0,.3);border:1px dashed rgba(198,146,74,.25);
            border-radius:14px;padding:.9rem 1.2rem;
            font-size:.84rem;color:var(--soft);line-height:1.75;
            margin-bottom:1.4rem;text-align:right;
            font-style:italic;
        }
        .share-btns{display:flex;gap:.7rem;justify-content:center;flex-wrap:wrap}
        .share-btn{
            padding:.65rem 1.35rem;border-radius:12px;border:1px solid;
            font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:600;
            cursor:pointer;transition:all .25s;display:inline-flex;align-items:center;gap:.5rem;
        }
        .share-btn-wa{background:rgba(37,211,102,.1);border-color:rgba(37,211,102,.25);color:#25d366}
        .share-btn-wa:hover{background:rgba(37,211,102,.2);border-color:rgba(37,211,102,.5)}
        .share-btn-fb{background:rgba(24,119,242,.1);border-color:rgba(24,119,242,.25);color:#1877f2}
        .share-btn-fb:hover{background:rgba(24,119,242,.2);border-color:rgba(24,119,242,.5)}
        .share-btn-tw{background:rgba(29,161,242,.1);border-color:rgba(29,161,242,.25);color:#1da1f2}
        .share-btn-tw:hover{background:rgba(29,161,242,.2);border-color:rgba(29,161,242,.5)}
        .share-btn-copy{background:rgba(198,146,74,.1);border-color:rgba(198,146,74,.25);color:var(--pl)}
        .share-btn-copy:hover{background:rgba(198,146,74,.2);border-color:rgba(198,146,74,.5)}
        .share-register-hint{font-size:.77rem;color:rgba(245,237,228,.3);margin-top:1rem}
        .share-register-hint a{color:var(--p)}

        /* ══ TESTIMONIALS ══ */
        .quotes{display:grid;grid-template-columns:repeat(3,1fr);gap:.85rem}
        .quote-card{
            background:var(--card);border:1px solid var(--b);border-radius:18px;
            padding:1.3rem;position:relative;transition:all .28s;
            box-shadow:0 3px 14px rgba(0,0,0,.28);
        }
        .quote-card:hover{border-color:var(--bh);transform:translateY(-5px);box-shadow:0 12px 30px rgba(0,0,0,.45)}
        .quote-mark{font-family:'Amiri',serif;font-size:3.5rem;color:rgba(198,146,74,.1);position:absolute;top:-.5rem;right:1rem;line-height:1}
        .quote-text{font-size:.86rem;color:var(--soft);line-height:1.85;margin-bottom:.9rem;position:relative;z-index:1}
        .quote-author{display:flex;align-items:center;gap:.55rem}
        .q-av{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:.9rem;color:var(--dark2);font-weight:700}
        .q-name{font-size:.75rem;color:var(--muted)}

        /* ══ FINAL CTA ══ */
        .cta-section{
            background:linear-gradient(145deg,var(--card2),var(--card));
            border:1px solid var(--bh);border-radius:28px;
            padding:clamp(2.5rem,6vw,4rem) 2rem;text-align:center;
            position:relative;overflow:hidden;
            box-shadow:0 20px 60px rgba(0,0,0,.6);
            max-width:720px;margin:0 auto;
        }
        .cta-section::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--rose),var(--p),var(--pl),var(--rose))}
        .cta-glow{position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.09),transparent 65%);pointer-events:none}
        .cta-section h2{font-family:'Amiri',serif;font-size:clamp(1.8rem,4.5vw,2.8rem);color:var(--text);margin-bottom:.7rem;position:relative;z-index:1;line-height:1.3}
        .cta-section p{font-size:.92rem;color:var(--muted);margin-bottom:2rem;line-height:1.9;max-width:430px;margin-left:auto;margin-right:auto;position:relative;z-index:1}
        .cta-btns{display:flex;gap:.85rem;justify-content:center;flex-wrap:wrap;position:relative;z-index:1}
        .cta-btn-main{padding:.95rem 2.4rem;border-radius:14px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:1.05rem;font-weight:800;cursor:pointer;transition:all .3s;box-shadow:0 5px 22px var(--glow2);display:inline-block}
        .cta-btn-main:hover{transform:translateY(-3px);box-shadow:0 10px 32px var(--glow3)}
        .cta-btn-sec{padding:.9rem 1.9rem;border-radius:14px;border:1px solid var(--bh);background:transparent;color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.95rem;font-weight:600;cursor:pointer;transition:all .28s;display:inline-block}
        .cta-btn-sec:hover{background:rgba(198,146,74,.1);box-shadow:0 0 20px var(--glow)}

        /* ══ FOOTER ══ */
        footer{text-align:center;padding:2.5rem 1.5rem 3.5rem;border-top:1px solid var(--b);position:relative;z-index:1;margin-top:3rem}
        .foot-logo{font-family:'Amiri',serif;font-size:2rem;background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;display:block;margin-bottom:.3rem;filter:drop-shadow(0 0 8px var(--glow))}
        .foot-quote{font-family:'Amiri',serif;font-style:italic;font-size:.88rem;color:var(--muted);margin-bottom:.5rem}
        .foot-copy{font-size:.75rem;color:rgba(245,237,228,.22)}

        /* ══ ANIMATIONS ══ */
        @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
        .float-anim{animation:float 4s ease-in-out infinite}

        .reveal{opacity:0;transform:translateY(20px);transition:opacity .6s ease,transform .6s ease}
        .reveal.visible{opacity:1;transform:translateY(0)}

        /* ══ STATS ROW ══ */
        .stats-row{
            display:flex;justify-content:center;gap:clamp(1.5rem,5vw,4rem);
            flex-wrap:wrap;padding:1.5rem 1rem;
            border-bottom:1px solid var(--b);
            position:relative;z-index:1;
            background:rgba(0,0,0,.2);
        }
        .stat-item{text-align:center}
        .stat-num{font-family:'Amiri',serif;font-size:clamp(1.5rem,4vw,2.2rem);color:var(--pl);display:block;font-weight:700}
        .stat-lbl{font-size:.75rem;color:var(--muted)}

        /* ══ RESPONSIVE ══ */
        @media(max-width:768px){
            .steps{grid-template-columns:1fr}
            .features{grid-template-columns:1fr}
            .quotes{grid-template-columns:1fr}
            .share-btns{gap:.5rem}
            .hero-title{line-height:1.22}
        }
        @media(max-width:500px){
            .nav-logo{font-size:1.7rem}
            .btn-ghost span{display:none}
            .hero{padding:2.5rem 1rem 2rem}
            .cta-section{border-radius:18px;margin:0 .5rem}
        }
    </style>
</head>
<body>

<div class="bg-glow-top"></div>
<div class="bg-glow-bot"></div>

{{-- ══ STICKY CTA ══ --}}
<a href="{{ route('register') }}">
    <button class="sticky-cta" id="sticky-cta">📩 اعمل صفحتك مجاناً</button>
</a>

{{-- ══ NAV ══ --}}
<nav class="nav">
    <a href="{{ route('home') }}" class="nav-logo">عتاب</a>
    <div class="nav-links">
        @auth
            <a href="{{ route('dashboard') }}"><button class="btn-ghost">صندوقي</button></a>
            <a href="{{ route('profile.show', auth()->user()->username) }}"><button class="btn-nav-cta">📎 صفحتي</button></a>
        @else
            <a href="{{ route('login') }}"><button class="btn-ghost">دخول</button></a>
            <a href="{{ route('register') }}"><button class="btn-nav-cta">ابدأ مجاناً ✨</button></a>
        @endauth
    </div>
</nav>

{{-- ══ HERO ══ --}}
<section class="hero" id="hero">
    {{-- Urgency badge --}}
    <div class="urgency-badge">
        <span class="urgency-dot"></span>
        ⚠️ ممكن يكون في رسالة مستنياك دلوقتي
    </div>

    <h1 class="hero-title">
        في حد زعلان منك<br>
        <span class="hl">ومش عارف يقولك</span> 👀
    </h1>

    <p class="hero-sub">
        اعرف الناس حاسة بإيه ناحيتك… من غير إحراج ومن غير خوف.
        ابعت عتابك مجهول أو بالاسم، وتابع لو ردّوا.
    </p>

    <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn-hero-main">📩 اعمل صفحتك واستقبل أول رسالة</a>
        <a href="{{ route('login') }}" class="btn-hero-ghost">عندك حساب؟ سجل دخول</a>
    </div>

    {{-- Live social proof ticker --}}
    <div class="social-proof-ticker">
        <span class="sp-dot"></span>
        <span id="sp-text">💬 حد استقبل رسالة من 12 ثانية</span>
    </div>
</section>

{{-- ══ STATS BAR ══ --}}
<div class="stats-row reveal">
    <div class="stat-item">
        <span class="stat-num">+5200</span>
        <span class="stat-lbl">رسالة اتبعت</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">+1800</span>
        <span class="stat-lbl">مستخدم</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">+340</span>
        <span class="stat-lbl">مصالحة تمت ❤️</span>
    </div>
    <div class="stat-item">
        <span class="stat-num">٪82</span>
        <span class="stat-lbl">شعروا بارتياح بعد إرسال العتاب</span>
    </div>
</div>

{{-- ══ EMOTIONAL BUBBLES ══ --}}
<div class="bubbles-wrap">
    <p class="bubbles-label reveal">رسائل حقيقية تتبعت كل يوم</p>

    <div class="bubbles-grid">
        {{-- bubble 1 --}}
        <div class="bubble-item reveal">
            <div class="bubble-av" style="background:rgba(198,146,74,.12)">🎭</div>
            <div class="bubble-body">
                <div class="bubble incoming">
                    كنت زعلان منك بس مش عارف أقولك ❤️<br>
                    <small style="opacity:.6;font-size:.78rem">كلام كنت بخبّيه من زمان…</small>
                </div>
                <div class="bubble-time">🎭 مجهول · منذ لحظات</div>
            </div>
        </div>

        {{-- bubble 2 --}}
        <div class="bubble-item right reveal">
            <div class="bubble-av" style="background:rgba(122,158,142,.12)">م</div>
            <div class="bubble-body">
                <div class="bubble outgoing">مفتقدك بجد… ليه بعدت؟ 💙</div>
                <div class="bubble-time">ردّ · منذ 3 دقائق</div>
                <div class="read-receipt">👁 شاف الرسالة · ينتظر ردك</div>
            </div>
        </div>

        {{-- bubble 3 --}}
        <div class="bubble-item reveal">
            <div class="bubble-av" style="background:rgba(194,113,90,.12)">ر</div>
            <div class="bubble-body">
                <div class="bubble incoming">
                    أنا غلطت في حقك وندمان… آسف بجد 🤍
                </div>
                <div class="bubble-time">رسالة باسمه · منذ ساعة</div>
            </div>
        </div>
    </div>
</div>

{{-- ══ HOW IT WORKS ══ --}}
<section class="section">
    <div class="section-inner">
        <p class="section-label reveal">كيف يعمل</p>
        <h2 class="section-title reveal">٣ خطوات بس 🚀</h2>
        <p class="section-sub reveal">ما في تعقيد — فقط صدق وتعبير</p>

        <div class="steps">
            <div class="step-card reveal float-anim" style="animation-delay:0s">
                <div class="step-num">١</div>
                <span class="step-icon">✨</span>
                <h3 class="step-title">اعمل صفحتك</h3>
                <p class="step-desc">في ثواني — اسم مستخدم وخلاص. هيبقى عندك رابط شخصي جاهز على طول.</p>
            </div>
            <div class="step-card reveal float-anim" style="animation-delay:.15s">
                <div class="step-num">٢</div>
                <span class="step-icon">📎</span>
                <h3 class="step-title">شارك اللينك</h3>
                <p class="step-desc">في البيو، في واتساب، في ستوري — أي حد يفتح رابطك يقدر يبعتلك رسالة.</p>
            </div>
            <div class="step-card reveal float-anim" style="animation-delay:.3s">
                <div class="step-num">٣</div>
                <span class="step-icon">💌</span>
                <h3 class="step-title">استقبل وارد</h3>
                <p class="step-desc">رسائل صادقة، ردّ عليها، وطلب مصالحة لو حسيت إن الوقت جه.</p>
            </div>
        </div>
    </div>
</section>

{{-- ══ CURIOSITY TRIGGER ══ --}}
<div class="curiosity-block reveal">
    <div class="curiosity-inner">
        <div class="curiosity-quote">
            "مش كل الكلام بيتقال بسهولة…<br>بس هنا <span style="color:var(--pl)">ممكن يتقال</span>"
        </div>
        <p class="curiosity-sub">
            في ناس قريبة منك بتحمل كلام من زمان — خوف، زعل، اشتياق.<br>
            عتاب بيديهم المساحة إنهم يقولوا من غير إحراج ومن غير خوف.
        </p>
    </div>
</div>

{{-- ══ SHARE SECTION ══ --}}
<div class="share-section reveal">
    <div class="share-inner">
        <h2 class="share-title">📣 خلي الناس تقولك اللي جواها</h2>
        <p class="share-sub">
            كل ما شاركت رابطك أكتر، هيجيلك عتاب أكتر.
            شارك دلوقتي وشوف مين جاهز يتكلم.
        </p>
        <div class="share-msg-preview">
            "دي صفحتي على عتاب… لو في حاجة جواك قولها بصراحة 👇"
        </div>
        <div class="share-btns">
            @auth
                <button class="share-btn share-btn-copy" onclick="copyProfileLink()">📋 انسخ رابط صفحتك</button>
                <button class="share-btn share-btn-wa" onclick="shareOnWhatsApp()">📱 واتساب</button>
                <button class="share-btn share-btn-fb" onclick="shareOnFacebook()">👥 فيسبوك</button>
                <button class="share-btn share-btn-tw" onclick="shareOnTwitter()">𝕏 تويتر</button>
            @else
                <a href="{{ route('register') }}" class="share-btn share-btn-copy" style="text-decoration:none">📎 اعمل صفحتك دلوقتي</a>
                <a href="{{ route('register') }}" class="share-btn share-btn-wa" style="text-decoration:none">📱 وشارك على واتساب</a>
            @endauth
        </div>
        <p class="share-register-hint">
            @guest
                <a href="{{ route('register') }}">سجّل مجاناً</a> عشان تاخد رابطك الشخصي وتبدأ
            @endguest
        </p>
    </div>
</div>

{{-- ══ FEATURES ══ --}}
<section class="section">
    <div class="section-inner">
        <p class="section-label reveal">المميزات</p>
        <h2 class="section-title reveal">كل اللي تحتاجه</h2>
        <p class="section-sub reveal">مصمم للتعبير الحقيقي — مش مجرد رسائل</p>

        <div class="features">
            <div class="feat-card reveal">
                <span class="feat-icon">🎭</span>
                <div class="feat-body">
                    <h4>مجهول أو بالاسم</h4>
                    <p>المرسل بيختار — الهوية محمية دايماً عشان الكلام يطلع بصدق</p>
                </div>
            </div>
            <div class="feat-card reveal">
                <span class="feat-icon">👁️</span>
                <div class="feat-body">
                    <h4>تعرف لو اتقرأت</h4>
                    <p>شوف لو فتح رسالتك ولا لأ — "تم القراءة" أو "لم يُفتح بعد"</p>
                </div>
            </div>
            <div class="feat-card reveal">
                <span class="feat-icon">💬</span>
                <div class="feat-body">
                    <h4>محادثة ورد مباشر</h4>
                    <p>مش بس رسالة — محادثة كاملة بين الاتنين بخصوصية تامة</p>
                </div>
            </div>
            <div class="feat-card reveal">
                <span class="feat-icon">🤝</span>
                <div class="feat-body">
                    <h4>طلب مصالحة ❤️</h4>
                    <p>لما حسيت إنها وصلت — اطلب مصالحة وسجّل "صافي يا لبن" رسمياً</p>
                </div>
            </div>
            <div class="feat-card reveal">
                <span class="feat-icon">📲</span>
                <div class="feat-body">
                    <h4>إرسال من غير حساب</h4>
                    <p>أي حد يفتح رابطك يقدر يبعتلك رسالة فوراً — حتى من غير تسجيل</p>
                </div>
            </div>
            <div class="feat-card reveal">
                <span class="feat-icon">🔒</span>
                <div class="feat-body">
                    <h4>حماية وخصوصية ذكية</h4>
                    <p>تحكم في مين يبعتلك، إبلاغ، حظر — مساحة آمنة للتعبير الصادق</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ TESTIMONIALS ══ --}}
<section class="section" style="padding-top:0">
    <div class="section-inner">
        <p class="section-label reveal">كلام من الناس</p>
        <h2 class="section-title reveal">رسائل غيّرت حاجة 💌</h2>

        <div class="quotes">
            <div class="quote-card reveal">
                <span class="quote-mark">"</span>
                <p class="quote-text">قلتلها كلام كنت حابس فيه سنتين — والتعبير عنه كان أهم من ردّها</p>
                <div class="quote-author">
                    <div class="q-av" style="background:linear-gradient(135deg,var(--pl),var(--p))">م</div>
                    <span class="q-name">🎭 مجهول · عتاب لصديق</span>
                </div>
            </div>
            <div class="quote-card reveal">
                <span class="quote-mark">"</span>
                <p class="quote-text">ما كنت أتوقع إنه يرد — بس كتب رد طوّل وطلب المصالحة 🤍</p>
                <div class="quote-author">
                    <div class="q-av" style="background:linear-gradient(135deg,var(--sage),#5a8a7a)">ن</div>
                    <span class="q-name">نور · بعد 3 أيام من العتاب</span>
                </div>
            </div>
            <div class="quote-card reveal">
                <span class="quote-mark">"</span>
                <p class="quote-text">جاتني رسائل من ناس ما كنت أتوقع — التجربة بتفتح العيون 👀</p>
                <div class="quote-author">
                    <div class="q-av" style="background:linear-gradient(135deg,var(--rose),#a0503a)">ع</div>
                    <span class="q-name">عبدالله · بعد أسبوع من المشاركة</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ FINAL CTA ══ --}}
<section class="section">
    <div class="section-inner">
        <div class="cta-section reveal">
            <div class="cta-glow"></div>
            <h2>جاهز تعرف الناس<br>حاسة بإيه ناحيتك؟</h2>
            <p>
                اعمل صفحتك مجاناً في ثواني، شارك اللينك،<br>
                وخلّي اللي جواهم يطلع من غير إحراج 💌
            </p>
            <div class="cta-btns">
                <a href="{{ route('register') }}" class="cta-btn-main">📩 ابدأ الآن مجاناً</a>
                <a href="{{ route('login') }}" class="cta-btn-sec">لديك حساب؟ دخول</a>
            </div>
        </div>
    </div>
</section>

{{-- ══ FOOTER ══ --}}
<footer>
    <span class="foot-logo">عتاب</span>
    <p class="foot-quote">"ما محبة إلا بعد عتاب"</p>
    <p class="foot-copy">3tab.app · جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
</footer>

<script>
// ── Sticky CTA ──
window.addEventListener('scroll', () => {
    const hero = document.getElementById('hero');
    const heroBtm = hero ? hero.getBoundingClientRect().bottom : 0;
    const cta = document.getElementById('sticky-cta');
    if (cta) cta.classList.toggle('show', heroBtm < 0);
});

// ── Reveal on scroll ──
const revealEls = document.querySelectorAll('.reveal');
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
}, { threshold: 0.12 });
revealEls.forEach(el => io.observe(el));

// ── Social proof ticker ──
const proofMessages = [
    '💬 حد استقبل رسالة من 12 ثانية',
    '🔥 +1200 رسالة اتبعت النهاردة',
    '🤝 مصالحة جديدة منذ 3 دقائق',
    '👀 حد فتح رسالة من 30 ثانية',
    '💌 رسالة جديدة وصلت للتو',
    '🎭 5 رسائل مجهولة اتبعت دلوقتي',
];
let spIdx = 0;
const spEl = document.getElementById('sp-text');
function rotateSP() {
    spIdx = (spIdx + 1) % proofMessages.length;
    spEl.style.opacity = '0';
    setTimeout(() => {
        spEl.textContent = proofMessages[spIdx];
        spEl.style.opacity = '1';
        spEl.style.transition = 'opacity .4s ease';
    }, 350);
}
setInterval(rotateSP, 3500);

// ── Share functions (for logged-in users) ──
@auth
const PROFILE_URL = '{{ route("profile.show", auth()->user()->username) }}';
const SHARE_TEXT  = encodeURIComponent('دي صفحتي على عتاب… لو في حاجة جواك قولها بصراحة 👇\n' + '{{ route("profile.show", auth()->user()->username) }}');
function copyProfileLink() {
    navigator.clipboard.writeText(PROFILE_URL).then(() => {
        const btn = event.target;
        const orig = btn.textContent;
        btn.textContent = '✅ اتنسخ!';
        btn.style.color = '#7A9E8E';
        setTimeout(() => { btn.textContent = orig; btn.style.color = ''; }, 2000);
    });
}
function shareOnWhatsApp() { window.open('https://wa.me/?text=' + SHARE_TEXT, '_blank') }
function shareOnFacebook() { window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(PROFILE_URL), '_blank') }
function shareOnTwitter()  { window.open('https://twitter.com/intent/tweet?text=' + SHARE_TEXT, '_blank') }
@else
function copyProfileLink() { window.location = '{{ route("register") }}' }
function shareOnWhatsApp() { window.location = '{{ route("register") }}' }
function shareOnFacebook() { window.location = '{{ route("register") }}' }
function shareOnTwitter()  { window.location = '{{ route("register") }}' }
@endauth
</script>
</body>
</html>
