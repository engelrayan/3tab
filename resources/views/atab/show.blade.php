<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>عتاب · محادثة</title>
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
        .page{max-width:720px;margin:0 auto;padding:1.5rem 1rem 6rem;display:flex;flex-direction:column;gap:1.2rem}

        /* HEADER CARD */
        .head-card{background:linear-gradient(145deg,var(--card2),var(--card));border:1px solid var(--b);border-radius:20px;padding:1.4rem 1.6rem;position:relative;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.5)}
        .head-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--p),var(--pl),var(--sage))}
        .head-top{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
        .head-parties{display:flex;align-items:center;gap:.7rem}
        .party-av{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:1.1rem;font-weight:700;border:1.5px solid var(--b);flex-shrink:0}
        .party-av.sender{background:linear-gradient(135deg,var(--pl),var(--rose));color:var(--dark2)}
        .party-av.receiver{background:linear-gradient(135deg,var(--sage),var(--blue));color:var(--dark2)}
        .party-av.anon{background:linear-gradient(135deg,#2a1a0a,#1a0d05);color:var(--muted)}
        .party-arrow{color:var(--muted);font-size:.85rem}
        .head-meta{display:flex;flex-direction:column;gap:.2rem}
        .head-names{font-size:.9rem;color:var(--text);font-weight:600}
        .head-date{font-size:.73rem;color:var(--muted)}
        .head-badges{display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.85rem}
        .badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .7rem;border-radius:999px;font-size:.7rem;font-weight:600}
        .b-pending{background:rgba(198,146,74,.12);color:var(--pl);border:1px solid rgba(198,146,74,.2)}
        .b-active{background:rgba(90,143,194,.1);color:var(--blue);border:1px solid rgba(90,143,194,.2)}
        .b-reconciled{background:rgba(122,158,142,.12);color:var(--sage);border:1px solid rgba(122,158,142,.25)}
        .b-closed{background:rgba(245,237,228,.06);color:var(--muted);border:1px solid rgba(245,237,228,.1)}
        .b-anon{background:rgba(245,237,228,.05);color:var(--muted);border:1px solid rgba(245,237,228,.1)}
        .b-seen{background:rgba(122,158,142,.1);color:var(--sage);border:1px solid rgba(122,158,142,.2)}
        .b-unseen{background:rgba(198,146,74,.07);color:var(--muted);border:1px solid rgba(198,146,74,.15)}

        /* MESSAGES THREAD */
        .thread{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.35)}
        .thread-msgs{display:flex;flex-direction:column;gap:.1rem;padding:1.2rem;min-height:120px}

        /* BUBBLES */
        .msg-row{display:flex;margin-bottom:.8rem}
        .msg-row.mine{justify-content:flex-start}   /* RTL: mine goes right = flex-start in rtl */
        .msg-row.theirs{justify-content:flex-end}
        .msg-bubble{max-width:72%;border-radius:18px;padding:.75rem 1.1rem;position:relative;line-height:1.75;font-size:.9rem}
        .msg-row.mine .msg-bubble{background:linear-gradient(135deg,rgba(198,146,74,.18),rgba(198,146,74,.12));border:1px solid rgba(198,146,74,.25);border-top-right-radius:4px;color:var(--text)}
        .msg-row.theirs .msg-bubble{background:rgba(0,0,0,.3);border:1px solid var(--b);border-top-left-radius:4px;color:var(--soft)}
        .msg-meta{font-size:.67rem;color:var(--muted);margin-top:.4rem;display:flex;align-items:center;gap:.4rem}
        .msg-row.mine .msg-meta{justify-content:flex-start}
        .msg-row.theirs .msg-meta{justify-content:flex-end}
        .msg-av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-family:'Amiri',serif;font-weight:700;flex-shrink:0;align-self:flex-end;margin-right:.5rem}
        .msg-row.theirs .msg-av{margin-right:0;margin-left:.5rem;order:-1}

        /* RECONCILIATION BANNER */
        .rec-banner{background:linear-gradient(135deg,rgba(122,158,142,.1),rgba(122,158,142,.06));border:1px solid rgba(122,158,142,.25);border-radius:18px;padding:1.4rem;text-align:center}
        .rec-banner h3{font-family:'Amiri',serif;font-size:1.3rem;color:var(--sage);margin-bottom:.3rem}
        .rec-banner p{font-size:.83rem;color:var(--muted);margin-bottom:1rem}

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
        /* FLOATING PARTICLES */
        .celeb-particle{position:fixed;pointer-events:none;z-index:10000;font-size:1.4rem;animation:particleUp var(--dur,3s) ease-out var(--delay,0s) forwards}
        @keyframes particleUp{0%{opacity:1;transform:translateY(0) rotate(0deg) scale(1)}80%{opacity:.8}100%{opacity:0;transform:translateY(-95vh) rotate(var(--spin,360deg)) scale(.5)}}
        /* REJECTED BANNER */
        .rec-rejected{background:rgba(248,113,113,.06);border:1px solid rgba(248,113,113,.2);border-radius:14px;padding:1rem 1.4rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
        .rec-rejected p{font-size:.84rem;color:rgba(248,113,113,.8)}
        /* INCOMING REQUEST BANNER */
        .rec-incoming{background:linear-gradient(135deg,rgba(122,158,142,.12),rgba(122,158,142,.07));border:1px solid rgba(122,158,142,.3);border-radius:18px;padding:1.3rem 1.4rem;animation:fadeUp .4s ease both}
        .rec-incoming-title{font-family:'Amiri',serif;font-size:1.1rem;color:var(--sage);margin-bottom:.3rem}
        .rec-incoming-sub{font-size:.82rem;color:var(--muted);margin-bottom:1rem}
        .rec-actions{display:flex;gap:.7rem;flex-wrap:wrap}
        .btn-rec-reject{padding:.58rem 1.3rem;border-radius:12px;background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.25);color:#f87171;font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:700;cursor:pointer;transition:all .3s}
        .btn-rec-reject:hover{background:rgba(248,113,113,.14);box-shadow:0 4px 14px rgba(248,113,113,.2)}

        /* REPLY + ACTIONS */
        .reply-card{background:var(--card);border:1px solid var(--b);border-radius:20px;padding:1.2rem 1.4rem;box-shadow:0 6px 28px rgba(0,0,0,.35)}
        .reply-card:focus-within{border-color:var(--bh);box-shadow:0 6px 28px rgba(0,0,0,.35),0 0 20px var(--glow)}
        .reply-textarea{width:100%;min-height:90px;background:rgba(0,0,0,.3);border:1px solid var(--b);border-radius:12px;padding:.8rem 1rem;color:var(--text);font-family:'Tajawal',sans-serif;font-size:.9rem;resize:none;outline:none;transition:border-color .2s;direction:rtl;line-height:1.7}
        .reply-textarea:focus{border-color:var(--p);box-shadow:0 0 0 3px rgba(198,146,74,.1)}
        .reply-textarea::placeholder{color:rgba(245,237,228,.2)}
        .reply-row{display:flex;align-items:center;justify-content:space-between;margin-top:.8rem;gap:.7rem;flex-wrap:wrap}
        .char-c{font-size:.73rem;color:var(--muted)}
        .btn-reply{padding:.6rem 1.5rem;border-radius:999px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 3px 16px var(--glow2)}
        .btn-reply:hover{transform:translateY(-2px);box-shadow:0 7px 22px var(--glow3)}
        .btn-reply:disabled{opacity:.55;cursor:not-allowed;transform:none}

        .actions-card{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.3)}
        .actions-head{padding:.9rem 1.4rem;border-bottom:1px solid var(--b);font-size:.78rem;font-weight:700;letter-spacing:.06em;color:var(--muted);text-transform:uppercase}
        .action-row{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.4rem;border-bottom:1px solid var(--b);gap:1rem;flex-wrap:wrap}
        .action-row:last-child{border-bottom:none}
        .action-info p{font-size:.85rem;color:var(--soft);margin-bottom:.18rem}
        .action-info span{font-size:.73rem;color:var(--muted)}

        .btn-rec{padding:.58rem 1.3rem;border-radius:12px;border:none;background:linear-gradient(135deg,rgba(122,158,142,.25),rgba(122,158,142,.15));border:1px solid rgba(122,158,142,.35);color:var(--sage);font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:700;cursor:pointer;transition:all .3s}
        .btn-rec:hover{background:linear-gradient(135deg,rgba(122,158,142,.38),rgba(122,158,142,.25));box-shadow:0 4px 16px rgba(122,158,142,.2)}
        .btn-rec-confirm{padding:.58rem 1.3rem;border-radius:12px;border:none;background:linear-gradient(135deg,var(--sage),#5a8a7a);color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 3px 14px rgba(122,158,142,.3)}
        .btn-rec-confirm:hover{transform:translateY(-2px);box-shadow:0 7px 22px rgba(122,158,142,.45)}
        .btn-close{padding:.5rem 1.1rem;border-radius:12px;background:rgba(245,237,228,.04);border:1px solid rgba(245,237,228,.1);color:var(--muted);font-family:'Tajawal',sans-serif;font-size:.82rem;cursor:pointer;transition:all .2s}
        .btn-close:hover{border-color:rgba(248,113,113,.3);color:#f87171}
        .waiting-badge{display:inline-flex;align-items:center;gap:.4rem;padding:.45rem 1rem;border-radius:12px;background:rgba(198,146,74,.07);border:1px solid var(--b);font-size:.82rem;color:var(--muted)}

        /* CLOSED STATE */
        .closed-box{text-align:center;padding:2rem;background:rgba(0,0,0,.2);border-radius:18px;border:1px dashed rgba(245,237,228,.1)}
        .closed-box p{font-size:.85rem;color:var(--muted)}

        /* ── MODERATION UI ── */
        .msg-actions{display:flex;align-items:center;gap:.5rem;margin-top:.4rem;opacity:0;transition:opacity .2s}
        .msg-row:hover .msg-actions{opacity:1}
        .mod-btn{background:none;border:none;font-size:.72rem;color:var(--muted);cursor:pointer;padding:.2rem .45rem;border-radius:6px;transition:all .2s;font-family:'Tajawal',sans-serif;display:flex;align-items:center;gap:.2rem}
        .mod-btn:hover{background:rgba(255,255,255,.05);color:var(--text)}
        .mod-btn.report-btn:hover{color:#f87171;background:rgba(248,113,113,.08)}
        .mod-btn.ignore-btn:hover{color:var(--pl);background:rgba(198,146,74,.08)}
        .mod-toast{position:fixed;bottom:1.5rem;left:50%;transform:translateX(-50%) translateY(10px);background:#1f1209;border:1px solid var(--bh);border-radius:14px;padding:.7rem 1.4rem;font-size:.82rem;color:var(--text);z-index:99998;opacity:0;pointer-events:none;transition:all .3s;white-space:nowrap;box-shadow:0 8px 30px rgba(0,0,0,.6)}
        .mod-toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
        /* FLAGGED MESSAGE */
        .flagged-wrap{position:relative}
        .flagged-blur{filter:blur(5px);user-select:none;pointer-events:none;transition:filter .3s}
        .flagged-overlay{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.35rem;z-index:2;border-radius:18px;background:rgba(18,11,4,.55);backdrop-filter:blur(2px)}
        .flagged-overlay p{font-size:.72rem;color:rgba(245,237,228,.5);text-align:center;padding:0 .5rem}
        .btn-reveal{background:rgba(198,146,74,.12);border:1px solid var(--b);border-radius:8px;padding:.28rem .8rem;font-size:.72rem;color:var(--pl);cursor:pointer;font-family:'Tajawal',sans-serif;transition:all .2s}
        .btn-reveal:hover{background:rgba(198,146,74,.22);border-color:var(--bh)}

        @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
        .page > *{animation:fadeUp .4s ease both}
        .page > *:nth-child(1){animation-delay:.05s}
        .page > *:nth-child(2){animation-delay:.1s}
        .page > *:nth-child(3){animation-delay:.15s}
        .page > *:nth-child(4){animation-delay:.2s}
        @media(max-width:500px){.msg-bubble{max-width:88%}.head-parties{flex-wrap:wrap}}
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
    <div style="background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.18);color:#4ade80;border-radius:12px;padding:.7rem 1rem;font-size:.85rem;">
        ✓ {{ session('success') }}
    </div>
    @endif
    @if(session('info'))
    <div style="background:rgba(198,146,74,.07);border:1px solid rgba(198,146,74,.25);color:var(--pl);border-radius:12px;padding:.7rem 1rem;font-size:.85rem;">
        {{ session('info') }}
    </div>
    @endif

    {{-- ── HEADER CARD ── --}}
    <div class="head-card">
        <div class="head-top">
            <div class="head-parties">
                {{-- Sender avatar --}}
                @php
                    $isMeSender   = auth()->id() === $atab->sender_id;
                    $isMeReceiver = auth()->id() === $atab->receiver_id;
                    $senderName   = $atab->is_anonymous ? 'مجهول' : ($atab->sender?->name ?? 'مجهول');
                    $receiverName = $atab->receiver?->name ?? '...';
                @endphp
                <div class="party-av sender {{ $atab->is_anonymous ? 'anon' : '' }}">
                    @if($atab->is_anonymous) 🎭
                    @else {{ mb_substr($atab->sender?->name ?? '؟', 0, 1) }}
                    @endif
                </div>
                <span class="party-arrow">→</span>
                <div class="party-av receiver">
                    {{ mb_substr($atab->receiver?->name ?? '؟', 0, 1) }}
                </div>
                <div class="head-meta">
                    <span class="head-names">
                        {{ $isMeSender ? 'أنت' : $senderName }}
                        ← {{ $isMeReceiver ? 'أنت' : $receiverName }}
                    </span>
                    <span class="head-date">{{ $atab->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <div class="head-badges">
            {{-- Status badge --}}
            @if($atab->status === 'pending')
                <span class="badge b-pending">⏳ في الانتظار</span>
            @elseif($atab->status === 'active')
                <span class="badge b-active">💬 محادثة نشطة</span>
            @elseif($atab->status === 'reconciled')
                <span class="badge b-reconciled">🤝 تمت المصالحة</span>
            @elseif($atab->status === 'closed')
                <span class="badge b-closed">🔒 مغلق</span>
            @endif

            {{-- Seen badge — للمرسل فقط --}}
            @if($isMeSender)
                @if($atab->seen_at)
                    <span class="badge b-seen" title="{{ $atab->seen_at->format('Y-m-d H:i') }}">
                        👁️ تم المشاهدة · {{ $atab->seen_at->diffForHumans() }}
                    </span>
                @else
                    <span class="badge b-unseen">⏳ لم يتم الفتح بعد</span>
                @endif
            @endif

            @if($atab->is_anonymous)
                <span class="badge b-anon">🎭 مجهول الهوية</span>
            @endif
        </div>
    </div>

    {{-- ── MESSAGES THREAD ── --}}
    <div class="thread">
        <div class="thread-msgs">
            @forelse($messages as $msg)
            @php
                $isMyMsg      = $msg->sender_id === auth()->id();
                $msgClass     = $isMyMsg ? 'mine' : 'theirs';
                $avLetter     = $isMyMsg
                    ? mb_substr(auth()->user()->name, 0, 1)
                    : ($atab->is_anonymous && !$isMyMsg ? '🎭' : mb_substr($msg->sender?->name ?? '؟', 0, 1));
                $avStyle      = $isMyMsg
                    ? 'background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2)'
                    : ($atab->is_anonymous && !$isMyMsg
                        ? 'background:linear-gradient(135deg,#2a1a0a,#1a0d05);color:var(--muted)'
                        : 'background:linear-gradient(135deg,var(--sage),var(--blue));color:var(--dark2)');
                // Flagged: hide first message of atab if is_flagged and viewer is receiver
                $showFlagged  = $atab->is_flagged && !$isMyMsg && $isMeReceiver && $loop->first;
                // Can ignore: only if sender is known, not anonymous, and I'm the receiver
                $canIgnore    = $isMeReceiver && !$atab->is_anonymous && $atab->sender_id && !$isMyMsg;
            @endphp
            <div class="msg-row {{ $msgClass }}">
                <div class="msg-av" style="{{ $avStyle }}">{{ $avLetter }}</div>
                <div style="flex:1;min-width:0">
                    @if($showFlagged)
                    <div class="flagged-wrap" id="flagged-{{ $msg->id }}">
                        <div class="flagged-blur msg-bubble" style="background:rgba(248,113,113,.06);border-color:rgba(248,113,113,.15)">{{ $msg->body }}</div>
                        <div class="flagged-overlay">
                            <span style="font-size:1.1rem">⚠️</span>
                            <p>هذه الرسالة قد تكون غير لائقة</p>
                            <button class="btn-reveal" onclick="revealFlagged({{ $msg->id }})">عرض الرسالة</button>
                        </div>
                    </div>
                    @else
                    <div class="msg-bubble">{{ $msg->body }}</div>
                    @endif
                    <div class="msg-meta">
                        {{ $msg->created_at->diffForHumans() }}
                        @if($msg->read_at && !$isMyMsg) · <span style="color:var(--sage);">✓ قُرئت</span> @endif
                    </div>
                    @if(!$isMyMsg)
                    <div class="msg-actions">
                        <button class="mod-btn report-btn" onclick="reportAtab({{ $atab->id }})">🚩 إبلاغ</button>
                        @if($canIgnore)
                        <button class="mod-btn ignore-btn" onclick="ignoreUser({{ $atab->id }})">🙈 تجاهل</button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:2rem;color:var(--muted);font-size:.85rem;">لا توجد رسائل</div>
            @endforelse
        </div>
    </div>

    {{-- ── RECONCILIATION: ACCEPTED BANNER ── --}}
    @if($atab->isReconciled())
    <div class="rec-banner">
        <h3>🎉 رجعتم أصحاب</h3>
        <p>"كل خلاف وبعده صفا" · {{ $atab->reconciliation_confirmed_at?->diffForHumans() }}</p>
        <a href="{{ route('profile.show', auth()->user()->username) }}"
           style="font-size:.83rem;color:var(--sage);border:1px solid rgba(122,158,142,.3);border-radius:999px;padding:.4rem 1rem;display:inline-block;transition:all .2s;"
           onmouseover="this.style.background='rgba(122,158,142,.12)'"
           onmouseout="this.style.background='transparent'">
            شارك صفحتك مع غيرهم 🌿
        </a>
    </div>
    @endif

    {{-- ── RECONCILIATION: INCOMING REQUEST ── --}}
    @if($atab->otherPartyRequestedReconciliation(auth()->id()))
    <div class="rec-incoming">
        <p class="rec-incoming-title">🤝 {{ $atab->reconciliationRequester?->name ?? 'الطرف الآخر' }} عايز يصالحك</p>
        <p class="rec-incoming-sub">هل تقبل طلب الصلح؟ · طُلب {{ $atab->reconciliation_requested_at?->diffForHumans() }}</p>
        <div class="rec-actions">
            <form id="confirm-rec-form" method="POST" action="{{ route('atab.confirm', $atab) }}">
                @csrf
                <button type="submit" class="btn-rec-confirm">حليب يا قشطة 🤍</button>
            </form>
            <form method="POST" action="{{ route('atab.reject', $atab) }}">
                @csrf
                <button type="submit" class="btn-rec-reject">لسه زعلان 😅</button>
            </form>
        </div>
    </div>
    @endif

    {{-- ── RECONCILIATION: REJECTED NOTICE ── --}}
    @if($atab->isReconciliationRejected())
    <div class="rec-rejected">
        <p>😔 تم رفض طلب الصلح — يمكن طلبه مرة أخرى لاحقاً</p>
        <form method="POST" action="{{ route('atab.reconcile', $atab) }}">
            @csrf
            <button type="submit" class="btn-rec" style="font-size:.8rem;padding:.42rem 1rem;">أعد المحاولة 🤍</button>
        </form>
    </div>
    @endif

    {{-- ── REPLY FORM (Active or Pending) ── --}}
    @if(!$atab->isReconciled() && $atab->status !== 'closed')
    <div class="reply-card">
        <form method="POST" action="{{ route('atab.reply', $atab) }}" id="reply-form">
            @csrf
            <textarea
                class="reply-textarea"
                name="body"
                id="reply-body"
                placeholder="{{ $isMeReceiver ? 'ردّ على العتاب بصدق...' : 'استمر في الحوار...' }}"
                maxlength="500"
                required
                oninput="document.getElementById('reply-cc').textContent=this.value.length"
            ></textarea>
            @error('body')
                <p style="font-size:.78rem;color:#f87171;margin-top:.3rem;">{{ $message }}</p>
            @enderror
            <div class="reply-row">
                <span class="char-c"><span id="reply-cc">0</span>/500</span>
                <button type="submit" class="btn-reply" id="reply-btn">إرسال الرد ✉️</button>
            </div>
        </form>
    </div>
    @elseif($atab->status === 'closed')
    <div class="closed-box">
        <p>🔒 تم إغلاق هذا العتاب</p>
    </div>
    @endif

    {{-- ── ACTIONS CARD ── --}}
    @if(!$atab->isReconciled() && $atab->status !== 'closed')
    <div class="actions-card">
        <div class="actions-head">إجراءات</div>

        {{-- طلب مصالحة / تأكيدها --}}
        @if(!$atab->otherPartyRequestedReconciliation(auth()->id()))
        <div class="action-row">
            <div class="action-info">
                <p>🤝 المصالحة</p>
                <span>
                    @if($atab->reconciliation_status === 'none' || $atab->reconciliation_status === 'rejected')
                        ابدأ طلب صلح للطرف الآخر
                    @elseif($atab->iRequestedReconciliation(auth()->id()))
                        أرسلت طلب الصلح — في انتظار الطرف الآخر
                    @endif
                </span>
            </div>

            @if($atab->reconciliation_status === 'none' || $atab->reconciliation_status === 'rejected')
                <form method="POST" action="{{ route('atab.reconcile', $atab) }}">
                    @csrf
                    <button type="submit" class="btn-rec">صافي يا لبن 🥛</button>
                </form>
            @elseif($atab->iRequestedReconciliation(auth()->id()))
                <span class="waiting-badge">⏳ في انتظار الرد</span>
            @endif
        </div>
        @endif

        {{-- إغلاق العتاب --}}
        <div class="action-row">
            <div class="action-info">
                <p>🔒 إغلاق</p>
                <span>إنهاء المحادثة بدون مصالحة</span>
            </div>
            <form method="POST" action="{{ route('atab.close', $atab) }}"
                  onsubmit="return confirm('متأكد إنك عايز تغلق العتاب؟')">
                @csrf
                <button type="submit" class="btn-close">إغلاق</button>
            </form>
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
    // ── CELEBRATION ────────────────────────────────────────────────────────────
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
                    bottom:${(-5 - Math.random()*10).toFixed(1)}vh;
                    font-size:${size}rem;
                    --dur:${(2.5 + Math.random()*2.5).toFixed(1)}s;
                    --delay:${(Math.random()*1.5).toFixed(2)}s;
                    --spin:${Math.random()>0.5?'':'-'}${(180+Math.floor(Math.random()*360))}deg;
                `;
                document.body.appendChild(p);
                setTimeout(() => p.remove(), 5500);
            }, i * 90);
        }
    }

    function showCelebration(onDone) {
        const overlay = document.getElementById('celeb-overlay');
        overlay.classList.add('open');
        spawnParticles();
        // progress bar
        setTimeout(() => {
            document.getElementById('celeb-bar').style.width = '100%';
        }, 80);
        setTimeout(() => {
            overlay.classList.remove('open');
            if (onDone) onDone();
        }, 5300);
    }

    // Intercept confirm form → celebrate → AJAX → reload
    document.getElementById('confirm-rec-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const url = this.action;
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

    // Submit reply via AJAX لتجنب reload
    document.getElementById('reply-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn  = document.getElementById('reply-btn');
        const body = document.getElementById('reply-body').value.trim();
        if (!body) return;

        btn.disabled = true;
        btn.textContent = 'جاري الإرسال...';

        try {
            const res = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: new URLSearchParams({ body }),
            });

            if (res.ok) {
                // Reload الصفحة لإظهار الرسالة الجديدة
                window.location.reload();
            } else {
                btn.disabled = false;
                btn.textContent = 'إرسال الرد ✉️';
                alert('حصل خطأ. حاول تاني.');
            }
        } catch {
            btn.disabled = false;
            btn.textContent = 'إرسال الرد ✉️';
        }
    });

    // Scroll to bottom of messages
    (function() {
        const msgs = document.querySelector('.thread-msgs');
        if (msgs) msgs.scrollTop = msgs.scrollHeight;
    })();

    // ── MODERATION HELPERS ────────────────────────────────────────────────
    const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

    function showToast(msg, color) {
        let t = document.getElementById('mod-toast');
        t.textContent = msg;
        t.style.borderColor = color || 'rgba(198,146,74,.4)';
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }

    // 🚩 Report
    window.reportAtab = async function(atabId) {
        try {
            const r = await fetch(`/atab/${atabId}/report`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
                body: JSON.stringify({})
            });
            const d = await r.json();
            showToast(d.message || (d.success ? '✅ تم الإبلاغ' : '⚠️ أبلغت من قبل'),
                      d.success ? 'rgba(74,222,128,.4)' : 'rgba(248,113,113,.4)');
        } catch(_) { showToast('⚠️ حصل خطأ، حاول تاني'); }
    };

    // 🙈 Ignore
    window.ignoreUser = async function(atabId) {
        if (!confirm('تجاهل هذا الشخص؟ لن تصلك رسائله مستقبلاً')) return;
        try {
            const r = await fetch(`/atab/${atabId}/ignore`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
                body: JSON.stringify({})
            });
            const d = await r.json();
            showToast(d.message || (d.success ? '🙈 تم التجاهل' : '⚠️ خطأ'), d.success ? undefined : 'rgba(248,113,113,.4)');
        } catch(_) { showToast('⚠️ حصل خطأ، حاول تاني'); }
    };

    // ⚠️ Reveal flagged message
    window.revealFlagged = function(msgId) {
        const wrap = document.getElementById('flagged-' + msgId);
        if (!wrap) return;
        wrap.querySelector('.flagged-overlay')?.remove();
        const blurred = wrap.querySelector('.flagged-blur');
        if (blurred) blurred.style.filter = 'none';
    };
</script>

{{-- Toast notification --}}
<div class="mod-toast" id="mod-toast"></div>

</body>
</html>
