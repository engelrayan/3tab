@extends('layouts.auth')

@section('content')

<div style="display:flex; height:100vh; width:100%; overflow:hidden;">

    {{-- ══ يمين: ديكور ══ --}}
    <div class="auth-left" style="
        flex:1;
        background:linear-gradient(160deg, #1a0d06 0%, #2e1a0e 40%, #C6924A 100%);
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
        <span style="position:absolute;font-family:'Amiri',serif;font-size:12rem;line-height:1;color:rgba(198,146,74,.05);bottom:-1rem;left:-1rem;user-select:none;pointer-events:none;">ت</span>

        <div style="position:relative;z-index:1;text-align:center;">
            <a href="{{ route('home') }}" style="
                font-family:'Amiri',serif; font-size:4.5rem; line-height:1;
                background:linear-gradient(135deg,#E8B96A,#C6924A);
                -webkit-background-clip:text; -webkit-text-fill-color:transparent;
                background-clip:text;
                filter:drop-shadow(0 0 20px rgba(198,146,74,.5));
                display:block; margin-bottom:.5rem; text-decoration:none;
            ">عتاب</a>

            <p style="font-family:'Amiri',serif;font-style:italic;font-size:1.1rem;color:rgba(245,237,228,.6);line-height:2;max-width:260px;margin:0 auto 2rem;">
                "ما محبة إلا بعد عتاب"
            </p>

            <div style="display:flex;flex-direction:column;gap:.6rem;max-width:240px;margin:0 auto;">
                @foreach([
                    ['✉️','عبّر بصدق لمن تهتم به'],
                    ['🌡️','شارك حالتك اليوم'],
                    ['🔒','خصوصية مدروسة وآمنة'],
                    ['🤝','صافي يا لبن؟'],
                ] as $f)
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
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:1.5rem;background:#1a1008;overflow-y:auto;">
        <div style="width:100%;max-width:400px;animation:cardIn .5s ease both;">

            {{-- Header --}}
            <div style="text-align:center;margin-bottom:1.5rem;">
                <h1 style="font-family:'Amiri',serif;font-size:1.9rem;color:#F5EDE4;margin-bottom:.25rem;">
                    انضم إلى عتاب
                </h1>
                <p style="font-size:.85rem;color:rgba(245,237,228,.45);">
                    ابدأ رحلة التعبير الصادق
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate id="register-form">
                @csrf
                {{-- guest_token: يتعبأ تلقائياً من localStorage إذا بعت عتاباً قبل التسجيل --}}
                <input type="hidden" name="guest_token" id="guest_token_field" />

                {{-- Avatar --}}
                <div style="display:flex;flex-direction:column;align-items:center;margin-bottom:1.3rem;">
                    <div id="avatar-preview" onclick="document.getElementById('avatar-input').click()" style="
                        width:70px;height:70px;border-radius:50%;
                        background:linear-gradient(135deg,#E8B96A,#C2715A);
                        display:flex;align-items:center;justify-content:center;
                        font-family:'Amiri',serif;font-size:1.9rem;color:#1a1008;font-weight:700;
                        cursor:pointer;position:relative;overflow:hidden;
                        border:2px solid rgba(198,146,74,.5);
                        box-shadow:0 0 0 4px rgba(198,146,74,.1), 0 0 20px rgba(198,146,74,.2);
                        transition:all .3s;
                    "
                    onmouseover="this.style.boxShadow='0 0 0 4px rgba(198,146,74,.2), 0 0 30px rgba(198,146,74,.35)'"
                    onmouseout="this.style.boxShadow='0 0 0 4px rgba(198,146,74,.1), 0 0 20px rgba(198,146,74,.2)'">
                        <span id="avatar-initial">؟</span>
                        <img id="avatar-img" src="" alt="" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;" />
                        <div id="avatar-overlay" style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;border-radius:50%;">
                            <span style="color:#E8B96A;font-size:.7rem;font-family:'Tajawal',sans-serif;">تغيير</span>
                        </div>
                    </div>
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(this)" />
                    <p style="font-size:.73rem;color:rgba(245,237,228,.35);margin-top:.4rem;">صورة الملف الشخصي <span style="opacity:.6;">(اختياري)</span></p>
                </div>

                {{-- الاسم + اسم المستخدم --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-bottom:.8rem;">
                    <div>
                        <label style="display:block;font-size:.78rem;font-weight:600;color:rgba(245,237,228,.5);margin-bottom:.35rem;">الاسم</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="اسمك" autocomplete="name" id="name-input"
                            oninput="updateInitial(this.value)"
                            style="width:100%;padding:.62rem .85rem;border:1px solid {{ $errors->has('name') ? 'rgba(248,113,113,.5)' : 'rgba(198,146,74,.18)' }};border-radius:10px;font-family:'Tajawal',sans-serif;font-size:.88rem;background:rgba(0,0,0,.25);color:#F5EDE4;outline:none;transition:border-color .25s,box-shadow .25s;"
                            onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                            onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                        />
                        @error('name')<p style="font-size:.72rem;color:#f87171;margin-top:.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:.78rem;font-weight:600;color:rgba(245,237,228,.5);margin-bottom:.35rem;">اسم المستخدم</label>
                        <input type="text" name="username" id="username"
                            value="{{ old('username') }}" placeholder="your_name"
                            autocomplete="username" dir="ltr"
                            oninput="updatePreview(this.value)"
                            style="width:100%;padding:.62rem .85rem;border:1px solid {{ $errors->has('username') ? 'rgba(248,113,113,.5)' : 'rgba(198,146,74,.18)' }};border-radius:10px;font-family:'Tajawal',sans-serif;font-size:.88rem;background:rgba(0,0,0,.25);color:#F5EDE4;outline:none;transition:border-color .25s,box-shadow .25s;text-align:left;"
                            onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                            onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                        />
                        @error('username')<p style="font-size:.72rem;color:#f87171;margin-top:.25rem;">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- URL preview --}}
                <p id="username-preview" style="font-size:.73rem;color:rgba(122,158,142,.8);margin-bottom:.8rem;direction:ltr;text-align:left;padding-right:.2rem;">
                    3tab.app/<strong>{{ old('username', 'username') }}</strong>
                </p>

                {{-- البريد --}}
                <div style="margin-bottom:.8rem;">
                    <label style="display:block;font-size:.78rem;font-weight:600;color:rgba(245,237,228,.5);margin-bottom:.35rem;">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="email@example.com" autocomplete="email" dir="ltr"
                        style="width:100%;padding:.62rem .85rem;border:1px solid {{ $errors->has('email') ? 'rgba(248,113,113,.5)' : 'rgba(198,146,74,.18)' }};border-radius:10px;font-family:'Tajawal',sans-serif;font-size:.88rem;background:rgba(0,0,0,.25);color:#F5EDE4;outline:none;transition:border-color .25s,box-shadow .25s;text-align:left;"
                        onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                        onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                    />
                    @error('email')<p style="font-size:.72rem;color:#f87171;margin-top:.25rem;">{{ $message }}</p>@enderror
                </div>

                {{-- كلمة المرور + تأكيد --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-bottom:.9rem;">
                    <div>
                        <label style="display:block;font-size:.78rem;font-weight:600;color:rgba(245,237,228,.5);margin-bottom:.35rem;">كلمة المرور</label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="password"
                                placeholder="8 أحرف+" autocomplete="new-password" dir="ltr"
                                style="width:100%;padding:.62rem 2.2rem .62rem .85rem;border:1px solid {{ $errors->has('password') ? 'rgba(248,113,113,.5)' : 'rgba(198,146,74,.18)' }};border-radius:10px;font-family:'Tajawal',sans-serif;font-size:.88rem;background:rgba(0,0,0,.25);color:#F5EDE4;outline:none;transition:border-color .25s,box-shadow .25s;"
                                onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                                onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                            />
                            <button type="button" onclick="togglePass('password','eye1')" style="position:absolute;left:.6rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:.8rem;color:rgba(245,237,228,.3);padding:0;line-height:1;transition:color .2s;"
                                    onmouseover="this.style.color='rgba(245,237,228,.7)'" onmouseout="this.style.color='rgba(245,237,228,.3)'">
                                <span id="eye1">👁</span>
                            </button>
                        </div>
                        @error('password')<p style="font-size:.72rem;color:#f87171;margin-top:.25rem;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:.78rem;font-weight:600;color:rgba(245,237,228,.5);margin-bottom:.35rem;">تأكيد المرور</label>
                        <div style="position:relative;">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="أعد الكتابة" autocomplete="new-password" dir="ltr"
                                style="width:100%;padding:.62rem 2.2rem .62rem .85rem;border:1px solid rgba(198,146,74,.18);border-radius:10px;font-family:'Tajawal',sans-serif;font-size:.88rem;background:rgba(0,0,0,.25);color:#F5EDE4;outline:none;transition:border-color .25s,box-shadow .25s;"
                                onfocus="this.style.borderColor='rgba(198,146,74,.6)';this.style.boxShadow='0 0 0 3px rgba(198,146,74,.1)'"
                                onblur="this.style.borderColor='rgba(198,146,74,.18)';this.style.boxShadow='none'"
                            />
                            <button type="button" onclick="togglePass('password_confirmation','eye2')" style="position:absolute;left:.6rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:.8rem;color:rgba(245,237,228,.3);padding:0;line-height:1;transition:color .2s;"
                                    onmouseover="this.style.color='rgba(245,237,228,.7)'" onmouseout="this.style.color='rgba(245,237,228,.3)'">
                                <span id="eye2">👁</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Terms --}}
                <div style="margin-bottom:1.2rem;padding:.75rem .9rem;background:rgba(198,146,74,.05);border-radius:10px;border:1px solid rgba(198,146,74,.15);">
                    <label style="display:flex;align-items:flex-start;gap:.65rem;cursor:pointer;flex-direction:row-reverse;justify-content:flex-end;">
                        <input type="checkbox" name="terms"
                            style="accent-color:#C6924A;width:15px;height:15px;margin-top:2px;flex-shrink:0;cursor:pointer;"
                            {{ old('terms') ? 'checked' : '' }}
                        />
                        <span style="font-size:.8rem;color:rgba(245,237,228,.5);line-height:1.6;">
                            أوافق على
                            <a href="#" style="color:#C6924A;transition:color .2s;" onmouseover="this.style.color='#E8B96A'" onmouseout="this.style.color='#C6924A'">شروط الاستخدام</a>
                            و<a href="#" style="color:#C6924A;transition:color .2s;" onmouseover="this.style.color='#E8B96A'" onmouseout="this.style.color='#C6924A'">سياسة الخصوصية</a>
                        </span>
                    </label>
                    @error('terms')<p style="font-size:.72rem;color:#f87171;margin-top:.3rem;padding-right:1.5rem;">{{ $message }}</p>@enderror
                </div>

                {{-- Submit --}}
                <button type="submit" style="
                    width:100%; padding:.85rem;
                    background:linear-gradient(135deg,#E8B96A,#C6924A);
                    color:#1a1008; border:none; border-radius:12px;
                    font-family:'Tajawal',sans-serif; font-size:.98rem; font-weight:700;
                    cursor:pointer; transition:all .3s;
                    box-shadow:0 4px 18px rgba(198,146,74,.35);
                "
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(198,146,74,.5)'"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 18px rgba(198,146,74,.35)'">
                    إنشاء الحساب ✓
                </button>
            </form>

            {{-- Divider --}}
            <div style="display:flex;align-items:center;gap:.8rem;margin:1.1rem 0 .9rem;">
                <div style="flex:1;height:1px;background:rgba(198,146,74,.12);"></div>
                <span style="font-size:.75rem;color:rgba(245,237,228,.3);">أو</span>
                <div style="flex:1;height:1px;background:rgba(198,146,74,.12);"></div>
            </div>

            <p style="text-align:center;font-size:.85rem;color:rgba(245,237,228,.4);">
                عندك حساب؟
                <a href="{{ route('login') }}" style="color:#C6924A;font-weight:600;transition:color .2s;"
                   onmouseover="this.style.color='#E8B96A'" onmouseout="this.style.color='#C6924A'">
                    سجّل دخولك
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
    input::placeholder { color: rgba(245,237,228,.22) !important; }
</style>

<script>
    function updatePreview(val) {
        const clean = val.toLowerCase().replace(/[^a-z0-9_]/g, '');
        document.getElementById('username-preview').innerHTML = `3tab.app/<strong>${clean || 'username'}</strong>`;
    }
    function updateInitial(val) {
        document.getElementById('avatar-initial').textContent = val.trim() ? val.trim()[0] : '؟';
    }
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById('avatar-img');
                img.src = e.target.result;
                img.style.display = 'block';
                document.getElementById('avatar-initial').style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    const av = document.getElementById('avatar-preview');
    const ovl = document.getElementById('avatar-overlay');
    av.addEventListener('mouseenter', () => ovl.style.opacity = '1');
    av.addEventListener('mouseleave', () => ovl.style.opacity = '0');
    function togglePass(inputId, eyeId) {
        const input = document.getElementById(inputId);
        document.getElementById(eyeId).textContent = (input.type = input.type === 'password' ? 'text' : 'password') === 'text' ? '🙈' : '👁';
    }

    // تعبئة guest_token من localStorage إذا بعث المستخدم عتاباً قبل التسجيل
    (function() {
        const token = localStorage.getItem('atab_guest_token');
        if (token) {
            document.getElementById('guest_token_field').value = token;
            // إضافة hint للمستخدم
            const form = document.getElementById('register-form');
            const hint = document.createElement('p');
            const name = localStorage.getItem('atab_after_register_user') || 'المستلم';
            hint.style.cssText = 'font-size:.78rem;color:rgba(232,185,106,.8);text-align:center;padding:.5rem;background:rgba(198,146,74,.06);border:1px solid rgba(198,146,74,.15);border-radius:10px;margin-bottom:.8rem;';
            hint.textContent = '✓ بعد التسجيل، عتابك سيُربط بحسابك تلقائياً 🤍';
            form.insertBefore(hint, form.firstChild.nextSibling.nextSibling);
        }
    })();
</script>

@endsection
