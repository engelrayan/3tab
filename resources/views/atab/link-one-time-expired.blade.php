<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>انتهت صلاحية الرسالة · عتاب</title>
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
            --rose:#C2715A;
        }
        html, body {
            min-height:100vh; background:var(--dark2); color:var(--text);
            font-family:'Tajawal',sans-serif;
        }
        .page {
            min-height:100vh; display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            padding:2rem 1rem; position:relative; overflow:hidden;
        }

        /* BG */
        .bg-glow-1 { position:fixed; top:-120px; right:-120px; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(194,113,90,.07),transparent 70%); pointer-events:none; }
        .bg-glow-2 { position:fixed; bottom:-100px; left:-100px; width:350px; height:350px; border-radius:50%; background:radial-gradient(circle,rgba(198,146,74,.05),transparent 70%); pointer-events:none; }
        .bg-orn { position:fixed; font-family:'Amiri',serif; font-size:22rem; color:rgba(198,146,74,.025); user-select:none; pointer-events:none; line-height:1; }
        .bg-orn.r { bottom:-3rem; left:-2rem; }
        .bg-orn.l { top:-3rem; right:-2rem; }

        /* Logo */
        .logo {
            position:absolute; top:1.5rem; right:50%; transform:translateX(50%);
            font-family:'Amiri',serif; font-size:1.6rem;
            background:linear-gradient(135deg,var(--pl),var(--p));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            background-clip:text; filter:drop-shadow(0 0 10px var(--glow));
            z-index:10; text-decoration:none;
        }

        /* Card */
        .card {
            width:100%; max-width:420px;
            background:linear-gradient(145deg,#221408,#1a0f06);
            border:1px solid rgba(194,113,90,.2); border-radius:28px;
            padding:2.8rem 2rem;
            box-shadow:0 20px 60px rgba(0,0,0,.6), 0 0 40px rgba(194,113,90,.06);
            position:relative; overflow:hidden;
            animation:fadeUp .6s ease both;
            text-align:center;
        }
        .card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
            background:linear-gradient(90deg,var(--rose),rgba(194,113,90,.4),var(--rose));
        }

        /* Lock icon */
        .lock-wrap {
            width:90px; height:90px; margin:0 auto 1.5rem;
            border-radius:50%;
            background:linear-gradient(135deg,rgba(194,113,90,.12),rgba(194,113,90,.04));
            border:1.5px solid rgba(194,113,90,.25);
            display:flex; align-items:center; justify-content:center;
            font-size:2.4rem;
            animation:lockPulse 3s ease-in-out infinite;
        }
        @keyframes lockPulse {
            0%,100% { box-shadow:0 0 0 0 rgba(194,113,90,0); }
            50%      { box-shadow:0 0 0 14px rgba(194,113,90,.08); }
        }

        /* Text */
        .expired-title {
            font-family:'Amiri',serif; font-size:1.75rem;
            color:var(--text); margin-bottom:.6rem; line-height:1.4;
        }
        .expired-title span { color:rgba(194,113,90,.85); }
        .expired-sub {
            font-size:.88rem; color:var(--muted); line-height:1.85;
            margin-bottom:2rem;
        }
        .expired-sub strong { color:var(--pl); }

        /* Divider */
        .divider {
            display:flex; align-items:center; gap:.8rem; margin-bottom:1.5rem;
        }
        .divider::before, .divider::after {
            content:''; flex:1; height:1px; background:var(--b);
        }
        .divider span { font-size:.72rem; color:var(--muted); white-space:nowrap; }

        /* Buttons */
        .btn-main {
            display:block; width:100%; padding:.9rem; border-radius:14px; border:none;
            background:linear-gradient(135deg,var(--pl),var(--p));
            color:var(--dark2); font-family:'Tajawal',sans-serif;
            font-size:1rem; font-weight:700; cursor:pointer;
            transition:all .3s; box-shadow:0 4px 18px var(--glow2);
            text-decoration:none; margin-bottom:.75rem;
        }
        .btn-main:hover { transform:translateY(-2px); box-shadow:0 8px 28px var(--glow3); }
        .btn-outline {
            display:block; width:100%; padding:.82rem; border-radius:14px;
            background:rgba(198,146,74,.07); border:1px solid var(--bh);
            color:var(--pl); font-family:'Tajawal',sans-serif;
            font-size:.93rem; font-weight:600; cursor:pointer;
            transition:all .25s; text-decoration:none;
        }
        .btn-outline:hover { background:rgba(198,146,74,.15); }

        /* Why box */
        .why-box {
            background:rgba(0,0,0,.25); border:1px solid rgba(198,146,74,.08);
            border-radius:14px; padding:1rem 1.2rem; margin-top:1.5rem;
            text-align:right;
        }
        .why-box p { font-size:.78rem; color:rgba(245,237,228,.38); line-height:1.8; }
        .why-box strong { color:rgba(245,237,228,.55); }

        /* Footer */
        .footer-brand { margin-top:2rem; font-size:.78rem; color:rgba(245,237,228,.22); }
        .footer-brand a { color:var(--p); text-decoration:none; }

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

        <div class="lock-wrap">🔒</div>

        <h1 class="expired-title">
            انتهت صلاحية<br><span>هذه الرسالة</span>
        </h1>

        <p class="expired-sub">
            هذه الرسالة كانت صالحة للعرض <strong>مرة واحدة فقط</strong><br>
            وقد تم فتحها بالفعل.<br><br>
            لو عايز تشوف الرسائل وترد عليها، سجّل حسابك
        </p>

        <div class="divider"><span>✨ سجّل وارجع للرسالة تاني</span></div>

        <a href="{{ route('register') }}" class="btn-main">
            سجّل الآن 👀
        </a>
        <a href="{{ route('login') }}" class="btn-outline">
            تسجيل الدخول
        </a>

        <div class="why-box">
            <p>
                <strong>ليه التسجيل؟</strong><br>
                المستخدمون المسجّلون يمكنهم رؤية رسائلهم في أي وقت، الرد عليها، وطلب المصالحة — بغض النظر عن قيود العرض المرة الواحدة.
            </p>
        </div>
    </div>

    <div class="footer-brand">
        <a href="{{ route('home') }}">عتاب</a> · مساحة للصدق العاطفي
    </div>
</div>
</body>
</html>
