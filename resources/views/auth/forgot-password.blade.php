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
        <div style="position:absolute;width:180px;height:180px;border-radius:50%;border:1px solid rgba(198,146,74,.08);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;"></div>
        <span style="position:absolute;font-family:'Amiri',serif;font-size:16rem;line-height:1;color:rgba(198,146,74,.05);top:-1rem;right:-1rem;user-select:none;pointer-events:none;">🔑</span>

        <div style="position:relative;z-index:1;text-align:center;">
            <a href="{{ route('home') }}" style="font-family:'Amiri',serif;font-size:4rem;line-height:1;background:linear-gradient(135deg,#E8B96A,#C6924A);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 20px rgba(198,146,74,.5));display:block;margin-bottom:.5rem;text-decoration:none;">عتاب</a>

            <p style="font-family:'Amiri',serif;font-style:italic;font-size:1rem;color:rgba(245,237,228,.55);line-height:2;max-width:240px;margin:0 auto 2.5rem;">
                "استعادة حسابك خطوة بسيطة"
            </p>

            <div style="background:rgba(198,146,74,.07);border:1px solid rgba(198,146,74,.18);border-radius:20px;padding:1.5rem;max-width:260px;margin:0 auto;">
                <div style="font-size:2.5rem;margin-bottom:.7rem;">🔐</div>
                <p style="font-family:'Amiri',serif;font-size:1.2rem;color:#E8B96A;margin-bottom:.5rem;">نسيت كلمة المرور؟</p>
                <p style="font-size:.82rem;color:rgba(245,237,228,.5);line-height:1.8;">
                    أدخل بريدك الإلكتروني وسنرسل لك كود تحقق مكوّن من 6 أرقام
                </p>
            </div>

            <div style="display:flex;flex-direction:column;gap:.55rem;margin-top:1.5rem;max-width:230px;margin-left:auto;margin-right:auto;">
                @foreach([['📧','تحقق من بريدك الوارد'],['🔢','أدخل الكود المكوّن من 6 أرقام'],['🔒','أنشئ كلمة مرور جديدة']] as $i => [$emoji, $text])
                <div style="display:flex;align-items:center;gap:.7rem;background:rgba(198,146,74,.05);border:1px solid rgba(198,146,74,.1);border-radius:10px;padding:.5rem .85rem;text-align:right;">
                    <span style="font-size:.95rem;">{{ $emoji }}</span>
                    <span style="font-size:.8rem;color:rgba(245,237,228,.65);">{{ $text }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══ يسار: فورم ══ --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;background:#1a1008;overflow-y:auto;">
        <div style="width:100%;max-width:400px;animation:cardIn .5s ease both;">

            {{-- Back link --}}
            <div style="margin-bottom:1.8rem;">
                <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:.45rem;font-size:.82rem;color:rgba(245,237,228,.4);text-decoration:none;transition:color .2s;"
                   onmouseover="this.style.color='#C6924A'" onmouseout="this.style.color='rgba(245,237,228,.4)'">
                    ← العودة لتسجيل الدخول
                </a>
            </div>

            {{-- Header --}}
            <div style="margin-bottom:2rem;">
                <h1 style="font-family:'Amiri',serif;font-size:1.9rem;color:#F5EDE4;margin-bottom:.35rem;">
                    استعادة كلمة المرور
                </h1>
                <p style="font-size:.86rem;color:rgba(245,237,228,.45);line-height:1.7;">
                    أدخل بريدك الإلكتروني وسنرسل لك كود تحقق فوراً
                </p>
            </div>

            {{-- Status message --}}
            @if(session('status'))
                <div style="background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.2);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.3rem;display:flex;align-items:center;gap:.6rem;font-size:.85rem;color:#4ade80;">
                    ✅ {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div style="background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.2);border-radius:12px;padding:.8rem 1rem;margin-bottom:1.3rem;font-size:.85rem;color:#f87171;">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('forgot.send') }}" id="otp-form" novalidate>
                @csrf

                {{-- Email field --}}
                <div style="margin-bottom:1.4rem;">
                    <label for="email" style="display:block;font-size:.82rem;font-weight:600;color:rgba(245,237,228,.55);margin-bottom:.4rem;">
                        البريد الإلكتروني
                    </label>
                    <input
                        type="email" name="email" id="email"
                        value="{{ old('email') }}"
                        placeholder="email@example.com"
                        autocomplete="email" dir="ltr"
                        style="
                            width:100%; padding:.8rem 1rem;
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

                {{-- Submit --}}
                <button type="submit" id="send-btn" style="
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
                    <span id="btn-text">إرسال كود التحقق 📧</span>
                    <span id="btn-spinner" style="display:none;width:18px;height:18px;border:2px solid rgba(26,16,8,.3);border-top-color:#1a1008;border-radius:50%;animation:spin .7s linear infinite;"></span>
                </button>
            </form>

            <div style="display:flex;align-items:center;gap:.8rem;margin:1.4rem 0 1.1rem;">
                <div style="flex:1;height:1px;background:rgba(198,146,74,.1);"></div>
                <span style="font-size:.75rem;color:rgba(245,237,228,.25);">أو</span>
                <div style="flex:1;height:1px;background:rgba(198,146,74,.1);"></div>
            </div>

            <p style="text-align:center;font-size:.86rem;color:rgba(245,237,228,.4);">
                تذكّرت كلمة المرور؟
                <a href="{{ route('login') }}" style="color:#C6924A;font-weight:600;transition:color .2s;"
                   onmouseover="this.style.color='#E8B96A'" onmouseout="this.style.color='#C6924A'">
                    سجّل دخولك
                </a>
            </p>

        </div>
    </div>
</div>

<style>
    @media (max-width:768px) { .auth-left { display:none !important; } }
    @keyframes cardIn { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes spin   { to { transform: rotate(360deg); } }
</style>

<script>
document.getElementById('otp-form').addEventListener('submit', function() {
    const btn  = document.getElementById('send-btn');
    const text = document.getElementById('btn-text');
    const spin = document.getElementById('btn-spinner');
    btn.disabled    = true;
    text.textContent = 'جاري الإرسال...';
    spin.style.display = 'inline-block';
    btn.style.opacity = '.75';
});
</script>

@endsection
