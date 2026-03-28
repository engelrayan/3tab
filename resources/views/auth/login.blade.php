@extends('layouts.auth')

@section('content')

<div style="display:flex; height:100vh; width:100%; overflow:hidden;">

    {{-- ══ يمين: ديكور ══ --}}
    <div class="auth-left" style="
        flex:1;
        background: linear-gradient(160deg, #1a0d06 0%, #2e1a0e 40%, #C6924A 100%);
        display:flex; flex-direction:column;
        align-items:center; justify-content:center;
        padding:2.5rem; position:relative; overflow:hidden;
    ">
        {{-- Radial glow --}}
        <div style="position:absolute;top:30%;left:50%;transform:translate(-50%,-50%);width:350px;height:350px;border-radius:50%;background:radial-gradient(circle at center,rgba(198,146,74,.18),transparent 70%);pointer-events:none;"></div>

        {{-- دوائر --}}
        <div style="position:absolute;width:300px;height:300px;border-radius:50%;border:1px solid rgba(198,146,74,.12);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;"></div>
        <div style="position:absolute;width:200px;height:200px;border-radius:50%;border:1px solid rgba(198,146,74,.08);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;"></div>

        {{-- حروف ديكورية --}}
        <span style="position:absolute;font-family:'Amiri',serif;font-size:18rem;line-height:1;color:rgba(198,146,74,.05);top:-2rem;right:-2rem;user-select:none;pointer-events:none;">ع</span>
        <span style="position:absolute;font-family:'Amiri',serif;font-size:12rem;line-height:1;color:rgba(198,146,74,.05);bottom:-1rem;left:-1rem;user-select:none;pointer-events:none;">ب</span>

        {{-- المحتوى --}}
        <div style="position:relative;z-index:1;text-align:center;">
            <a href="{{ route('home') }}" style="
                font-family:'Amiri',serif; font-size:4.5rem; line-height:1;
                background:linear-gradient(135deg,#E8B96A,#C6924A);
                -webkit-background-clip:text; -webkit-text-fill-color:transparent;
                background-clip:text;
                filter:drop-shadow(0 0 20px rgba(198,146,74,.5));
                display:block; margin-bottom:.5rem; text-decoration:none;
            ">عتاب</a>

            <p style="font-family:'Amiri',serif;font-style:italic;font-size:1.1rem;color:rgba(245,237,228,.6);line-height:2;max-width:260px;margin:0 auto 2.5rem;">
                "ما محبة إلا بعد عتاب"
            </p>

            {{-- بطاقة ترحيب --}}
            <div style="background:rgba(198,146,74,.07);border:1px solid rgba(198,146,74,.18);border-radius:20px;padding:1.5rem;max-width:260px;margin:0 auto;">
                <p style="font-family:'Amiri',serif;font-size:1.3rem;color:#E8B96A;margin-bottom:.6rem;">أهلاً بعودتك 🤍</p>
                <p style="font-size:.83rem;color:rgba(245,237,228,.55);line-height:1.8;">
                    سجّل دخولك وتابع محادثاتك ومصالحاتك
                </p>
            </div>

            {{-- مميزات --}}
            <div style="display:flex;flex-direction:column;gap:.6rem;margin-top:1.5rem;max-width:240px;margin-left:auto;margin-right:auto;">
                @foreach([['💬','محادثاتك في مكان واحد'],['🔔','إشعارات عتاب جديد'],['🤝','تابع مصالحاتك']] as $f)
                <div style="display:flex;align-items:center;gap:.7rem;background:rgba(198,146,74,.05);border:1px solid rgba(198,146,74,.1);border-radius:10px;padding:.55rem .9rem;text-align:right;transition:all .2s;"
                     onmouseover="this.style.borderColor='rgba(198,146,74,.3)';this.style.background='rgba(198,146,74,.1)'"
                     onmouseout="this.style.borderColor='rgba(198,146,74,.1)';this.style.background='rgba(198,146,74,.05)'">
                    <span style="font-size:1rem;">{{ $f[0] }}</span>
                    <span style="font-size:.82rem;color:rgba(245,237,228,.7);">{{ $f[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ يسار: فورم ══ --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;background:#1a1008;overflow-y:auto;">
        <div style="width:100%;max-width:400px;animation:cardIn .5s ease both;">

            {{-- Header --}}
            <div style="text-align:center;margin-bottom:2rem;">
                <h1 style="font-family:'Amiri',serif;font-size:2rem;color:#F5EDE4;margin-bottom:.3rem;">
                    تسجيل الدخول
                </h1>
                <p style="font-size:.87rem;color:rgba(245,237,228,.5);">
                    أدخل بياناتك للوصول لحسابك
                </p>
            </div>

            {{-- Success flash (e.g. after password reset) --}}
            @if(session('status'))
                <div style="background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.22);border-radius:12px;padding:.78rem 1rem;margin-bottom:1.3rem;display:flex;align-items:center;gap:.6rem;font-size:.85rem;color:#4ade80;">
                    ✅ {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div style="background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2);border-radius:12px;padding:.75rem 1rem;margin-bottom:1.3rem;font-size:.85rem;color:#f87171;">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" novalidate id="login-form">
                @csrf
                <input type="hidden" name="guest_token" id="login_guest_token" />

                {{-- البريد --}}
                <div style="margin-bottom:1.1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:600;color:rgba(245,237,228,.55);margin-bottom:.4rem;">
                        البريد الإلكتروني
                    </label>
                    <input
                        type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="email@example.com"
                        autocomplete="email" dir="ltr"
                        style="
                            width:100%; padding:.75rem 1rem;
                            border:1px solid {{ $errors->has('email') ? 'rgba(248,113,113,.5)' : 'rgba(198,146,74,.18)' }};
                            border-radius:12px;
                            font-family:'Tajawal',sans-serif; font-size:.95rem;
                            background:rgba(0,0,0,.25); color:#F5EDE4;
                            outline:none; transition:border-color .25s, box-shadow .25s;
                            text-align:left;
                        "
                        onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                        onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                    />
                </div>

                {{-- كلمة المرور --}}
                <div style="margin-bottom:1rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.4rem;">
                        <label for="password" style="font-size:.82rem;font-weight:600;color:rgba(245,237,228,.55);">
                            كلمة المرور
                        </label>
                        <a href="{{ route('forgot.show') }}" style="font-size:.78rem;color:#C6924A;transition:color .2s;"
                           onmouseover="this.style.color='#E8B96A'" onmouseout="this.style.color='#C6924A'">
                            نسيت كلمة المرور؟
                        </a>
                    </div>

                    {{--
                        FIX: password field icon positioning for RTL + dir="ltr" input.
                        ─────────────────────────────────────────────────────────────
                        • Input is dir="ltr"  → text cursor starts at physical LEFT
                        • Page is RTL         → icon belongs on physical RIGHT
                        • padding-right:2.75rem keeps text clear of the icon on the right
                        • padding-left:1rem    gives breathing room on the text-start side
                        • Button uses right:.55rem  (NOT left) — this was the original bug
                    --}}
                    <div style="position:relative; display:flex; align-items:center;">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            dir="ltr"
                            style="
                                width: 100%;
                                /* top | RIGHT=icon-side | bottom | LEFT=text-start */
                                padding: .78rem 2.75rem .78rem 1rem;
                                border: 1px solid rgba(198,146,74,.18);
                                border-radius: 12px;
                                font-family: 'Tajawal', sans-serif;
                                font-size: .95rem;
                                letter-spacing: .05em;
                                background: rgba(0,0,0,.25);
                                color: #F5EDE4;
                                outline: none;
                                transition: border-color .25s, box-shadow .25s;
                            "
                            onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                            onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                        />

                        {{--
                            Toggle button on physical RIGHT:
                            • RTL convention: decorative icons sit on the visual "start" = physical right
                            • LTR text in the input flows LEFT→RIGHT, so the right side is unoccupied
                            • padding-right:2.75rem above guarantees no overlap
                        --}}
                        <button
                            type="button"
                            id="pass-toggle"
                            onclick="togglePass()"
                            aria-label="إظهار كلمة المرور"
                            title="إظهار / إخفاء"
                            style="
                                position: absolute;
                                right: .55rem;         /* ← physical RIGHT, matches RTL convention */
                                top: 50%;
                                transform: translateY(-50%);
                                width: 32px;
                                height: 32px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                background: none;
                                border: none;
                                border-radius: 8px;
                                cursor: pointer;
                                padding: 0;
                                color: rgba(245,237,228,.35);
                                transition: color .2s, background .2s;
                                flex-shrink: 0;
                            "
                            onmouseover="this.style.color='rgba(198,146,74,.8)';this.style.background='rgba(198,146,74,.1)'"
                            onmouseout="this.style.color='rgba(245,237,228,.35)';this.style.background='none'"
                            onfocus="this.style.outline='2px solid rgba(198,146,74,.4)';this.style.outlineOffset='2px'"
                            onblur="this.style.outline='none'"
                        >
                            {{-- Eye-open SVG --}}
                            <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg"
                                 width="17" height="17" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="display:block; transition:opacity .2s;">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            {{-- Eye-closed SVG (hidden by default) --}}
                            <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg"
                                 width="17" height="17" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="display:none; transition:opacity .2s;">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div style="margin-bottom:1.6rem;">
                    <label style="display:flex;align-items:center;gap:.55rem;cursor:pointer;">
                        <input type="checkbox" name="remember"
                               style="accent-color:#C6924A;width:15px;height:15px;cursor:pointer;"
                               {{ old('remember') ? 'checked' : '' }}
                        />
                        <span style="font-size:.83rem;color:rgba(245,237,228,.5);">
                            تذكّرني
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" style="
                    width:100%; padding:.88rem;
                    background:linear-gradient(135deg,#E8B96A,#C6924A);
                    color:#1a1008; border:none; border-radius:12px;
                    font-family:'Tajawal',sans-serif; font-size:1rem; font-weight:700;
                    cursor:pointer; transition:all .3s;
                    box-shadow:0 4px 18px rgba(198,146,74,.35);
                "
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(198,146,74,.5)'"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 18px rgba(198,146,74,.35)'">
                    دخول ✓
                </button>
            </form>

            {{-- Divider --}}
            <div style="display:flex;align-items:center;gap:.8rem;margin:1.4rem 0 1.1rem;">
                <div style="flex:1;height:1px;background:rgba(198,146,74,.12);"></div>
                <span style="font-size:.78rem;color:rgba(245,237,228,.3);">أو</span>
                <div style="flex:1;height:1px;background:rgba(198,146,74,.12);"></div>
            </div>

            {{-- Register link --}}
            <p style="text-align:center;font-size:.87rem;color:rgba(245,237,228,.45);">
                ما عندك حساب؟
                <a href="{{ route('register') }}" style="color:#C6924A;font-weight:600;transition:color .2s;"
                   onmouseover="this.style.color='#E8B96A'" onmouseout="this.style.color='#C6924A'">
                    سجّل الآن مجاناً
                </a>
            </p>

        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) { .auth-left { display:none !important; } }
    @keyframes cardIn {
        from { opacity:0; transform:translateY(14px); }
        to   { opacity:1; transform:translateY(0); }
    }
</style>

<script>
    function togglePass() {
        const input     = document.getElementById('password');
        const btn       = document.getElementById('pass-toggle');
        const eyeOpen   = document.getElementById('icon-eye-open');
        const eyeClosed = document.getElementById('icon-eye-closed');
        const showing   = input.type === 'text';

        input.type = showing ? 'password' : 'text';

        // swap icons with a quick fade
        eyeOpen.style.display   = showing ? 'block' : 'none';
        eyeClosed.style.display = showing ? 'none'  : 'block';

        // update accessibility label
        btn.setAttribute('aria-label', showing ? 'إظهار كلمة المرور' : 'إخفاء كلمة المرور');

        // refocus input after toggle (better UX)
        input.focus();
    }

    // تعبئة guest_token من localStorage عند تسجيل الدخول
    (function() {
        const token = localStorage.getItem('atab_guest_token');
        if (token) document.getElementById('login_guest_token').value = token;
    })();
</script>

@endsection
