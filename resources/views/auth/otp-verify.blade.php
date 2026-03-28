@extends('layouts.auth')

@section('content')

<div style="display:flex;height:100vh;width:100%;overflow:hidden;">

    {{-- ══ يمين: ديكور ══ --}}
    <div class="auth-left" style="
        flex:1;background:linear-gradient(160deg,#1a0d06 0%,#2e1a0e 40%,#C6924A 100%);
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        padding:2.5rem;position:relative;overflow:hidden;">

        <div style="position:absolute;top:30%;left:50%;transform:translate(-50%,-50%);width:350px;height:350px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.18),transparent 70%);pointer-events:none;"></div>
        <div style="position:absolute;width:300px;height:300px;border-radius:50%;border:1px solid rgba(198,146,74,.12);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;text-align:center;">
            <a href="{{ route('home') }}" style="font-family:'Amiri',serif;font-size:4rem;background:linear-gradient(135deg,#E8B96A,#C6924A);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 20px rgba(198,146,74,.5));display:block;margin-bottom:.5rem;text-decoration:none;">عتاب</a>

            <p style="font-family:'Amiri',serif;font-style:italic;font-size:1rem;color:rgba(245,237,228,.55);line-height:2;margin:0 auto 2rem;">
                "خطوة واحدة تفصلك عن حسابك"
            </p>

            {{-- Shield icon card --}}
            <div style="background:rgba(198,146,74,.07);border:1px solid rgba(198,146,74,.18);border-radius:20px;padding:1.8rem;max-width:260px;margin:0 auto;">
                <div style="font-size:3rem;margin-bottom:.8rem;animation:pulse 2s ease-in-out infinite;">🛡️</div>
                <p style="font-family:'Amiri',serif;font-size:1.2rem;color:#E8B96A;margin-bottom:.5rem;">كود التحقق</p>
                <p style="font-size:.82rem;color:rgba(245,237,228,.5);line-height:1.8;">
                    أرسلنا كوداً مكوّناً من 6 أرقام إلى بريدك الإلكتروني
                </p>
                <div style="margin-top:1rem;padding:.6rem .9rem;background:rgba(0,0,0,.3);border-radius:8px;font-size:.78rem;color:rgba(198,146,74,.6);direction:ltr;word-break:break-all;">
                    {{ session('otp_email') }}
                </div>
            </div>

            <div style="margin-top:1.3rem;display:flex;flex-direction:column;gap:.45rem;max-width:220px;margin-left:auto;margin-right:auto;">
                <div style="font-size:.75rem;color:rgba(245,237,228,.3);text-align:center;">⏱ ينتهي الكود خلال 10 دقائق</div>
                <div style="font-size:.75rem;color:rgba(245,237,228,.3);text-align:center;">🔒 الكود مشفّر ومحمي</div>
            </div>
        </div>
    </div>

    {{-- ══ يسار: فورم ══ --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;background:#1a1008;overflow-y:auto;">
        <div style="width:100%;max-width:420px;animation:cardIn .5s ease both;">

            {{-- Back --}}
            <div style="margin-bottom:1.8rem;">
                <a href="{{ route('forgot.show') }}" style="display:inline-flex;align-items:center;gap:.45rem;font-size:.82rem;color:rgba(245,237,228,.4);text-decoration:none;transition:color .2s;"
                   onmouseover="this.style.color='#C6924A'" onmouseout="this.style.color='rgba(245,237,228,.4)'">
                    ← تغيير البريد الإلكتروني
                </a>
            </div>

            {{-- Header --}}
            <div style="margin-bottom:2rem;">
                <h1 style="font-family:'Amiri',serif;font-size:1.9rem;color:#F5EDE4;margin-bottom:.35rem;">
                    أدخل كود التحقق
                </h1>
                <p style="font-size:.86rem;color:rgba(245,237,228,.45);line-height:1.7;">
                    تم إرسال كود من <strong style="color:rgba(245,237,228,.7);">6 أرقام</strong>
                    إلى
                    <span style="color:#C6924A;direction:ltr;display:inline-block;">{{ session('otp_email') }}</span>
                </p>
            </div>

            {{-- Status --}}
            @if(session('status'))
                <div style="background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.2);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.3rem;display:flex;align-items:center;gap:.6rem;font-size:.85rem;color:#4ade80;">
                    ✅ {{ session('status') }}
                </div>
            @endif

            {{-- Error --}}
            @if($errors->has('otp'))
                <div id="otp-error" style="background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.2);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.3rem;font-size:.85rem;color:#f87171;display:flex;align-items:center;gap:.5rem;">
                    ❌ {{ $errors->first('otp') }}
                </div>
            @endif

            {{-- OTP Form --}}
            <form method="POST" action="{{ route('forgot.verify') }}" id="verify-form" novalidate>
                @csrf
                <input type="hidden" name="otp" id="otp-hidden" value="{{ old('otp') }}">

                {{-- 6-digit input boxes --}}
                <div style="display:flex;gap:.65rem;justify-content:center;margin-bottom:1.6rem;direction:ltr;" id="otp-boxes">
                    @for($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        inputmode="numeric"
                        maxlength="1"
                        class="otp-digit"
                        data-index="{{ $i }}"
                        autocomplete="off"
                        style="
                            width:52px; height:64px;
                            text-align:center;
                            font-size:1.75rem; font-weight:700;
                            border:1.5px solid rgba(198,146,74,.2);
                            border-radius:12px;
                            background:rgba(0,0,0,.3);
                            color:#F5EDE4;
                            outline:none;
                            transition:border-color .2s, box-shadow .2s, background .2s;
                            caret-color:#C6924A;
                            font-variant-numeric: tabular-nums;
                        "
                    />
                    @endfor
                </div>

                {{-- Verify button --}}
                <button type="submit" id="verify-btn" disabled style="
                    width:100%; padding:.88rem;
                    background:linear-gradient(135deg,#E8B96A,#C6924A);
                    color:#1a1008; border:none; border-radius:12px;
                    font-family:'Tajawal',sans-serif; font-size:1rem; font-weight:700;
                    cursor:pointer; transition:all .3s;
                    box-shadow:0 4px 18px rgba(198,146,74,.35);
                    display:flex; align-items:center; justify-content:center; gap:.5rem;
                    opacity:.5;
                "
                onmouseover="if(!this.disabled){this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(198,146,74,.5)'}"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 18px rgba(198,146,74,.35)'">
                    <span id="verify-text">تحقق من الكود ✓</span>
                    <span id="verify-spinner" style="display:none;width:18px;height:18px;border:2px solid rgba(26,16,8,.3);border-top-color:#1a1008;border-radius:50%;animation:spin .7s linear infinite;"></span>
                </button>
            </form>

            {{-- Resend section --}}
            <div style="margin-top:1.5rem;text-align:center;">

                {{-- Countdown (visible during cooldown) --}}
                <div id="resend-countdown" style="font-size:.84rem;color:rgba(245,237,228,.35);">
                    إعادة الإرسال متاحة بعد
                    <span id="resend-secs" style="color:#C6924A;font-weight:700;min-width:22px;display:inline-block;">60</span>
                    ثانية
                </div>

                {{-- Resend button (hidden during cooldown) --}}
                <form method="POST" action="{{ route('forgot.resend') }}" id="resend-form" style="display:inline;">
                    @csrf
                    <button type="submit" id="resend-btn" style="
                        display:none;
                        background:none; border:none;
                        font-family:'Tajawal',sans-serif; font-size:.86rem;
                        color:#C6924A; cursor:pointer; transition:color .2s;
                        text-decoration:underline; text-underline-offset:3px;
                    "
                    onmouseover="this.style.color='#E8B96A'"
                    onmouseout="this.style.color='#C6924A'">
                        لم يصلك الكود؟ أعد الإرسال
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
    @media (max-width:768px) {
        .auth-left { display:none !important; }
        .otp-digit { width:44px !important; height:56px !important; font-size:1.5rem !important; }
    }
    @media (max-width:380px) {
        .otp-digit { width:38px !important; height:50px !important; font-size:1.3rem !important; }
        #otp-boxes { gap:.45rem !important; }
    }
    @keyframes cardIn { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes spin   { to { transform:rotate(360deg); } }
    @keyframes pulse  { 0%,100%{transform:scale(1)} 50%{transform:scale(1.06)} }
    @keyframes shake  {
        0%,100%{transform:translateX(0)}
        20%{transform:translateX(-6px)} 40%{transform:translateX(6px)}
        60%{transform:translateX(-4px)} 80%{transform:translateX(4px)}
    }

    .otp-digit:focus {
        border-color: rgba(198,146,74,.65) !important;
        box-shadow: 0 0 0 3px rgba(198,146,74,.12) !important;
        background: rgba(198,146,74,.04) !important;
    }
    .otp-digit.filled {
        border-color: rgba(198,146,74,.4) !important;
        background: rgba(198,146,74,.05) !important;
    }
    .otp-digit.error {
        border-color: rgba(248,113,113,.5) !important;
        background: rgba(248,113,113,.04) !important;
        animation: shake .35s ease;
    }
    #verify-btn:not([disabled]) {
        opacity: 1 !important;
        cursor: pointer !important;
    }
</style>

<script>
(function () {
    const inputs    = Array.from(document.querySelectorAll('.otp-digit'));
    const hidden    = document.getElementById('otp-hidden');
    const verifyBtn = document.getElementById('verify-btn');
    const verifyTxt = document.getElementById('verify-text');
    const verifySpin= document.getElementById('verify-spinner');
    const form      = document.getElementById('verify-form');

    // ── Populate from old() if server returned a value ────────────────────────
    const existingOtp = hidden.value;
    if (existingOtp) {
        existingOtp.split('').forEach((ch, i) => {
            if (inputs[i]) { inputs[i].value = ch; inputs[i].classList.add('filled'); }
        });
    }

    // ── Auto-focus first empty input on load ─────────────────────────────────
    const firstEmpty = inputs.find(i => !i.value);
    if (firstEmpty) firstEmpty.focus();

    function syncHidden() {
        const val = inputs.map(i => i.value).join('');
        hidden.value = val;
        const complete = val.length === 6 && /^\d{6}$/.test(val);
        verifyBtn.disabled = !complete;
    }

    inputs.forEach((input, idx) => {

        input.addEventListener('focus', () => {
            input.select();
        });

        input.addEventListener('input', (e) => {
            // Strip non-digits, keep only first character
            const digit = input.value.replace(/\D/g, '').slice(-1);
            input.value = digit;
            input.classList.toggle('filled', digit !== '');
            input.classList.remove('error');

            if (digit && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
            syncHidden();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace') {
                if (input.value) {
                    input.value = '';
                    input.classList.remove('filled');
                    syncHidden();
                } else if (idx > 0) {
                    inputs[idx - 1].focus();
                    inputs[idx - 1].value = '';
                    inputs[idx - 1].classList.remove('filled');
                    syncHidden();
                }
                e.preventDefault();
            }
            if (e.key === 'ArrowLeft'  && idx > 0)              inputs[idx - 1].focus();
            if (e.key === 'ArrowRight' && idx < inputs.length-1) inputs[idx + 1].focus();
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData)
                .getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, i) => {
                if (inputs[i]) { inputs[i].value = ch; inputs[i].classList.add('filled'); }
            });
            const nextFocus = inputs[Math.min(pasted.length, 5)];
            if (nextFocus) nextFocus.focus();
            syncHidden();
        });
    });

    // ── Show error shake on existing error ────────────────────────────────────
    @if($errors->has('otp'))
        inputs.forEach(i => i.classList.add('error'));
        setTimeout(() => inputs.forEach(i => i.classList.remove('error')), 500);
    @endif

    // ── Submit loading state ──────────────────────────────────────────────────
    form.addEventListener('submit', () => {
        verifyBtn.disabled    = true;
        verifyTxt.textContent = 'جاري التحقق...';
        verifySpin.style.display = 'inline-block';
    });

    // ── 60-second resend countdown ────────────────────────────────────────────
    const sentAt    = {{ session('otp_sent_at', now()->timestamp) }};
    const elapsed   = Math.floor(Date.now() / 1000) - sentAt;
    let   remaining = Math.max(0, 60 - elapsed);

    const countdownEl = document.getElementById('resend-countdown');
    const secsEl      = document.getElementById('resend-secs');
    const resendBtn   = document.getElementById('resend-btn');
    const resendForm  = document.getElementById('resend-form');

    function tick() {
        if (remaining <= 0) {
            countdownEl.style.display = 'none';
            resendBtn.style.display   = 'inline';
            return;
        }
        secsEl.textContent = remaining;
        remaining--;
        setTimeout(tick, 1000);
    }

    if (remaining > 0) {
        tick();
    } else {
        countdownEl.style.display = 'none';
        resendBtn.style.display   = 'inline';
    }

    // Loading state on resend
    resendForm.addEventListener('submit', () => {
        resendBtn.textContent  = 'جاري الإرسال...';
        resendBtn.disabled     = true;
        resendBtn.style.opacity = '.6';
    });

})();
</script>

@endsection
