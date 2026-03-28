@extends('layouts.auth')

@section('content')

<div style="display:flex;height:100vh;width:100%;overflow:hidden;">

    {{-- ══ يمين: ديكور ══ --}}
    <div class="auth-left" style="
        flex:1;background:linear-gradient(160deg,#1a0d06 0%,#2e1a0e 40%,#C6924A 100%);
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        padding:2.5rem;position:relative;overflow:hidden;">

        <div style="position:absolute;top:30%;left:50%;transform:translate(-50%,-50%);width:350px;height:350px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.18),transparent 70%);pointer-events:none;"></div>
        <div style="position:absolute;width:280px;height:280px;border-radius:50%;border:1px solid rgba(198,146,74,.12);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;"></div>

        <div style="position:relative;z-index:1;text-align:center;">
            <a href="{{ route('home') }}" style="font-family:'Amiri',serif;font-size:4rem;background:linear-gradient(135deg,#E8B96A,#C6924A);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 20px rgba(198,146,74,.5));display:block;margin-bottom:.5rem;text-decoration:none;">عتاب</a>

            <p style="font-family:'Amiri',serif;font-style:italic;font-size:1rem;color:rgba(245,237,228,.55);line-height:2;margin:0 auto 2rem;">
                "بداية جديدة مع كلمة مرور جديدة"
            </p>

            <div style="background:rgba(198,146,74,.07);border:1px solid rgba(198,146,74,.18);border-radius:20px;padding:1.8rem;max-width:260px;margin:0 auto;">
                <div style="font-size:3rem;margin-bottom:.8rem;">🔒</div>
                <p style="font-family:'Amiri',serif;font-size:1.2rem;color:#E8B96A;margin-bottom:.5rem;">كلمة مرور جديدة</p>
                <p style="font-size:.82rem;color:rgba(245,237,228,.5);line-height:1.8;">
                    أنشئ كلمة مرور قوية تحمي حسابك
                </p>
            </div>

            <div style="display:flex;flex-direction:column;gap:.45rem;margin-top:1.4rem;max-width:220px;margin-left:auto;margin-right:auto;">
                @foreach(['✅ تحقق الهوية بنجاح','🔢 كود التحقق صحيح','🔒 أنشئ كلمة مرور الآن'] as $step)
                <div style="display:flex;align-items:center;gap:.55rem;font-size:.78rem;color:rgba(245,237,228,.4);">
                    {{ $step }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ يسار: فورم ══ --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;background:#1a1008;overflow-y:auto;">
        <div style="width:100%;max-width:400px;animation:cardIn .5s ease both;">

            {{-- Header --}}
            <div style="margin-bottom:2rem;">
                <h1 style="font-family:'Amiri',serif;font-size:1.9rem;color:#F5EDE4;margin-bottom:.35rem;">
                    كلمة مرور جديدة
                </h1>
                <p style="font-size:.86rem;color:rgba(245,237,228,.45);line-height:1.7;">
                    اختر كلمة مرور قوية لا تقل عن 8 أحرف
                </p>
            </div>

            {{-- Errors --}}
            @if($errors->any())
                <div style="background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.2);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.3rem;font-size:.85rem;color:#f87171;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('forgot.reset') }}" id="reset-form" novalidate>
                @csrf

                {{-- New password --}}
                <div style="margin-bottom:1.1rem;">
                    <label for="password" style="display:block;font-size:.82rem;font-weight:600;color:rgba(245,237,228,.55);margin-bottom:.4rem;">
                        كلمة المرور الجديدة
                    </label>
                    <div style="position:relative;">
                        <input
                            type="password" name="password" id="password"
                            placeholder="••••••••  (8 أحرف على الأقل)"
                            autocomplete="new-password" dir="ltr"
                            style="
                                width:100%; padding:.78rem 2.75rem .78rem 1rem;
                                border:1px solid {{ $errors->has('password') ? 'rgba(248,113,113,.5)' : 'rgba(198,146,74,.18)' }};
                                border-radius:12px;
                                font-family:'Tajawal',sans-serif; font-size:.95rem; letter-spacing:.05em;
                                background:rgba(0,0,0,.25); color:#F5EDE4;
                                outline:none; transition:border-color .25s, box-shadow .25s;
                            "
                            onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                            onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none';checkStrength(this.value)"
                            oninput="checkStrength(this.value)"
                        />
                        <button type="button" id="toggle-p1" onclick="togglePass('password','eye1-open','eye1-closed',this)"
                                aria-label="إظهار كلمة المرور"
                                style="position:absolute;right:.55rem;top:50%;transform:translateY(-50%);width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:none;border:none;border-radius:8px;cursor:pointer;padding:0;color:rgba(245,237,228,.35);transition:color .2s,background .2s;"
                                onmouseover="this.style.color='rgba(198,146,74,.8)';this.style.background='rgba(198,146,74,.1)'"
                                onmouseout="this.style.color='rgba(245,237,228,.35)';this.style.background='none'">
                            <svg id="eye1-open" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye1-closed" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Strength bar --}}
                    <div id="strength-wrap" style="margin-top:.5rem;display:none;">
                        <div style="height:4px;background:rgba(255,255,255,.07);border-radius:2px;overflow:hidden;">
                            <div id="strength-bar" style="height:100%;border-radius:2px;width:0;transition:width .35s,background .35s;"></div>
                        </div>
                        <p id="strength-label" style="font-size:.7rem;margin-top:.28rem;color:rgba(245,237,228,.35);"></p>
                    </div>
                </div>

                {{-- Confirm password --}}
                <div style="margin-bottom:1.6rem;">
                    <label for="password_confirmation" style="display:block;font-size:.82rem;font-weight:600;color:rgba(245,237,228,.55);margin-bottom:.4rem;">
                        تأكيد كلمة المرور
                    </label>
                    <div style="position:relative;">
                        <input
                            type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="••••••••"
                            autocomplete="new-password" dir="ltr"
                            style="
                                width:100%; padding:.78rem 2.75rem .78rem 1rem;
                                border:1px solid rgba(198,146,74,.18);
                                border-radius:12px;
                                font-family:'Tajawal',sans-serif; font-size:.95rem; letter-spacing:.05em;
                                background:rgba(0,0,0,.25); color:#F5EDE4;
                                outline:none; transition:border-color .25s, box-shadow .25s;
                            "
                            onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                            onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                        />
                        <button type="button" id="toggle-p2" onclick="togglePass('password_confirmation','eye2-open','eye2-closed',this)"
                                aria-label="إظهار كلمة المرور"
                                style="position:absolute;right:.55rem;top:50%;transform:translateY(-50%);width:32px;height:32px;display:flex;align-items:center;justify-content:center;background:none;border:none;border-radius:8px;cursor:pointer;padding:0;color:rgba(245,237,228,.35);transition:color .2s,background .2s;"
                                onmouseover="this.style.color='rgba(198,146,74,.8)';this.style.background='rgba(198,146,74,.1)'"
                                onmouseout="this.style.color='rgba(245,237,228,.35)';this.style.background='none'">
                            <svg id="eye2-open" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="eye2-closed" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" id="reset-btn" style="
                    width:100%; padding:.88rem;
                    background:linear-gradient(135deg,#E8B96A,#C6924A);
                    color:#1a1008; border:none; border-radius:12px;
                    font-family:'Tajawal',sans-serif; font-size:1rem; font-weight:700;
                    cursor:pointer; transition:all .3s;
                    box-shadow:0 4px 18px rgba(198,146,74,.35);
                    display:flex; align-items:center; justify-content:center; gap:.5rem;
                "
                onmouseover="if(!this.disabled){this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(198,146,74,.5)'}"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 18px rgba(198,146,74,.35)'">
                    <span id="reset-text">تحديث كلمة المرور 🔒</span>
                    <span id="reset-spinner" style="display:none;width:18px;height:18px;border:2px solid rgba(26,16,8,.3);border-top-color:#1a1008;border-radius:50%;animation:spin .7s linear infinite;"></span>
                </button>

            </form>

        </div>
    </div>
</div>

<style>
    @media (max-width:768px) { .auth-left { display:none !important; } }
    @keyframes cardIn { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes spin   { to{transform:rotate(360deg)} }
</style>

<script>
function togglePass(inputId, openId, closedId, btn) {
    const input     = document.getElementById(inputId);
    const eyeOpen   = document.getElementById(openId);
    const eyeClosed = document.getElementById(closedId);
    const showing   = input.type === 'text';

    input.type              = showing ? 'password' : 'text';
    eyeOpen.style.display   = showing ? 'block' : 'none';
    eyeClosed.style.display = showing ? 'none'  : 'block';
    btn.setAttribute('aria-label', showing ? 'إظهار كلمة المرور' : 'إخفاء كلمة المرور');
    input.focus();
}

function checkStrength(val) {
    const wrap  = document.getElementById('strength-wrap');
    const bar   = document.getElementById('strength-bar');
    const label = document.getElementById('strength-label');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';

    let score = 0;
    if (val.length >= 8)              score++;
    if (val.length >= 12)             score++;
    if (/[A-Z]/.test(val))           score++;
    if (/[0-9]/.test(val))           score++;
    if (/[^A-Za-z0-9]/.test(val))   score++;

    const levels = [
        { pct:'20%', color:'#f87171', text:'ضعيفة جداً' },
        { pct:'40%', color:'#fb923c', text:'ضعيفة' },
        { pct:'60%', color:'#facc15', text:'متوسطة' },
        { pct:'80%', color:'#4ade80', text:'قوية' },
        { pct:'100%',color:'#22c55e', text:'قوية جداً 🔒' },
    ];
    const lvl = levels[Math.max(0, score - 1)] || levels[0];
    bar.style.width      = lvl.pct;
    bar.style.background = lvl.color;
    label.textContent    = lvl.text;
    label.style.color    = lvl.color;
}

document.getElementById('reset-form').addEventListener('submit', function () {
    const btn  = document.getElementById('reset-btn');
    const txt  = document.getElementById('reset-text');
    const spin = document.getElementById('reset-spinner');
    btn.disabled        = true;
    txt.textContent     = 'جاري الحفظ...';
    spin.style.display  = 'inline-block';
    btn.style.opacity   = '.75';
});
</script>

@endsection
