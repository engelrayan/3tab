<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>طلبات الصلح · عتاب</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --p:#C6924A;--pl:#E8B96A;--pd:#A07035;
            --dark:#1a1008;--dark2:#120b04;--card:#1f1209;--card2:#261609;
            --b:rgba(198,146,74,.15);--bh:rgba(198,146,74,.4);
            --text:#F5EDE4;--muted:rgba(245,237,228,.5);--soft:rgba(245,237,228,.72);
            --glow:rgba(198,146,74,.2);--glow2:rgba(198,146,74,.38);--glow3:rgba(198,146,74,.55);
            --rose:#C2715A;--sage:#7A9E8E;--blue:#5A8FC2;
        }
        html,body{min-height:100vh;background:var(--dark2);color:var(--text);font-family:'Tajawal',sans-serif}
        a{text-decoration:none;color:inherit}
        ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:var(--dark)}::-webkit-scrollbar-thumb{background:var(--pd);border-radius:3px}

        /* NAV */
        .nav{position:sticky;top:0;z-index:100;height:62px;background:rgba(18,11,4,.93);backdrop-filter:blur(20px);border-bottom:1px solid var(--b);padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between}
        .nav-logo{font-family:'Amiri',serif;font-size:1.9rem;background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 10px var(--glow))}
        .nav-back{display:flex;align-items:center;gap:.4rem;font-size:.85rem;color:var(--muted);padding:.4rem .9rem;border:1px solid var(--b);border-radius:999px;transition:all .25s;background:transparent;cursor:pointer;font-family:'Tajawal',sans-serif}
        .nav-back:hover{border-color:var(--bh);color:var(--p)}

        /* PAGE */
        .page{max-width:760px;margin:0 auto;padding:1.8rem 1rem 5rem;display:flex;flex-direction:column;gap:1.4rem}

        /* HERO */
        .page-hero{background:linear-gradient(135deg,rgba(122,158,142,.1),rgba(122,158,142,.05));border:1px solid rgba(122,158,142,.25);border-radius:20px;padding:1.6rem 1.8rem;position:relative;overflow:hidden}
        .page-hero::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--sage),var(--blue),var(--sage))}
        .page-hero h1{font-family:'Amiri',serif;font-size:1.6rem;color:var(--text);margin-bottom:.3rem}
        .page-hero p{font-size:.85rem;color:var(--muted)}
        .page-hero-orn{position:absolute;font-family:'Amiri',serif;font-size:8rem;color:rgba(122,158,142,.05);left:-1rem;bottom:-2rem;user-select:none;pointer-events:none;line-height:1}

        /* SECTION */
        .section-title{font-family:'Amiri',serif;font-size:1.2rem;color:var(--text);display:flex;align-items:center;gap:.5rem;margin-bottom:.8rem}
        .section-count{background:rgba(122,158,142,.15);color:var(--sage);border:1px solid rgba(122,158,142,.25);border-radius:999px;padding:.1rem .65rem;font-size:.72rem;font-weight:700;font-family:'Tajawal',sans-serif}
        .section-count.gold{background:rgba(198,146,74,.12);color:var(--pl);border-color:rgba(198,146,74,.2)}
        .section-count.green{background:rgba(74,222,128,.1);color:#4ade80;border-color:rgba(74,222,128,.2)}

        /* CARD */
        .rec-card{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.35)}

        /* INCOMING ITEM */
        .rec-item{padding:1.2rem 1.4rem;border-bottom:1px solid var(--b);display:flex;flex-direction:column;gap:.9rem;animation:fadeUp .35s ease both}
        .rec-item:last-child{border-bottom:none}
        .rec-item-top{display:flex;align-items:center;gap:.9rem}
        .rec-av{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:1.2rem;font-weight:700;flex-shrink:0;border:2px solid rgba(122,158,142,.3)}
        .rec-av.incoming{background:linear-gradient(135deg,var(--sage),#5a8a7a);color:var(--dark2)}
        .rec-av.outgoing{background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2)}
        .rec-av.accepted{background:linear-gradient(135deg,#4ade80,#22c55e);color:var(--dark2)}
        .rec-meta{flex:1;min-width:0}
        .rec-name{font-size:.92rem;font-weight:600;color:var(--text);margin-bottom:.15rem}
        .rec-preview{font-size:.78rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .rec-time{font-size:.7rem;color:var(--muted);white-space:nowrap}

        /* INCOMING ACTIONS */
        .rec-actions{display:flex;gap:.65rem;flex-wrap:wrap}
        .btn-accept{padding:.58rem 1.4rem;border-radius:12px;border:none;background:linear-gradient(135deg,var(--sage),#5a8a7a);color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 3px 14px rgba(122,158,142,.3)}
        .btn-accept:hover{transform:translateY(-2px);box-shadow:0 7px 22px rgba(122,158,142,.45)}
        .btn-reject{padding:.58rem 1.2rem;border-radius:12px;background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.25);color:#f87171;font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:600;cursor:pointer;transition:all .3s}
        .btn-reject:hover{background:rgba(248,113,113,.14);box-shadow:0 4px 14px rgba(248,113,113,.2)}
        .btn-view{padding:.5rem 1.1rem;border-radius:12px;background:rgba(198,146,74,.07);border:1px solid var(--b);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.82rem;cursor:pointer;transition:all .2s;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem}
        .btn-view:hover{border-color:var(--bh);background:rgba(198,146,74,.13)}

        /* OUTGOING / WAITING */
        .waiting-pill{display:inline-flex;align-items:center;gap:.4rem;padding:.42rem 1rem;border-radius:12px;background:rgba(198,146,74,.07);border:1px solid var(--b);font-size:.8rem;color:var(--muted)}

        /* ACCEPTED ITEM */
        .accepted-item{padding:1rem 1.4rem;border-bottom:1px solid var(--b);display:flex;align-items:center;gap:.9rem;transition:background .2s;text-decoration:none;color:inherit}
        .accepted-item:last-child{border-bottom:none}.accepted-item:hover{background:rgba(74,222,128,.03)}
        .accepted-badge{background:rgba(74,222,128,.1);color:#4ade80;border:1px solid rgba(74,222,128,.2);border-radius:999px;padding:.15rem .65rem;font-size:.7rem;font-weight:700;white-space:nowrap}

        /* EMPTY */
        .empty-box{padding:2.5rem 1.5rem;text-align:center}
        .empty-icon{font-size:2.5rem;margin-bottom:.8rem;opacity:.4}
        .empty-title{font-family:'Amiri',serif;font-size:1.1rem;color:var(--soft);margin-bottom:.3rem}
        .empty-sub{font-size:.82rem;color:var(--muted);line-height:1.7}

        /* FLASH */
        .flash{border-radius:12px;padding:.7rem 1rem;font-size:.85rem;animation:fadeUp .4s ease}
        .flash-s{background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.18);color:#4ade80}
        .flash-i{background:rgba(198,146,74,.07);border:1px solid rgba(198,146,74,.25);color:var(--pl)}

        @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
        .page>*{animation:fadeUp .4s ease both}
        .page>*:nth-child(1){animation-delay:.05s}
        .page>*:nth-child(2){animation-delay:.1s}
        .page>*:nth-child(3){animation-delay:.15s}
        .page>*:nth-child(4){animation-delay:.2s}
        .page>*:nth-child(5){animation-delay:.25s}
        @media(max-width:500px){.rec-actions{flex-direction:column}}

        /* ── CELEBRATION OVERLAY ── */
        #celeb-overlay{position:fixed;inset:0;z-index:9999;background:rgba(12,7,2,.97);backdrop-filter:blur(18px);display:none;align-items:center;justify-content:center;flex-direction:column;gap:1.1rem;padding:2rem;text-align:center}
        #celeb-overlay.open{display:flex;animation:celebFadeIn .4s ease both}
        @keyframes celebFadeIn{from{opacity:0}to{opacity:1}}
        .celeb-body{animation:celebScale .55s cubic-bezier(.34,1.56,.64,1) both;animation-delay:.1s}
        @keyframes celebScale{from{opacity:0;transform:scale(.7)}to{opacity:1;transform:scale(1)}}
        .celeb-emoji{font-size:5.5rem;line-height:1;margin-bottom:.5rem;animation:celebBounce 1.2s ease infinite alternate}
        @keyframes celebBounce{from{transform:translateY(0) rotate(-5deg)}to{transform:translateY(-12px) rotate(5deg)}}
        .celeb-title{font-family:'Amiri',serif;font-size:2.6rem;background:linear-gradient(135deg,var(--pl),#fff0d0,var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:.25rem;filter:drop-shadow(0 0 20px rgba(232,185,106,.4))}
        .celeb-sub{font-size:1.15rem;color:var(--sage);letter-spacing:.05em;margin-bottom:1.6rem}
        .celeb-hadith{background:linear-gradient(135deg,rgba(198,146,74,.1),rgba(198,146,74,.05));border:1px solid rgba(198,146,74,.25);border-radius:18px;padding:1.4rem 1.8rem;max-width:500px;margin:0 auto}
        .celeb-hadith-text{font-family:'Amiri',serif;font-size:1.05rem;color:var(--pl);line-height:2.1;margin-bottom:.7rem}
        .celeb-hadith-ref{font-size:.77rem;color:var(--muted)}
        .celeb-bar-wrap{width:180px;height:3px;background:rgba(198,146,74,.12);border-radius:999px;overflow:hidden;margin-top:1.2rem}
        .celeb-bar{height:100%;background:linear-gradient(90deg,var(--p),var(--pl));border-radius:999px;width:0%;transition:width 5.2s linear}
        .celeb-hint{font-size:.73rem;color:var(--muted)}
        .celeb-particle{position:fixed;pointer-events:none;z-index:10000;animation:particleUp var(--dur,3s) ease-out var(--delay,0s) forwards}
        @keyframes particleUp{0%{opacity:1;transform:translateY(0) rotate(0deg) scale(1)}80%{opacity:.8}100%{opacity:0;transform:translateY(-95vh) rotate(var(--spin,360deg)) scale(.5)}}
    </style>
</head>
<body>

<nav class="nav">
    <a href="{{ route('home') }}" class="nav-logo">عتاب</a>
    <div style="display:flex;align-items:center;gap:.7rem;">
        @include('partials.notif-bell')
        <a href="{{ route('dashboard') }}" class="nav-back">← صندوقي</a>
    </div>
</nav>

<div class="page">

    @if(session('success'))
    <div class="flash flash-s">✓ {{ session('success') }}</div>
    @endif
    @if(session('info'))
    <div class="flash flash-i">{{ session('info') }}</div>
    @endif

    {{-- PAGE HERO --}}
    <div class="page-hero">
        <span class="page-hero-orn">🤝</span>
        <h1>🤝 طلبات الصلح</h1>
        <p>الصلح سيّد الأحكام — ردّ على طلبات الصلح أو تابع حالة طلباتك</p>
    </div>

    {{-- ── INCOMING REQUESTS ── --}}
    <div>
        <h2 class="section-title">
            📩 طلبات واردة
            <span class="section-count">{{ $incoming->count() }}</span>
        </h2>
        <div class="rec-card">
            @forelse($incoming as $atab)
            @php
                $requester = $atab->reconciliationRequester;
                $preview   = $atab->messages->first()?->body ?? '...';
            @endphp
            <div class="rec-item">
                <div class="rec-item-top">
                    <div class="rec-av incoming">{{ mb_substr($requester?->name ?? '؟', 0, 1) }}</div>
                    <div class="rec-meta">
                        <p class="rec-name">{{ $requester?->name ?? 'أحدهم' }} طلب الصلح</p>
                        <p class="rec-preview">{{ Str::limit($preview, 55) }}</p>
                    </div>
                    <span class="rec-time">{{ $atab->reconciliation_requested_at?->diffForHumans() }}</span>
                </div>
                <div class="rec-actions">
                    <form class="confirm-rec-form" method="POST" action="{{ route('atab.confirm', $atab) }}">
                        @csrf
                        <button type="submit" class="btn-accept">حليب يا قشطة 🤍</button>
                    </form>
                    <form method="POST" action="{{ route('atab.reject', $atab) }}">
                        @csrf
                        <button type="submit" class="btn-reject">لسه زعلان 😅</button>
                    </form>
                    <a href="{{ route('atab.show', $atab) }}" class="btn-view">فتح المحادثة ←</a>
                </div>
            </div>
            @empty
            <div class="empty-box">
                <div class="empty-icon">☮️</div>
                <h3 class="empty-title">ما في طلبات واردة</h3>
                <p class="empty-sub">لما يطلب منك أحد الصلح، ستجده هنا</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── OUTGOING REQUESTS ── --}}
    <div>
        <h2 class="section-title">
            📤 طلبات صادرة
            <span class="section-count gold">{{ $outgoing->count() }}</span>
        </h2>
        <div class="rec-card">
            @forelse($outgoing as $atab)
            @php
                $otherParty = auth()->id() === $atab->sender_id ? $atab->receiver : $atab->sender;
                $preview    = $atab->messages->first()?->body ?? '...';
            @endphp
            <div class="rec-item">
                <div class="rec-item-top">
                    <div class="rec-av outgoing">{{ mb_substr($otherParty?->name ?? '؟', 0, 1) }}</div>
                    <div class="rec-meta">
                        <p class="rec-name">إلى {{ $otherParty?->name ?? 'في انتظار الرد' }}</p>
                        <p class="rec-preview">{{ Str::limit($preview, 55) }}</p>
                    </div>
                    <span class="rec-time">{{ $atab->reconciliation_requested_at?->diffForHumans() }}</span>
                </div>
                <div class="rec-actions">
                    <span class="waiting-pill">⏳ في انتظار الرد</span>
                    <a href="{{ route('atab.show', $atab) }}" class="btn-view">فتح المحادثة ←</a>
                </div>
            </div>
            @empty
            <div class="empty-box">
                <div class="empty-icon">✉️</div>
                <h3 class="empty-title">ما أرسلت طلب صلح بعد</h3>
                <p class="empty-sub">يمكنك طلب الصلح من داخل أي محادثة</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── ACCEPTED / COMPLETED RECONCILIATIONS ── --}}
    @if($accepted->count() > 0)
    <div>
        <h2 class="section-title">
            🎉 تمت المصالحة
            <span class="section-count green">{{ $accepted->count() }}</span>
        </h2>
        <div class="rec-card">
            @foreach($accepted as $atab)
            @php
                $isSender   = auth()->id() === $atab->sender_id;
                $otherParty = $isSender ? $atab->receiver : $atab->sender;
                $preview    = $atab->messages->first()?->body ?? '...';
            @endphp
            <a href="{{ route('atab.show', $atab) }}" class="accepted-item">
                <div class="rec-av accepted">{{ mb_substr($otherParty?->name ?? '؟', 0, 1) }}</div>
                <div class="rec-meta" style="flex:1;min-width:0">
                    <p class="rec-name">مع {{ $otherParty?->name ?? 'أحدهم' }}</p>
                    <p class="rec-preview">{{ Str::limit($preview, 50) }}</p>
                </div>
                <span class="accepted-badge">🤝 تمت</span>
                <span class="rec-time" style="margin-right:.5rem">{{ $atab->reconciliation_confirmed_at?->diffForHumans() }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- ── CELEBRATION OVERLAY ── --}}
<div id="celeb-overlay">
    <div class="celeb-body">
        <div class="celeb-emoji">🎉</div>
        <h1 class="celeb-title">رجعتم أصحاب</h1>
        <p class="celeb-sub">حليب يا قشطة 🤍</p>
        <div class="celeb-hadith">
            <p class="celeb-hadith-text">
                «ألا أُخبركم بأفضل من درجةِ الصيامِ والصلاةِ والصدقة؟»<br>
                قالوا: بلى يا رسول الله.<br>
                قال: «إصلاحُ ذاتِ البَيْن، فإنَّ فسادَ ذاتِ البَيْن هي الحالِقة»
            </p>
            <p class="celeb-hadith-ref">— النبي ﷺ · رواه أبو داود والترمذي وصحَّحه الألباني</p>
        </div>
        <div class="celeb-bar-wrap"><div class="celeb-bar" id="celeb-bar"></div></div>
        <p class="celeb-hint">سيتم الإغلاق تلقائياً...</p>
    </div>
</div>

<script>
    const CELEB_EMOJIS = ['🤍','✨','🌟','💛','🎊','🌸','🎉','⭐','💖','🕊️','🌼','💫'];

    function spawnParticles() {
        for (let i = 0; i < 40; i++) {
            setTimeout(() => {
                const p = document.createElement('div');
                p.className = 'celeb-particle';
                p.textContent = CELEB_EMOJIS[Math.floor(Math.random() * CELEB_EMOJIS.length)];
                const size = (.8 + Math.random() * 1.2).toFixed(2);
                p.style.cssText = `
                    left:${(Math.random()*100).toFixed(1)}vw;
                    bottom:${(-5-Math.random()*10).toFixed(1)}vh;
                    font-size:${size}rem;
                    --dur:${(2.5+Math.random()*2.5).toFixed(1)}s;
                    --delay:${(Math.random()*1.5).toFixed(2)}s;
                    --spin:${Math.random()>.5?'':'-'}${180+Math.floor(Math.random()*360)}deg;
                `;
                document.body.appendChild(p);
                setTimeout(() => p.remove(), 5500);
            }, i * 90);
        }
    }

    function showCelebration(onDone) {
        document.getElementById('celeb-overlay').classList.add('open');
        spawnParticles();
        setTimeout(() => { document.getElementById('celeb-bar').style.width = '100%'; }, 80);
        setTimeout(() => {
            document.getElementById('celeb-overlay').classList.remove('open');
            if (onDone) onDone();
        }, 5300);
    }

    // Intercept all confirm forms on this page
    document.querySelectorAll('.confirm-rec-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const url  = this.action;
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            showCelebration(() => window.location.reload());
            try {
                await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: new URLSearchParams({ _token: csrf }),
                });
            } catch (_) {}
        });
    });
</script>
</body>
</html>
