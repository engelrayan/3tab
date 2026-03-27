{{--
    Modal إنشاء عتاب برابط
    استخدمه بـ: @include('atab.create-link-modal')
    وافتحه بـ: openCreateLinkModal()
--}}

<div class="modal-overlay" id="create-link-modal" onclick="if(event.target===this)closeCreateLinkModal()">
    <div class="modal" style="max-width:480px;">
        <button class="modal-close" onclick="closeCreateLinkModal()">✕</button>

        {{-- Step 1: Write message --}}
        <div id="step-write">
            <h2 class="modal-title">➕ ابدأ عتاب جديد</h2>
            <p class="modal-sub">اكتب عتابك وشارك الرابط مع من تريد</p>

            <textarea id="link-body" placeholder="اكتب عتابك هنا... كلام الصدق أحسن من الصمت" maxlength="500"
                style="width:100%;min-height:120px;background:rgba(0,0,0,.3);border:1px solid rgba(198,146,74,.2);border-radius:12px;padding:.9rem 1rem;color:#F5EDE4;font-family:'Tajawal',sans-serif;font-size:.92rem;resize:none;outline:none;margin-bottom:.9rem;transition:border-color .2s;line-height:1.7;"
                oninput="updateLinkCharCount(this)"
                onfocus="this.style.borderColor='rgba(198,146,74,.6)'"
                onblur="this.style.borderColor='rgba(198,146,74,.2)'"></textarea>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:.7rem;">
                <label style="display:flex;align-items:center;gap:.5rem;font-size:.83rem;color:rgba(245,237,228,.55);cursor:pointer;">
                    <input type="checkbox" id="link-anon" style="accent-color:#C6924A;width:15px;height:15px;" />
                    أرسل مجهول الهوية
                </label>
                <span id="link-char-count" style="font-size:.75rem;color:rgba(245,237,228,.4);">0/500</span>
            </div>

            <div style="margin-bottom:1.2rem;">
                <label style="display:block;font-size:.8rem;color:rgba(245,237,228,.45);margin-bottom:.4rem;">
                    صلاحية الرابط (اختياري)
                </label>
                <select id="link-expires" style="width:100%;padding:.6rem .9rem;background:rgba(0,0,0,.3);border:1px solid rgba(198,146,74,.2);border-radius:10px;color:#F5EDE4;font-family:'Tajawal',sans-serif;font-size:.87rem;outline:none;">
                    <option value="">بدون تحديد (دائم)</option>
                    <option value="1">يوم واحد</option>
                    <option value="3">3 أيام</option>
                    <option value="7">أسبوع</option>
                    <option value="30">شهر</option>
                </select>
            </div>

            <button onclick="createAtabLink()" style="
                width:100%;padding:.85rem;border-radius:12px;border:none;
                background:linear-gradient(135deg,#E8B96A,#C6924A);
                color:#120b04;font-family:'Tajawal',sans-serif;
                font-size:.97rem;font-weight:700;cursor:pointer;
                transition:all .3s;box-shadow:0 4px 18px rgba(198,146,74,.35);
            "
            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(198,146,74,.5)'"
            onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 18px rgba(198,146,74,.35)'">
                إنشاء الرابط ✨
            </button>
        </div>

        {{-- Step 2: Show link --}}
        <div id="step-link" style="display:none;">
            <div style="text-align:center;margin-bottom:1.5rem;">
                <div style="font-size:2.5rem;margin-bottom:.8rem;">🎉</div>
                <h2 class="modal-title">الرابط جاهز!</h2>
                <p class="modal-sub">شاركه مع من تريد — بعد التسجيل العتاب يتضاف لحسابه تلقائياً</p>
            </div>

            {{-- Link box --}}
            <div style="display:flex;align-items:center;gap:.6rem;background:rgba(0,0,0,.3);border:1px solid rgba(198,146,74,.3);border-radius:12px;padding:.75rem 1rem;margin-bottom:1.2rem;">
                <span id="generated-link" style="flex:1;font-size:.82rem;color:rgba(245,237,228,.7);direction:ltr;text-align:left;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                <button onclick="copyGeneratedLink()" id="copy-link-btn" style="
                    background:rgba(198,146,74,.15);border:1px solid rgba(198,146,74,.3);
                    border-radius:8px;padding:.32rem .8rem;
                    font-size:.78rem;color:#E8B96A;cursor:pointer;
                    transition:all .2s;font-family:'Tajawal',sans-serif;white-space:nowrap;
                ">نسخ</button>
            </div>

            {{-- Share options --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-bottom:1.2rem;">
                <button onclick="shareWhatsApp()" style="
                    padding:.65rem;border-radius:11px;border:none;
                    background:rgba(37,211,102,.12);color:#25d366;
                    font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:600;
                    cursor:pointer;transition:all .2s;border:1px solid rgba(37,211,102,.2);
                "
                onmouseover="this.style.background='rgba(37,211,102,.2)'"
                onmouseout="this.style.background='rgba(37,211,102,.12)'">
                    📱 واتساب
                </button>
                <button onclick="copyGeneratedLink()" style="
                    padding:.65rem;border-radius:11px;border:none;
                    background:rgba(198,146,74,.1);color:#E8B96A;
                    font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:600;
                    cursor:pointer;transition:all .2s;border:1px solid rgba(198,146,74,.2);
                "
                onmouseover="this.style.background='rgba(198,146,74,.2)'"
                onmouseout="this.style.background='rgba(198,146,74,.1)'">
                    📋 نسخ الرابط
                </button>
            </div>

            {{-- Analytics hint --}}
            <div style="background:rgba(198,146,74,.06);border:1px solid rgba(198,146,74,.15);border-radius:11px;padding:.75rem 1rem;font-size:.78rem;color:rgba(245,237,228,.45);text-align:center;">
                📊 ستجد إحصائيات المشاهدات في لوحة التحكم
            </div>

            <button onclick="resetCreateModal()" style="
                width:100%;margin-top:.9rem;padding:.7rem;border-radius:11px;
                background:transparent;border:1px solid rgba(198,146,74,.2);
                color:rgba(245,237,228,.5);font-family:'Tajawal',sans-serif;
                font-size:.85rem;cursor:pointer;transition:all .2s;
            "
            onmouseover="this.style.borderColor='rgba(198,146,74,.4)';this.style.color='rgba(245,237,228,.8)'"
            onmouseout="this.style.borderColor='rgba(198,146,74,.2)';this.style.color='rgba(245,237,228,.5)'">
                ➕ إنشاء عتاب آخر
            </button>
        </div>
    </div>
</div>

<script>
let generatedLink = '';

function openCreateLinkModal() {
    document.getElementById('create-link-modal').classList.add('open');
    document.getElementById('link-body').focus();
}
function closeCreateLinkModal() {
    document.getElementById('create-link-modal').classList.remove('open');
}
function resetCreateModal() {
    document.getElementById('step-write').style.display = 'block';
    document.getElementById('step-link').style.display  = 'none';
    document.getElementById('link-body').value = '';
    document.getElementById('link-anon').checked = false;
    document.getElementById('link-expires').value = '';
    document.getElementById('link-char-count').textContent = '0/500';
    generatedLink = '';
}
function updateLinkCharCount(el) {
    document.getElementById('link-char-count').textContent = el.value.length + '/500';
}

async function createAtabLink() {
    const body    = document.getElementById('link-body').value.trim();
    const anon    = document.getElementById('link-anon').checked;
    const expires = document.getElementById('link-expires').value;

    if (!body || body.length < 5) {
        alert('اكتب رسالة لا تقل عن 5 أحرف');
        return;
    }

    const btn = event.target;
    btn.disabled = true;
    btn.textContent = 'جاري الإنشاء...';

    try {
        const res = await fetch('{{ route("atab.link.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                body,
                is_anonymous: anon,
                expires_days: expires || null,
            }),
        });

        const data = await res.json();

        if (data.success) {
            generatedLink = data.link;
            document.getElementById('generated-link').textContent = data.link;
            document.getElementById('step-write').style.display = 'none';
            document.getElementById('step-link').style.display  = 'block';
        } else {
            alert('حدث خطأ، حاول مرة أخرى');
        }
    } catch (e) {
        alert('حدث خطأ في الاتصال');
    } finally {
        btn.disabled = false;
        btn.textContent = 'إنشاء الرابط ✨';
    }
}

function copyGeneratedLink() {
    if (!generatedLink) return;
    navigator.clipboard.writeText(generatedLink).then(() => {
        const btn = document.getElementById('copy-link-btn');
        btn.textContent = '✓ تم النسخ';
        btn.style.color = '#4ade80';
        btn.style.borderColor = '#4ade80';
        setTimeout(() => {
            btn.textContent = 'نسخ';
            btn.style.color = '';
            btn.style.borderColor = '';
        }, 2000);
    });
}

function shareWhatsApp() {
    if (!generatedLink) return;
    const text = encodeURIComponent(في كلام كان لازم يتقال… اقرأه هنا 👇\n' + generatedLink);
    window.open('https://wa.me/?text=' + text, '_blank');
}
</script>
