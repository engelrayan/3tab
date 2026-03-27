@auth
@php
    $__notifUnread = \App\Models\Notification::where('user_id', auth()->id())
        ->whereNull('read_at')->count();
@endphp
<style>
/* ── BELL BUTTON ─────────────────────────────────────── */
.nb-wrap{position:relative;display:inline-flex;align-items:center}
.nb-btn{position:relative;width:36px;height:36px;border-radius:10px;background:transparent;border:1px solid rgba(198,146,74,.18);display:flex;align-items:center;justify-content:center;font-size:1rem;cursor:pointer;transition:background .2s,border-color .2s;color:rgba(245,237,228,.5);padding:0;outline:none;font-family:'Tajawal',sans-serif}
.nb-btn:hover,.nb-btn.open{background:rgba(198,146,74,.1);border-color:rgba(198,146,74,.38);color:#E8B96A}
.nb-btn.has-unread{border-color:rgba(198,146,74,.35);color:#E8B96A}
.nb-badge{position:absolute;top:-5px;right:-5px;min-width:16px;height:16px;border-radius:999px;background:#ef4444;color:#fff;font-size:.58rem;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 3px;border:2px solid #120b04;line-height:1}

/* ── DROPDOWN (fixed → never overflows) ─────────────── */
.nb-panel{
    position:fixed;          /* fixed بدل absolute → لا يخرج من الشاشة */
    width:320px;
    background:#160e06;
    border:1px solid rgba(198,146,74,.25);
    border-radius:16px;
    box-shadow:0 20px 50px rgba(0,0,0,.7),0 0 0 1px rgba(198,146,74,.06);
    z-index:99999;
    overflow:hidden;
    display:none;
}
.nb-panel.open{display:block;animation:nbSlide .2s cubic-bezier(.34,1.2,.64,1) both}
@keyframes nbSlide{from{opacity:0;transform:translateY(-8px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}

.nb-head{display:flex;align-items:center;justify-content:space-between;padding:.85rem 1.1rem .8rem;border-bottom:1px solid rgba(198,146,74,.1)}
.nb-head-title{font-size:.87rem;font-weight:700;color:#F5EDE4;display:flex;align-items:center;gap:.45rem}
.nb-head-badge{font-size:.63rem;background:rgba(198,146,74,.13);color:#E8B96A;border:1px solid rgba(198,146,74,.22);border-radius:999px;padding:.1rem .55rem;font-weight:700}
.nb-read-all{font-size:.71rem;color:rgba(245,237,228,.38);background:none;border:none;cursor:pointer;font-family:'Tajawal',sans-serif;padding:0;transition:color .18s}
.nb-read-all:hover{color:#E8B96A}

/* ── ITEMS ───────────────────────────────────────────── */
.nb-list{max-height:300px;overflow-y:auto}
.nb-list::-webkit-scrollbar{width:3px}
.nb-list::-webkit-scrollbar-thumb{background:rgba(198,146,74,.15);border-radius:2px}

.nb-item{display:flex;align-items:flex-start;gap:.75rem;padding:.8rem 1.1rem;cursor:pointer;transition:background .15s;border-bottom:1px solid rgba(255,255,255,.03);position:relative}
.nb-item:last-child{border-bottom:none}
.nb-item:hover{background:rgba(198,146,74,.06)}
.nb-item.unread{background:rgba(198,146,74,.04)}
.nb-item.unread::after{content:'';position:absolute;right:0;top:12%;bottom:12%;width:2.5px;border-radius:2px;background:linear-gradient(to bottom,#C6924A,rgba(198,146,74,.2))}

.nb-ico{width:34px;height:34px;min-width:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.9rem;margin-top:.1rem}
.nb-ico.t-new_atab          {background:rgba(90,143,194,.12)}
.nb-ico.t-reply              {background:rgba(198,146,74,.1)}
.nb-ico.t-reconcile_request  {background:rgba(122,158,142,.1)}
.nb-ico.t-reconcile_accepted {background:rgba(74,222,128,.08)}

.nb-text{flex:1;min-width:0}
/* ← أزلنا white-space:nowrap عشان النص ما يتقطعش */
.nb-msg{font-size:.8rem;color:rgba(245,237,228,.78);line-height:1.5;margin-bottom:.15rem;word-break:break-word}
.nb-item.unread .nb-msg{color:#F5EDE4;font-weight:500}
.nb-time{font-size:.66rem;color:rgba(245,237,228,.3)}
.nb-dot{width:6px;height:6px;min-width:6px;border-radius:50%;background:#C6924A;margin-top:.55rem}

/* ── EMPTY ───────────────────────────────────────────── */
.nb-empty{padding:2.2rem 1.2rem;text-align:center}
.nb-empty-ico{font-size:2rem;opacity:.25;margin-bottom:.5rem}
.nb-empty-title{font-size:.82rem;color:rgba(245,237,228,.5);margin-bottom:.3rem;font-weight:600}
.nb-empty-sub{font-size:.74rem;color:rgba(245,237,228,.28);line-height:1.6}

/* ── FOOTER ──────────────────────────────────────────── */
.nb-footer{padding:.6rem 1.1rem;border-top:1px solid rgba(198,146,74,.08);display:flex;justify-content:center}
.nb-footer a{font-size:.76rem;color:rgba(198,146,74,.55);transition:color .18s;display:flex;align-items:center;gap:.3rem}
.nb-footer a:hover{color:#E8B96A}
.nb-loading{padding:1.5rem;text-align:center;font-size:.78rem;color:rgba(245,237,228,.3)}
</style>

<div class="nb-wrap" id="nb-wrap">
    <button class="nb-btn {{ $__notifUnread > 0 ? 'has-unread' : '' }}"
            id="nb-btn"
            onclick="nbToggle(event)"
            title="الإشعارات"
            aria-label="الإشعارات">
        🔔
        <span class="nb-badge" id="nb-badge"
              style="{{ $__notifUnread === 0 ? 'display:none' : '' }}">{{ $__notifUnread > 9 ? '9+' : $__notifUnread }}</span>
    </button>

    <div class="nb-panel" id="nb-panel">
        <div class="nb-head">
            <span class="nb-head-title">
                الإشعارات
                @if($__notifUnread > 0)
                <span class="nb-head-badge">{{ $__notifUnread }} جديد</span>
                @endif
            </span>
            <button class="nb-read-all" onclick="nbReadAll()" type="button">قراءة الكل</button>
        </div>
        <div class="nb-list" id="nb-list">
            <div class="nb-loading">جاري التحميل...</div>
        </div>
        <div class="nb-footer">
            <a href="{{ route('notifications.index') }}">عرض كل الإشعارات ←</a>
        </div>
    </div>
</div>

<script>
(function(){
    let nbOpen = false, nbLoaded = false;
    const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

    /* ── فتح / إغلاق الـ panel مع حساب position صحيحة ── */
    window.nbToggle = function(e) {
        e?.stopPropagation();
        nbOpen = !nbOpen;
        const panel = document.getElementById('nb-panel');
        const btn   = document.getElementById('nb-btn');

        if (nbOpen) {
            // احسب position قبل ما نعرض
            const rect       = btn.getBoundingClientRect();
            const panelW     = 320;
            const gap        = 8;
            const vpW        = window.innerWidth;
            const vpH        = window.innerHeight;

            // vertical
            const topVal = rect.bottom + gap;
            panel.style.top = topVal + 'px';

            // horizontal: افتح على اليمين من الـ button لو فيه مكان، غير كده على اليسار
            if (rect.left + panelW + 16 <= vpW) {
                panel.style.left  = rect.left + 'px';
                panel.style.right = 'auto';
            } else {
                panel.style.left  = 'auto';
                panel.style.right = (vpW - rect.right) + 'px';
            }

            panel.classList.add('open');
            btn.classList.add('open');
            if (!nbLoaded) nbLoad();
        } else {
            panel.classList.remove('open');
            btn.classList.remove('open');
        }
    };

    /* ── إعادة حساب position لو اتغيّرت الشاشة ── */
    window.addEventListener('resize', () => {
        if (nbOpen) {
            nbOpen = false;
            document.getElementById('nb-panel').classList.remove('open');
            document.getElementById('nb-btn').classList.remove('open');
        }
    });

    /* ── جلب الإشعارات ── */
    async function nbLoad() {
        try {
            const r = await fetch('{{ route("notifications.fetch") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
            });
            const d = await r.json();
            nbLoaded = true;
            nbRender((d.notifications || []).slice(0, 5));
        } catch(_) {
            document.getElementById('nb-list').innerHTML =
                '<div class="nb-loading">تعذّر التحميل</div>';
        }
    }

    /* ── رسم الإشعارات ── */
    function nbRender(items) {
        const list = document.getElementById('nb-list');
        if (!items.length) {
            list.innerHTML = `
                <div class="nb-empty">
                    <div class="nb-empty-ico">🔕</div>
                    <p class="nb-empty-title">لسه مفيش إشعارات</p>
                    <p class="nb-empty-sub">ابعت عتاب وخلي حد يتفاعل معاك 👀</p>
                </div>`;
            return;
        }
        list.innerHTML = items.map(n => `
            <div class="nb-item ${n.read ? '' : 'unread'}" onclick="nbGo(${n.id},'${n.url}',this)">
                <div class="nb-ico t-${n.type}">${n.icon}</div>
                <div class="nb-text">
                    <p class="nb-msg">${n.message}</p>
                    <span class="nb-time">${n.time}</span>
                </div>
                ${!n.read ? '<div class="nb-dot"></div>' : ''}
            </div>`).join('');
    }

    /* ── click على إشعار ── */
    window.nbGo = async function(id, url, el) {
        if (el?.classList.contains('unread')) {
            el.classList.remove('unread');
            el.querySelector('.nb-dot')?.remove();
            nbDecrBadge();
            try {
                await fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF(),
                        'Accept': 'application/json'
                    }
                });
            } catch(_) {}
        }
        window.location.href = url;
    };

    /* ── قراءة الكل ── */
    window.nbReadAll = async function() {
        try {
            await fetch('{{ route("notifications.readAll") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF(),
                    'Accept': 'application/json'
                }
            });
        } catch(_) {}
        document.querySelectorAll('.nb-item.unread').forEach(el => {
            el.classList.remove('unread');
            el.querySelector('.nb-dot')?.remove();
        });
        const b = document.getElementById('nb-badge');
        if (b) { b.style.display = 'none'; b.textContent = '0'; }
        document.getElementById('nb-btn')?.classList.remove('has-unread');
        // إخفاء badge في الهيدر
        document.querySelector('.nb-head-badge')?.remove();
    };

    /* ── تقليل العداد ── */
    function nbDecrBadge() {
        const b = document.getElementById('nb-badge');
        if (!b) return;
        const c = parseInt(b.textContent) || 0;
        if (c <= 1) {
            b.style.display = 'none';
            b.textContent = '0';
            document.getElementById('nb-btn')?.classList.remove('has-unread');
        } else {
            b.textContent = c - 1 > 9 ? '9+' : c - 1;
        }
    }

    /* ── إغلاق عند الضغط خارج الـ panel ── */
    document.addEventListener('click', function(e) {
        const wrap = document.getElementById('nb-wrap');
        if (nbOpen && wrap && !wrap.contains(e.target)) {
            document.getElementById('nb-panel').classList.remove('open');
            document.getElementById('nb-btn').classList.remove('open');
            nbOpen = false;
        }
    });

    /* ── إغلاق بـ Escape ── */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && nbOpen) {
            document.getElementById('nb-panel').classList.remove('open');
            document.getElementById('nb-btn').classList.remove('open');
            nbOpen = false;
        }
    });
})();
</script>
@endauth
