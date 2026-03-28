<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كود التحقق — عتاب</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body  { background: #0d0703; font-family: 'Segoe UI', Tahoma, Arial, sans-serif; padding: 40px 16px; }
        .card { max-width: 480px; margin: 0 auto; background: #1f1209; border-radius: 20px; overflow: hidden; border: 1px solid rgba(198,146,74,.25); }

        /* ── Header ── */
        .hd   { background: linear-gradient(135deg, #1a0d06 0%, #2e1a0e 60%, #3d2010 100%); padding: 28px 30px; text-align: center; border-bottom: 1px solid rgba(198,146,74,.15); }
        .logo { font-size: 30px; font-weight: 900; color: #E8B96A; letter-spacing: 1px; }
        .logo-sub { font-size: 12px; color: rgba(232,185,106,.45); margin-top: 4px; }

        /* ── Body ── */
        .bd   { padding: 36px 30px; text-align: center; }
        .ttl  { font-size: 20px; font-weight: 700; color: #F5EDE4; margin-bottom: 8px; }
        .sub  { font-size: 14px; color: rgba(245,237,228,.45); line-height: 1.7; margin-bottom: 28px; }

        /* ── OTP box ── */
        .otp-wrap { background: rgba(198,146,74,.06); border: 1.5px dashed rgba(198,146,74,.3); border-radius: 16px; padding: 22px 16px; margin-bottom: 20px; }
        .otp-label { font-size: 11px; color: rgba(198,146,74,.5); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px; }
        .otp-code  { font-size: 44px; font-weight: 900; letter-spacing: 16px; color: #E8B96A; direction: ltr; display: inline-block; font-variant-numeric: tabular-nums; }

        /* ── Notes ── */
        .timer { display: inline-flex; align-items: center; gap: 6px; background: rgba(198,146,74,.07); border: 1px solid rgba(198,146,74,.15); border-radius: 999px; padding: 6px 16px; font-size: 13px; color: rgba(245,237,228,.6); margin-bottom: 24px; }
        .warn  { font-size: 12px; color: rgba(245,237,228,.22); line-height: 1.7; padding-top: 20px; border-top: 1px solid rgba(198,146,74,.07); }

        /* ── Footer ── */
        .ft   { padding: 18px 30px; text-align: center; border-top: 1px solid rgba(198,146,74,.07); }
        .ft p { font-size: 11px; color: rgba(245,237,228,.18); }
    </style>
</head>
<body>
    <div class="card">

        <div class="hd">
            <div class="logo">عتاب 🤍</div>
            <div class="logo-sub">3tab.app</div>
        </div>

        <div class="bd">
            <h2 class="ttl">كود استعادة كلمة المرور 🔑</h2>
            <p class="sub">
                طلبت إعادة تعيين كلمة المرور لحسابك.<br>
                استخدم الكود التالي لإكمال العملية:
            </p>

            <div class="otp-wrap">
                <div class="otp-label">كود التحقق</div>
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <div class="timer">
                ⏱ &nbsp;ينتهي خلال <strong style="color:#E8B96A;">10 دقائق</strong>
            </div>

            <p class="warn">
                إذا لم تطلب هذا الكود، تجاهل هذا البريد الإلكتروني بأمان.<br>
                لن يتأثر حسابك بأي شكل.
            </p>
        </div>

        <div class="ft">
            <p>© {{ date('Y') }} عتاب — تطبيق التعبير العاطفي</p>
        </div>

    </div>
</body>
</html>
