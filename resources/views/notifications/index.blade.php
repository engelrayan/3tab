<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>الإشعارات · عتاب</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --p:#C6924A;--pl:#E8B96A;--pd:#A07035;
            --dark:#1a1008;--dark2:#120b04;--card:#1f1209;--card2:#261609;
            --b:rgba(198,146,74,.15);--bh:rgba(198,146,74,.4);
            --text:#F5EDE4;--muted:rgba(245,237,228,.45);--soft:rgba(245,237,228,.72);
            --glow:rgba(198,146,74,.18);--glow2:rgba(198,146,74,.35);
            --rose:#C2715A;--sage:#7A9E8E;--blue:#5A8FC2;
        }
        html,body{min-height:100vh;background:var(--dark2);color:var(--text);font-family:'Tajawal',sans-serif}
        a{text-decoration:none;color:inherit}
        ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:var(--dark)}::-webkit-scrollbar-thumb{background:var(--pd);border-radius:3px}

        /* NAV */
        .nav{position:sticky;top:0;z-index:100;height:60px;background:rgba(18,11,4,.95);backdrop-filter:blur(20px);border-bottom:1px solid var(--b);padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between}
        .nav-logo{font-family:'Amiri',serif;font-size:1.9rem;background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .nav-end{display:flex;align-items:center;gap:.7rem}
        .nav-back{font-size:.82rem;color:var(--muted);padding:.38rem .9rem;border:1px solid var(--b);border-radius:999px;transition:all .2s;background:transparent;cursor:pointer;font-family:'Tajawal',sans-serif}
        .nav-back:hover{border-color:var(--bh);color:var(--p)}

        /* PAGE */
        .page{max-width:660px;margin:0 auto;padding:2rem 1rem 5rem;display:flex;flex-direction:column;gap:1.2rem}

        /* PAGE HEADER */
        .pg-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.8rem;margin-bottom:.2rem}
        .pg-header-left h1{font-family:'Amiri',serif;font-size:1.65rem;color:var(--text);margin-bottom:.18rem}
        .pg-header-left p{font-size:.82rem;color:var(--muted)}
        .pg-unread-pill{background:rgba(198,146,74,.1);border:1px solid rgba(198,146,74,.22);border-radius:999px;padding:.28rem .9rem;font-size:.75rem;font-weight:700;color:var(--pl)}

        /* FILTER TABS */
        .filter-tabs{display:flex;gap:.4rem}
        .ftab{padding:.34rem 1.05rem;border-radius:999px;font-size:.78rem;font-weight:600;cursor:pointer;transition:all .2s;background:rgba(198,146,74,.06);border:1px solid var(--b);color:var(--muted);font-family:'Tajawal',sans-serif}
        .ftab.active{background:linear-gradient(135deg,var(--pl),var(--p));border-color:transparent;color:#120b04}

        /* READ ALL BTN */
        .btn-read-all{padding:.38rem 1.1rem;border-radius:999px;background:transparent;border:1px solid var(--b);color:var(--muted);font-size:.78rem;font-family:'Tajawal',sans-serif;cursor:pointer;transition:all .2s}
        .btn-read-all:hover{border-color:var(--bh);color:var(--pl)}

        /* NOTIFICATION CARDS */
        .notif-group{display:flex;flex-direction:column;gap:.5rem}
        .notif-card{display:flex;align-items:center;gap:1rem;padding:1rem 1.2rem;background:var(--card);border:1px solid rgba(198,146,74,.08);border-radius:14px;cursor:pointer;transition:all .22s;position:relative;overflow:hidden}
        .notif-card:hover{background:var(--card2);border-color:rgba(198,146,74,.2);transform:translateX(-2px)}
        .notif-card.unread{border-color:rgba(198,146,74,.18);background:linear-gradient(135deg,rgba(198,146,74,.05),var(--card))}
        .notif-card.unread::before{content:'';position:absolute;right:0;top:18%;bottom:18%;width:2.5px;border-radius:2px;background:linear-gradient(to bottom,var(--p),var(--pl))}

        /* ICON */
        .nc-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0}
        .nc-icon.t-new_atab   {background:rgba(90,143,194,.1); border:1px solid rgba(90,143,194,.18)}
        .nc-icon.t-reply       {background:rgba(198,146,74,.1); border:1px solid rgba(198,146,74,.18)}
        .nc-icon.t-reconcile_request {background:rgba(122,158,142,.1);border:1px solid rgba(122,158,142,.18)}
        .nc-icon.t-reconcile_accepted{background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.15)}

        /* BODY */
        .nc-body{flex:1;min-width:0}
        .nc-title{font-size:.88rem;font-weight:600;color:var(--text);margin-bottom:.15rem;line-height:1.4}
        .notif-card.unread .nc-title{color:#F5EDE4}
        .nc-sub{font-size:.73rem;color:var(--muted)}

        /* ACTION BUTTON */
        .nc-btn{padding:.32rem .9rem;border-radius:8px;background:rgba(198,146,74,.09);border:1px solid rgba(198,146,74,.18);color:var(--pl);font-size:.74rem;font-family:'Tajawal',sans-serif;font-weight:600;cursor:pointer;transition:all .18s;white-space:nowrap;flex-shrink:0}
        .nc-btn:hover{background:rgba(198,146,74,.18);border-color:var(--bh)}
        .nc-unread-dot{width:8px;height:8px;border-radius:50%;background:var(--p);flex-shrink:0}

        /* ── EMPTY STATE ────────────────────────────────── */
        .empty-state{padding:3.5rem 1.5rem 2.5rem;text-align:center;display:flex;flex-direction:column;align-items:center;gap:1rem}
        .empty-icon{font-size:3.5rem;line-height:1;margin-bottom:.2rem;opacity:.55}
        .empty-title{font-family:'Amiri',serif;font-size:1.5rem;color:var(--text);margin-bottom:.2rem}
        .empty-sub{font-size:.88rem;color:var(--muted);line-height:1.75;max-width:320px}
        .empty-actions{display:flex;gap:.7rem;flex-wrap:wrap;justify-content:center;margin-top:.5rem}
        .btn-cta-gold{padding:.65rem 1.5rem;border-radius:12px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:#120b04;font-family:'Tajawal',sans-serif;font-size:.9rem;font-weight:700;cursor:pointer;transition:all .25s;box-shadow:0 3px 14px var(--glow2)}
        .btn-cta-gold:hover{transform:translateY(-2px);box-shadow:0 7px 22px var(--glow2)}
        .btn-cta-ghost{padding:.65rem 1.4rem;border-radius:12px;background:rgba(198,146,74,.08);border:1px solid var(--bh);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:600;cursor:pointer;transition:all .22s}
        .btn-cta-ghost:hover{background:rgba(198,146,74,.15)}

        /* ── SUGGESTION BLOCK ───────────────────────────── */
        .suggestion-block{background:rgba(198,146,74,.04);border:1px solid rgba(198,146,74,.12);border-radius:14px;padding:1.2rem 1.4rem;display:flex;align-items:flex-start;gap:.9rem}
        .sug-icon{font-size:1.3rem;line-height:1;margin-top:.1rem;flex-shrink:0}
        .sug-body{flex:1}
        .sug-title{font-size:.85rem;font-weight:600;color:var(--pl);margin-bottom:.2rem}
        .sug-sub{font-size:.78rem;color:var(--muted);line-height:1.65;margin-bottom:.75rem}
        .btn-sug-share{padding:.42rem 1.1rem;border-radius:999px;background:rgba(198,146,74,.1);border:1px solid rgba(198,146,74,.22);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.79rem;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-sug-share:hover{background:rgba(198,146,74,.2);border-color:var(--bh)}

        /* ── DATE LABEL ─────────────────────────────────── */
        .date-label{font-size:.72rem;color:var(--muted);padding:.2rem 0 .4rem .2rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em}

        /* ── FLASH ──────────────────────────────────────── */
        .flash-s{background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.18);color:#4ade80;border-radius:12px;padding:.7rem 1rem;font-size:.84rem}

        @keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        .page>*{animation:fadeUp .35s ease both}
        .page>*:nth-child(1){animation-delay:.04s}
        .page>*:nth-child(2){animation-delay:.08s}
        .page>*:nth-child(3){animation-delay:.12s}
        .page>*:nth-child(4){animation-delay:.16s}
        @media(max-width:480px){.empty-actions{flex-direction:column;align-items:stretch}.empty-state{padding:2.5rem 1rem 1.5rem}}
    </style>
</head>
<body>

<nav class="nav">
    <a href="{{ route('home') }}" class="nav-logo">عتاب</a>
    <div class="nav-end">
        @include('partials.notif-bell')
        <a href="{{ route('dashboard') }}" class="nav-back">← صندوقي</a>
    </div>
</nav>

<div class="page">

    @if(session('success'))
    <div class="flash-s">✓ {{ session('success') }}</div>
    @endif

    @if($notifications->isNotEmpty())

    {{-- ── HEADER ── --}}
    <div class="pg-header">
        <div class="pg-header-left">
            <h1>🔔 الإشعارات</h1>
            <p>تابع كل اللي حصل معاك</p>
        </div>
        <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
            @if($unreadCount > 0)
            <span class="pg-unread-pill">{{ $unreadCount }} غير مقروءة</span>
            @endif
            @if($unreadCount > 0)
            <button class="btn-read-all" onclick="pageReadAll()">قراءة الكل ✓</button>
            @endif
        </div>
    </div>

    {{-- ── FILTER TABS ── --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.6rem">
        <div class="filter-tabs">
            <button class="ftab active" id="tab-all" onclick="filterTab('all')">الكل ({{ $notifications->count() }})</button>
            @if($unreadCount > 0)
            <button class="ftab" id="tab-unread" onclick="filterTab('unread')">غير مقروءة ({{ $unreadCount }})</button>
            @endif
        </div>
    </div>

    {{-- ── NOTIFICATIONS LIST ── --}}
    <div class="notif-group" id="notif-group">
        @foreach($notifications as $n)
        @php
            $isUnread = !$n->read_at;
            $url      = $n->getUrl();
            $icon     = $n->getIcon();
            $msg      = $n->getMessage();
        @endphp
        <div class="notif-card {{ $isUnread ? 'unread' : '' }}"
             id="nc-{{ $n->id }}"
             data-read="{{ $isUnread ? '0' : '1' }}"
             onclick="pageGo({{ $n->id }}, '{{ $url }}', this)">
            <div class="nc-icon t-{{ $n->type }}">{{ $icon }}</div>
            <div class="nc-body">
                <p class="nc-title">{{ $msg }}</p>
                <span class="nc-sub">{{ $n->created_at->diffForHumans() }}</span>
            </div>
            <button class="nc-btn" onclick="event.stopPropagation();pageGo({{ $n->id }},'{{ $url }}',document.getElementById('nc-{{ $n->id }}'))">
                عرض
            </button>
            @if($isUnread)
            <div class="nc-unread-dot"></div>
            @endif
        </div>
        @endforeach
    </div>

    @else

    {{-- ── EMPTY STATE ── --}}
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <h2 class="empty-title">لسه مفيش إشعارات</h2>
        <p class="empty-sub">ابدأ وخلي حد يتفاعل معاك 👀<br>ابعت عتاب أو شارك لينكك وانتظر الرد</p>
        <div class="empty-actions">
            <button class="btn-cta-gold" onclick="window.location.href='{{ route('dashboard') }}'">
                ✉️ ابعت عتاب
            </button>
            <button class="btn-cta-ghost" id="copy-link-btn" onclick="copyMyLink()">
                🔗 انسخ لينكك
            </button>
        </div>
    </div>

    {{-- ── SUGGESTION BLOCK ── --}}
    <div class="suggestion-block">
        <span class="sug-icon">💡</span>
        <div class="sug-body">
            <p class="sug-title">اقتراح</p>
            <p class="sug-sub">شارك لينكك مع أصحابك وخليهم يقولوا اللي جواهم — لما حد يبعت عتاب هتعرف فوراً</p>
            <button class="btn-sug-share" onclick="copyMyLink()">مشاركة لينكي 🔗</button>
        </div>
    </div>

    @endif

</div>

<script>
const CSRF = ()=> document.querySelector('meta[name="csrf-token"]').content;
const MY_PROFILE = '{{ route("profile.show", auth()->user()->username) }}';

// ── GO TO NOTIFICATION ──────────────────────────────────────────────────────
window.pageGo = async function(id, url, el) {
    if(el?.dataset.read === '0') {
        el.classList.remove('unread');
        el.querySelector('.nc-unread-dot')?.remove();
        el.dataset.read = '1';
        updateUnreadCount(-1);
        try {
            await fetch(`/notifications/${id}/read`, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF(),'Accept':'application/json'}
            });
        } catch(_){}
    }
    window.location.href = url;
};

// ── READ ALL ────────────────────────────────────────────────────────────────
window.pageReadAll = async function() {
    try {
        await fetch('{{ route("notifications.readAll") }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF(),'Accept':'application/json'}
        });
    } catch(_){}

    document.querySelectorAll('.notif-card.unread').forEach(el => {
        el.classList.remove('unread');
        el.querySelector('.nc-unread-dot')?.remove();
        el.dataset.read = '1';
    });
    updateUnreadCount(0, true);
    // hide the read-all button and unread pill
    document.querySelectorAll('.btn-read-all, .pg-unread-pill, #tab-unread').forEach(el => {
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 300);
    });
};

// ── FILTER TABS ─────────────────────────────────────────────────────────────
window.filterTab = function(mode) {
    document.querySelectorAll('.ftab').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + mode)?.classList.add('active');

    document.querySelectorAll('.notif-card').forEach(card => {
        if(mode === 'all'){
            card.style.display = '';
        } else {
            card.style.display = card.dataset.read === '0' ? '' : 'none';
        }
    });
};

// ── COPY LINK ───────────────────────────────────────────────────────────────
window.copyMyLink = function() {
    const text = `قول اللي جواك ليا بصراحة 👀\n${MY_PROFILE}`;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copy-link-btn');
        if(btn){ btn.textContent = '✓ تم النسخ!'; setTimeout(() => btn.textContent = '🔗 انسخ لينكك', 2200); }
        if(typeof showToast === 'function') showToast('تم نسخ لينكك 🔗', 's');
    }).catch(()=>{});
};

// ── UPDATE UNREAD COUNT ──────────────────────────────────────────────────────
function updateUnreadCount(delta, reset = false) {
    // update nb-badge in bell (if present)
    const badge = document.getElementById('nb-badge');
    if(!badge) return;
    if(reset){ badge.style.display='none'; badge.textContent='0'; return; }
    const cur = parseInt(badge.textContent)||0;
    const next = Math.max(0, cur + delta);
    if(next <= 0){ badge.style.display='none'; badge.textContent='0'; }
    else { badge.style.display=''; badge.textContent = next > 9 ? '9+' : next; }
}
</script>
</body>
</html>
