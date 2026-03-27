<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>صندوقي · عتاب</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--p:#C6924A;--pl:#E8B96A;--pd:#A07035;--dark:#1a1008;--dark2:#120b04;--card:#1f1209;--card2:#261609;--b:rgba(198,146,74,.15);--bh:rgba(198,146,74,.4);--text:#F5EDE4;--muted:rgba(245,237,228,.5);--soft:rgba(245,237,228,.72);--glow:rgba(198,146,74,.2);--glow2:rgba(198,146,74,.38);--glow3:rgba(198,146,74,.55);--rose:#C2715A;--sage:#7A9E8E;--blue:#5A8FC2}
        html,body{min-height:100vh;background:var(--dark2);color:var(--text);font-family:'Tajawal',sans-serif}
        a{text-decoration:none;color:inherit}
        ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:var(--dark)}::-webkit-scrollbar-thumb{background:var(--pd);border-radius:3px}
        /* TOAST */
        #toast-wrap{position:fixed;top:1.2rem;left:50%;transform:translateX(-50%);z-index:9999;display:flex;flex-direction:column;gap:.5rem;pointer-events:none;min-width:220px;align-items:center}
        .toast{padding:.75rem 1.4rem;border-radius:12px;font-size:.87rem;font-weight:500;box-shadow:0 8px 28px rgba(0,0,0,.5);pointer-events:auto;animation:toastIn .3s ease both;display:flex;align-items:center;gap:.6rem;white-space:nowrap}
        .toast-s{background:linear-gradient(135deg,#1a3a1a,#0d2a0d);border:1px solid rgba(74,222,128,.3);color:#4ade80}
        .toast-e{background:linear-gradient(135deg,#3a1a1a,#2a0d0d);border:1px solid rgba(248,113,113,.3);color:#f87171}
        .toast-i{background:linear-gradient(135deg,var(--card2),var(--card));border:1px solid var(--bh);color:var(--pl)}
        @keyframes toastIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}
        @keyframes toastOut{from{opacity:1}to{opacity:0;transform:translateY(-10px)}}
        /* NAV */
        .nav{position:sticky;top:0;z-index:100;height:62px;background:rgba(18,11,4,.93);backdrop-filter:blur(20px);border-bottom:1px solid var(--b);padding:0 2rem;display:flex;align-items:center;justify-content:space-between}
        .nav-logo{font-family:'Amiri',serif;font-size:1.9rem;background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 10px var(--glow))}
        .nav-right{display:flex;align-items:center;gap:.8rem}
        .nav-user{display:flex;align-items:center;gap:.6rem;padding:.32rem .85rem .32rem .45rem;background:rgba(198,146,74,.07);border:1px solid var(--b);border-radius:999px;cursor:pointer;transition:all .25s}
        .nav-user:hover{border-color:var(--bh);background:rgba(198,146,74,.13)}
        .nav-av{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--pl),var(--rose));display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:.95rem;color:var(--dark2);font-weight:700}
        .nav-name{font-size:.82rem;color:var(--soft)}
        .btn-ghost{padding:.4rem 1rem;border-radius:999px;font-family:'Tajawal',sans-serif;font-size:.82rem;background:transparent;border:1px solid var(--b);color:var(--muted);cursor:pointer;transition:all .25s}
        .btn-ghost:hover{border-color:var(--bh);color:var(--p);box-shadow:0 0 12px var(--glow)}
        /* JOURNEY */
        .journey-bar{display:flex;gap:.6rem;flex-wrap:wrap;animation:fadeUp .5s ease both}
        .journey-pill{
            display:inline-flex;align-items:center;gap:.4rem;
            padding:.32rem .85rem;border-radius:999px;
            font-size:.75rem;font-weight:600;border:1px solid;
            cursor:pointer;text-decoration:none;
            transition:all .22s;
        }
        .journey-pill.pending{background:rgba(198,146,74,.1);border-color:rgba(198,146,74,.3);color:var(--pl)}
        .journey-pill.pending:hover{background:rgba(198,146,74,.2);border-color:rgba(198,146,74,.6);box-shadow:0 0 12px rgba(198,146,74,.2)}
        .journey-pill.active{background:rgba(90,143,194,.1);border-color:rgba(90,143,194,.3);color:var(--blue)}
        .journey-pill.active:hover{background:rgba(90,143,194,.2);border-color:rgba(90,143,194,.6)}
        .journey-pill.rec{background:rgba(122,158,142,.1);border-color:rgba(122,158,142,.3);color:var(--sage)}
        .journey-pill.rec:hover{background:rgba(122,158,142,.2);border-color:rgba(122,158,142,.6)}
        /* SMART ALERT */
        .smart-alert{display:flex;align-items:center;justify-content:space-between;gap:1rem;background:rgba(194,113,90,.08);border:1px solid rgba(194,113,90,.3);border-radius:16px;padding:.9rem 1.4rem;animation:fadeUp .5s ease both;flex-wrap:wrap}
        .smart-alert p{font-size:.88rem;color:#e8a090}
        .btn-smart{padding:.38rem 1rem;border-radius:999px;background:rgba(194,113,90,.15);border:1px solid rgba(194,113,90,.35);color:#e8a090;font-family:'Tajawal',sans-serif;font-size:.8rem;font-weight:600;cursor:pointer;transition:all .2s}
        /* PAGE */
        .page{max-width:1080px;margin:0 auto;padding:2rem 1.5rem 5rem;display:flex;flex-direction:column;gap:1.4rem}
        /* HERO */
        .hero{background:linear-gradient(135deg,var(--card2),var(--card));border:1px solid var(--b);border-radius:24px;padding:2rem 2.2rem;position:relative;overflow:hidden;box-shadow:0 10px 40px rgba(0,0,0,.5);animation:fadeUp .5s ease both}
        .hero::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--p),var(--pl),var(--sage))}
        .hero-glow{position:absolute;left:-40px;top:-40px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.1),transparent 70%);pointer-events:none}
        .hero-orn{position:absolute;font-family:'Amiri',serif;font-size:10rem;color:rgba(198,146,74,.04);right:-1rem;bottom:-2rem;user-select:none;pointer-events:none;line-height:1}
        .hero-inner{display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;position:relative;z-index:1}
        .hero-left h2{font-family:'Amiri',serif;font-size:1.8rem;color:var(--text);margin-bottom:.3rem}
        .hero-left p{font-size:.87rem;color:var(--muted)}
        .mood-tag{display:inline-flex;align-items:center;gap:.4rem;margin-top:.65rem;background:rgba(198,146,74,.09);border:1px solid var(--bh);border-radius:999px;padding:.35rem .95rem;font-size:.82rem;color:var(--pl);cursor:pointer;transition:all .25s}
        .mood-tag:hover{background:rgba(198,146,74,.17);box-shadow:0 0 14px var(--glow)}
        .hero-actions{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap}
        .btn-primary{padding:.72rem 1.6rem;border-radius:12px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.92rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 4px 18px var(--glow2);white-space:nowrap}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px var(--glow3)}
        .btn-secondary{padding:.72rem 1.4rem;border-radius:12px;background:rgba(198,146,74,.09);border:1px solid var(--bh);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:600;cursor:pointer;transition:all .25s;white-space:nowrap}
        .btn-secondary:hover{background:rgba(198,146,74,.18);box-shadow:0 0 16px var(--glow)}
        /* MOOD BANNER */
        .mood-banner{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;background:rgba(198,146,74,.07);border:1px solid var(--bh);border-radius:16px;padding:.9rem 1.4rem;animation:fadeUp .5s .04s ease both;cursor:pointer;transition:background .2s,border-color .2s}
        .mood-banner:hover{background:rgba(198,146,74,.11);border-color:rgba(198,146,74,.5)}
        .mood-banner p{font-size:.88rem;color:var(--pl)}
        .btn-sug{padding:.4rem 1.1rem;border-radius:999px;background:rgba(198,146,74,.15);border:1px solid var(--bh);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.82rem;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-sug:hover{background:rgba(198,146,74,.25);box-shadow:0 0 12px var(--glow)}
        /* QUICK ACTIONS */
        .quick-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;animation:fadeUp .5s .06s ease both}
        .qa-card{background:var(--card);border:1px solid var(--b);border-radius:18px;padding:1.3rem 1rem;display:flex;flex-direction:column;align-items:center;gap:.55rem;cursor:pointer;transition:all .3s cubic-bezier(.34,1.56,.64,1);text-decoration:none;color:inherit;box-shadow:0 4px 18px rgba(0,0,0,.3);position:relative;overflow:hidden}
        .qa-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p),transparent);opacity:0;transition:opacity .3s}
        .qa-card:hover{transform:translateY(-6px);border-color:var(--bh);box-shadow:0 14px 35px rgba(0,0,0,.5),0 0 20px var(--glow)}
        .qa-card:hover::after{opacity:1}
        .qa-icon{font-size:1.8rem;line-height:1}.qa-label{font-size:.85rem;font-weight:600;color:var(--soft)}.qa-sub{font-size:.72rem;color:var(--muted)}
        /* STATS */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;animation:fadeUp .5s .1s ease both}
        .stat{border-radius:18px;padding:1.2rem 1rem;display:flex;flex-direction:column;align-items:center;gap:.3rem;text-align:center;cursor:pointer;transition:all .3s cubic-bezier(.34,1.56,.64,1);position:relative;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.35);text-decoration:none;color:inherit}
        .stat::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;opacity:0;transition:opacity .3s}
        .stat:hover{transform:translateY(-7px) scale(1.02)}.stat:hover::after{opacity:1}
        .stat-recv{background:linear-gradient(145deg,#0d1e2e,#0a1520);border:1px solid rgba(90,143,194,.25)}.stat-recv:hover{box-shadow:0 16px 36px rgba(0,0,0,.5),0 0 22px rgba(90,143,194,.3)}.stat-recv::after{background:linear-gradient(90deg,transparent,var(--blue),transparent)}
        .stat-sent{background:linear-gradient(145deg,#2e1a0d,#1f1008);border:1px solid rgba(198,146,74,.25)}.stat-sent:hover{box-shadow:0 16px 36px rgba(0,0,0,.5),0 0 22px var(--glow2)}.stat-sent::after{background:linear-gradient(90deg,transparent,var(--p),transparent)}
        .stat-rec{background:linear-gradient(145deg,#0d2018,#091510);border:1px solid rgba(122,158,142,.25)}.stat-rec:hover{box-shadow:0 16px 36px rgba(0,0,0,.5),0 0 22px rgba(122,158,142,.3)}.stat-rec::after{background:linear-gradient(90deg,transparent,var(--sage),transparent)}
        .stat-pend{background:linear-gradient(145deg,#2a1209,#1a0b05);border:1px solid rgba(194,113,90,.25)}.stat-pend:hover{box-shadow:0 16px 36px rgba(0,0,0,.5),0 0 22px rgba(194,113,90,.3)}.stat-pend::after{background:linear-gradient(90deg,transparent,var(--rose),transparent)}
        .stat-icon{font-size:1.3rem}.stat-val{font-family:'Amiri',serif;font-size:2.3rem;line-height:1;font-weight:700}.stat-lbl{font-size:.74rem;color:var(--muted)}
        .stat-recv .stat-val{color:var(--blue);text-shadow:0 0 16px rgba(90,143,194,.4)}.stat-sent .stat-val{color:var(--p);text-shadow:0 0 16px var(--glow2)}.stat-rec .stat-val{color:var(--sage);text-shadow:0 0 16px rgba(122,158,142,.4)}.stat-pend .stat-val{color:var(--rose);text-shadow:0 0 16px rgba(194,113,90,.4)}
        /* TWO COL */
        .two-col{display:grid;grid-template-columns:1fr 340px;gap:1.2rem;align-items:start;animation:fadeUp .5s .14s ease both}
        .section-card{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.35)}
        .section-head{display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.4rem;border-bottom:1px solid var(--b)}
        .section-title{font-family:'Amiri',serif;font-size:1.1rem;color:var(--text)}
        .tabs-mini{display:flex;gap:.4rem}
        .tab-m{padding:.32rem 1rem;border-radius:999px;font-family:'Tajawal',sans-serif;font-size:.78rem;cursor:pointer;transition:all .2s;background:rgba(198,146,74,.06);border:1px solid var(--b);color:var(--muted)}
        .tab-m.active{background:linear-gradient(135deg,var(--pl),var(--p));border-color:transparent;color:var(--dark2);font-weight:700;box-shadow:0 2px 10px var(--glow2)}
        .atab-item{display:flex;align-items:center;gap:1rem;padding:1rem 1.4rem;border-bottom:1px solid var(--b);cursor:pointer;transition:all .22s;text-decoration:none;color:inherit}
        .atab-item:last-child{border-bottom:none}.atab-item:hover{background:rgba(198,146,74,.05);padding-right:1.8rem}.atab-item.unread{border-right:3px solid var(--p)}
        .ai-av{width:40px;height:40px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--pl),var(--rose));display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:1.1rem;color:var(--dark2);font-weight:700;border:1.5px solid var(--b)}
        .ai-av.anon{background:linear-gradient(135deg,#2a1a0a,#1a0d05);color:var(--muted)}
        .ai-body{flex:1;min-width:0}.ai-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:.2rem}
        .ai-name{font-size:.88rem;font-weight:600;color:var(--text)}.ai-time{font-size:.7rem;color:var(--muted);white-space:nowrap}
        .ai-msg{font-size:.8rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:340px}
        .ai-tags{display:flex;gap:.35rem;margin-top:.3rem;flex-wrap:wrap}
        .badge{padding:.15rem .55rem;border-radius:999px;font-size:.68rem;font-weight:600}
        .b-pending{background:rgba(198,146,74,.12);color:var(--pl);border:1px solid rgba(198,146,74,.2)}
        .b-active{background:rgba(90,143,194,.1);color:var(--blue);border:1px solid rgba(90,143,194,.2)}
        .b-reconciled{background:rgba(122,158,142,.12);color:var(--sage);border:1px solid rgba(122,158,142,.25)}
        .b-anon{background:rgba(245,237,228,.05);color:var(--muted);border:1px solid rgba(245,237,228,.1)}
        .b-link{background:rgba(198,146,74,.1);color:var(--pl);border:1px solid rgba(198,146,74,.2)}
        .b-seen{background:rgba(122,158,142,.1);color:var(--sage);border:1px solid rgba(122,158,142,.2)}
        .b-unseen{background:rgba(198,146,74,.06);color:var(--muted);border:1px solid rgba(198,146,74,.12)}
        .b-guest{background:rgba(90,143,194,.08);color:var(--blue);border:1px solid rgba(90,143,194,.15)}
        .empty-box{padding:3rem 1.5rem;text-align:center}
        .empty-icon{font-size:2.5rem;margin-bottom:.8rem;opacity:.45}
        .empty-title{font-family:'Amiri',serif;font-size:1.2rem;color:var(--soft);margin-bottom:.4rem}
        .empty-sub{font-size:.82rem;color:var(--muted);line-height:1.7;margin-bottom:1rem}
        .btn-start{padding:.6rem 1.4rem;border-radius:999px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.85rem;font-weight:700;cursor:pointer;transition:all .25s;box-shadow:0 3px 12px var(--glow2)}
        .btn-start:hover{transform:translateY(-1px);box-shadow:0 6px 18px var(--glow3)}
        /* RECONCILIATION CARD */
        .rec-card{background:linear-gradient(145deg,rgba(122,158,142,.09),rgba(122,158,142,.04));border:1px solid rgba(122,158,142,.28);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.3)}
        .rec-card-head{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.3rem;border-bottom:1px solid rgba(122,158,142,.15);cursor:pointer;transition:background .2s}
        .rec-card-head:hover{background:rgba(122,158,142,.07)}
        .rec-card-title{font-family:'Amiri',serif;font-size:1.05rem;color:var(--sage)}
        .rec-card-badge{background:rgba(122,158,142,.18);color:var(--sage);border:1px solid rgba(122,158,142,.3);border-radius:999px;padding:.15rem .65rem;font-size:.72rem;font-weight:700}
        .rec-item{display:flex;align-items:center;gap:.9rem;padding:.85rem 1.3rem;border-bottom:1px solid rgba(122,158,142,.1);cursor:pointer;transition:background .2s;text-decoration:none;color:inherit}
        .rec-item:last-child{border-bottom:none}.rec-item:hover{background:rgba(122,158,142,.07)}
        .rec-item-av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--sage),#5a8a7a);display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:1rem;color:var(--dark2);font-weight:700;flex-shrink:0}
        .rec-item-body{flex:1;min-width:0}
        .rec-item-name{font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.1rem}
        .rec-item-sub{font-size:.72rem;color:var(--muted)}
        .rec-item-actions{display:flex;gap:.45rem}
        .btn-accept-sm{padding:.3rem .8rem;border-radius:8px;background:linear-gradient(135deg,var(--sage),#5a8a7a);border:none;color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.75rem;font-weight:700;cursor:pointer;transition:all .25s;white-space:nowrap}
        .btn-accept-sm:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(122,158,142,.4)}
        .btn-reject-sm{padding:.3rem .75rem;border-radius:8px;background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.2);color:#f87171;font-family:'Tajawal',sans-serif;font-size:.75rem;cursor:pointer;transition:all .2s;white-space:nowrap}
        .btn-reject-sm:hover{background:rgba(248,113,113,.13)}
        /* RIGHT */
        .right-col{display:flex;flex-direction:column;gap:1.1rem}
        .activity-card{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.3)}
        .act-item{
            display:flex;align-items:flex-start;gap:.85rem;
            padding:.9rem 1.2rem;border-bottom:1px solid var(--b);
            transition:background .2s, box-shadow .2s;
            text-decoration:none;color:inherit;
            cursor:pointer;position:relative;
        }
        .act-item:last-child{border-bottom:none}
        .act-item:hover{background:rgba(198,146,74,.06);box-shadow:inset 3px 0 0 var(--p)}
        .act-item:active{background:rgba(198,146,74,.1)}
        .act-arrow{margin-right:auto;margin-top:.25rem;font-size:.7rem;color:rgba(198,146,74,.35);transition:all .2s;flex-shrink:0}
        .act-item:hover .act-arrow{color:var(--p);transform:translateX(-3px)}
        .act-dot{width:32px;height:32px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:.9rem;margin-top:.1rem}
        .act-dot.recv{background:rgba(90,143,194,.12);border:1px solid rgba(90,143,194,.2)}.act-dot.sent{background:rgba(198,146,74,.1);border:1px solid rgba(198,146,74,.2)}
        .act-body{flex:1;min-width:0}
        .act-body p{font-size:.82rem;color:var(--soft);line-height:1.5}.act-body span{font-size:.7rem;color:var(--muted)}
        /* MOOD WEEK */
        .mood-week{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.3)}
        .mood-week-grid{display:flex;gap:.4rem;justify-content:space-around;padding:1rem 1.2rem;flex-wrap:wrap}
        .mood-day{display:flex;flex-direction:column;align-items:center;gap:.3rem}
        .mood-day-emoji{font-size:1.4rem;line-height:1}.mood-day-label{font-size:.62rem;color:var(--muted)}
        .mood-day-dot{width:6px;height:6px;border-radius:50%;background:var(--b)}.mood-day.today .mood-day-dot{background:var(--p);box-shadow:0 0 6px var(--glow2)}
        /* SUGGESTIONS */
        .suggest-card{background:var(--card);border:1px solid var(--b);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.3)}
        .safety-btn{flex:1;padding:.45rem .6rem;border-radius:10px;border:1px solid var(--b);background:transparent;color:var(--muted);font-family:'Tajawal',sans-serif;font-size:.78rem;font-weight:600;cursor:pointer;transition:all .2s}
        .safety-btn.safety-active{background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);border-color:transparent;box-shadow:0 2px 10px var(--glow2)}
        .suggest-item{padding:.9rem 1.2rem;border-bottom:1px solid var(--b)}.suggest-item:last-child{border-bottom:none}
        .suggest-text{font-size:.82rem;color:var(--soft);line-height:1.6;margin-bottom:.5rem}
        .btn-sm{padding:.32rem .9rem;border-radius:999px;background:rgba(198,146,74,.1);border:1px solid var(--bh);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.75rem;font-weight:600;cursor:pointer;transition:all .2s}
        .btn-sm:hover{background:rgba(198,146,74,.2);box-shadow:0 0 10px var(--glow)}
        /* ── SHARE CARD ── */
        .share-card{background:linear-gradient(145deg,#1e1208,#160e06);border:1px solid rgba(198,146,74,.3);border-radius:20px;overflow:hidden;box-shadow:0 6px 28px rgba(0,0,0,.4);position:relative}
        .share-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--rose),var(--p),var(--pl),var(--p),var(--rose))}
        .share-card-glow{position:absolute;top:-30px;right:-30px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(198,146,74,.1),transparent 70%);pointer-events:none}
        .share-head{padding:1rem 1.2rem .85rem;border-bottom:1px solid rgba(198,146,74,.12);position:relative;z-index:1}
        .share-head-title{font-family:'Amiri',serif;font-size:1.05rem;color:var(--pl);margin-bottom:.18rem}
        .share-head-sub{font-size:.71rem;color:rgba(198,146,74,.55)}
        .share-body{padding:.95rem 1.2rem;display:flex;flex-direction:column;gap:.7rem;position:relative;z-index:1}
        .share-link-row{display:flex;align-items:center;gap:.45rem;background:rgba(0,0,0,.35);border:1px solid rgba(198,146,74,.18);border-radius:10px;padding:.45rem .75rem}
        .share-link-text{flex:1;font-size:.76rem;color:rgba(198,146,74,.7);direction:ltr;text-align:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:500}
        .share-link-badge{font-size:.62rem;background:rgba(198,146,74,.12);border:1px solid rgba(198,146,74,.2);border-radius:999px;padding:.12rem .55rem;color:rgba(198,146,74,.6);white-space:nowrap}
        .share-btns{display:flex;gap:.5rem}
        .btn-copy{flex:1;padding:.55rem .8rem;border-radius:10px;background:rgba(198,146,74,.1);border:1px solid rgba(198,146,74,.25);color:var(--pl);font-family:'Tajawal',sans-serif;font-size:.8rem;font-weight:600;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:.35rem}
        .btn-copy:hover{background:rgba(198,146,74,.2);border-color:rgba(198,146,74,.45);box-shadow:0 0 14px var(--glow)}
        .btn-copy.copied{background:rgba(74,222,128,.1);border-color:rgba(74,222,128,.3);color:#4ade80}
        .btn-share-open{flex:1;padding:.55rem .8rem;border-radius:10px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.8rem;font-weight:700;cursor:pointer;transition:all .3s;display:flex;align-items:center;justify-content:center;gap:.35rem;box-shadow:0 3px 14px var(--glow2);animation:sharePulse 3s ease-in-out infinite}
        .btn-share-open:hover{transform:translateY(-2px);box-shadow:0 7px 22px var(--glow3);animation:none}
        @keyframes sharePulse{0%,100%{box-shadow:0 3px 14px var(--glow2)}50%{box-shadow:0 3px 22px var(--glow3),0 0 0 4px rgba(198,146,74,.1)}}
        .share-hint{font-size:.71rem;color:rgba(198,146,74,.45);text-align:center;line-height:1.5;padding:0 .3rem}
        /* Share social modal */
        .share-modal{background:linear-gradient(160deg,#2a1508,#1a0d06);border:1px solid rgba(198,146,74,.3);border-radius:24px;padding:1.6rem 1.4rem;width:100%;max-width:360px;max-height:calc(100dvh - 2rem);overflow-y:auto;-webkit-overflow-scrolling:touch;box-shadow:0 30px 80px rgba(0,0,0,.8);animation:scaleIn .25s ease;position:relative;margin:auto}
        .share-modal::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--rose),var(--pl),var(--rose));border-radius:24px 24px 0 0}
        .share-modal-title{font-family:'Amiri',serif;font-size:1.2rem;color:var(--text);text-align:center;margin-bottom:.25rem}
        .share-modal-sub{font-size:.77rem;color:var(--muted);text-align:center;margin-bottom:1.1rem;line-height:1.6}
        .share-msg-preview{background:rgba(0,0,0,.3);border:1px solid var(--b);border-radius:11px;padding:.75rem 1rem;font-size:.78rem;color:var(--soft);line-height:1.7;margin-bottom:1rem;direction:rtl}
        .share-platforms{display:flex;flex-direction:column;gap:.5rem}
        .share-platform-btn{display:flex;align-items:center;gap:.8rem;padding:.7rem 1rem;border-radius:13px;border:1px solid;cursor:pointer;transition:all .25s;font-family:'Tajawal',sans-serif;font-size:.86rem;font-weight:600;text-decoration:none;color:inherit}
        .sp-wa{background:rgba(37,211,102,.07);border-color:rgba(37,211,102,.25);color:#25d366}.sp-wa:hover{background:rgba(37,211,102,.15);box-shadow:0 4px 16px rgba(37,211,102,.2)}
        .sp-fb{background:rgba(24,119,242,.07);border-color:rgba(24,119,242,.25);color:#4e87f0}.sp-fb:hover{background:rgba(24,119,242,.15);box-shadow:0 4px 16px rgba(24,119,242,.2)}
        .sp-tw{background:rgba(245,237,228,.04);border-color:rgba(245,237,228,.15);color:var(--soft)}.sp-tw:hover{background:rgba(245,237,228,.09);box-shadow:0 4px 16px rgba(0,0,0,.3)}
        .sp-copy{background:rgba(198,146,74,.08);border-color:rgba(198,146,74,.25);color:var(--pl)}.sp-copy:hover{background:rgba(198,146,74,.16);box-shadow:0 4px 16px var(--glow)}
        .share-platform-icon{font-size:1.3rem;flex-shrink:0}
        .share-modal-close{display:block;width:100%;margin-top:.9rem;padding:.5rem;background:none;border:none;color:var(--muted);font-family:'Tajawal',sans-serif;font-size:.8rem;cursor:pointer;transition:color .2s}
        .share-modal-close:hover{color:var(--pl)}
        /* MODALS */
        .modal-overlay{
            position:fixed;inset:0;z-index:1000;
            background:rgba(0,0,0,.8);backdrop-filter:blur(8px);
            display:none;align-items:center;justify-content:center;
            padding:1rem;
            overflow-y:auto;
            -webkit-overflow-scrolling:touch;
        }
        .modal-overlay.open{display:flex;animation:fadeIn .2s ease}
        .modal{
            background:var(--card2);border:1px solid var(--bh);border-radius:20px;
            padding:1.5rem 1.25rem;
            width:100%;max-width:440px;
            max-height:calc(100dvh - 2rem);
            overflow-y:auto;
            -webkit-overflow-scrolling:touch;
            box-shadow:0 24px 60px rgba(0,0,0,.7),0 0 40px var(--glow);
            animation:scaleIn .25s ease;
            position:relative;
            margin:auto;
        }
        .modal-close{
            position:absolute;top:.85rem;left:.85rem;
            background:rgba(198,146,74,.1);border:1px solid var(--b);
            width:30px;height:30px;border-radius:50%;cursor:pointer;
            font-size:.82rem;color:var(--muted);
            display:flex;align-items:center;justify-content:center;
            transition:all .2s;z-index:2;flex-shrink:0;
        }
        .modal-close:hover{background:rgba(198,146,74,.2);color:var(--p)}
        .modal-title{font-family:'Amiri',serif;font-size:1.35rem;color:var(--text);text-align:center;margin-bottom:.25rem;padding-left:2rem}
        .modal-sub{font-size:.81rem;color:var(--muted);text-align:center;margin-bottom:1.2rem}
        @media(max-width:480px){
            .modal-overlay{padding:.5rem;align-items:flex-end}
            .modal{
                border-radius:22px 22px 0 0;
                max-height:92dvh;
                padding:1.3rem 1rem 1.5rem;
                width:100%;max-width:100%;
                margin:0;
            }
            .modal::before{
                content:'';display:block;width:36px;height:4px;
                background:rgba(198,146,74,.3);border-radius:2px;
                margin:0 auto .9rem;
            }
        }
        .mood-grid-m{display:flex;flex-wrap:wrap;gap:.55rem;justify-content:center;margin-bottom:1.1rem}
        .mood-pill{padding:.45rem 1.1rem;border-radius:999px;background:rgba(198,146,74,.07);border:1px solid var(--b);color:var(--soft);font-size:.85rem;cursor:pointer;transition:all .25s;font-family:'Tajawal',sans-serif}
        .mood-pill:hover{border-color:var(--bh);background:rgba(198,146,74,.14);color:var(--pl)}
        .mood-pill.selected{background:linear-gradient(135deg,var(--pl),var(--p));border-color:transparent;color:var(--dark2);font-weight:700;box-shadow:0 3px 12px var(--glow2)}
        .mood-inp{width:100%;padding:.65rem 1rem;background:rgba(0,0,0,.3);border:1px solid var(--b);border-radius:11px;color:var(--text);font-family:'Tajawal',sans-serif;font-size:.87rem;outline:none;margin-bottom:.9rem;transition:border-color .2s}
        .mood-inp:focus{border-color:var(--p)}.mood-inp::placeholder{color:rgba(245,237,228,.22)}
        .mood-save{width:100%;padding:.78rem;background:linear-gradient(135deg,var(--pl),var(--p));border:none;border-radius:12px;color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.93rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 3px 14px var(--glow2)}
        .mood-save:hover:not(:disabled){transform:translateY(-1px);box-shadow:0 6px 22px var(--glow3)}.mood-save:disabled{opacity:.6;cursor:not-allowed}
        .link-textarea{width:100%;min-height:120px;background:rgba(0,0,0,.3);border:1px solid rgba(198,146,74,.2);border-radius:12px;padding:.9rem 1rem;color:#F5EDE4;font-family:'Tajawal',sans-serif;font-size:.92rem;resize:none;outline:none;margin-bottom:.9rem;transition:border-color .2s;line-height:1.7;direction:rtl}
        .link-textarea:focus{border-color:rgba(198,146,74,.6);box-shadow:0 0 0 3px rgba(198,146,74,.1)}.link-textarea::placeholder{color:rgba(245,237,228,.22)}
        .link-select{width:100%;padding:.6rem .9rem;background:rgba(0,0,0,.3);border:1px solid rgba(198,146,74,.2);border-radius:10px;color:#F5EDE4;font-family:'Tajawal',sans-serif;font-size:.87rem;outline:none}
        .link-row{display:flex;align-items:center;gap:.6rem;background:rgba(0,0,0,.3);border:1px solid rgba(198,146,74,.3);border-radius:12px;padding:.75rem 1rem;margin-bottom:1.2rem}
        .link-row span{flex:1;font-size:.82rem;color:rgba(245,237,228,.7);direction:ltr;text-align:left;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .copy-btn{background:rgba(198,146,74,.15);border:1px solid rgba(198,146,74,.3);border-radius:7px;padding:.32rem .8rem;font-size:.78rem;color:#E8B96A;cursor:pointer;transition:all .2s;font-family:'Tajawal',sans-serif;white-space:nowrap}
        .btn-create{width:100%;padding:.85rem;border-radius:12px;border:none;background:linear-gradient(135deg,#E8B96A,#C6924A);color:#120b04;font-family:'Tajawal',sans-serif;font-size:.97rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 4px 18px rgba(198,146,74,.35)}
        .btn-create:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 28px rgba(198,146,74,.5)}.btn-create:disabled{opacity:.6;cursor:not-allowed}
        .share-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:.6rem;margin-bottom:1.2rem}
        .share-btn{padding:.65rem .5rem;border-radius:11px;border:none;font-family:'Tajawal',sans-serif;font-size:.82rem;font-weight:600;cursor:pointer;transition:all .2s;white-space:nowrap}
        @media(max-width:380px){.share-grid{grid-template-columns:1fr 1fr}.share-btn{font-size:.78rem;padding:.6rem .4rem}}
        .flash{border-radius:12px;padding:.68rem 1rem;font-size:.84rem;animation:fadeUp .4s ease}
        .flash-s{background:rgba(74,222,128,.07);border:1px solid rgba(74,222,128,.18);color:#4ade80}
        @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        @keyframes scaleIn{from{opacity:0;transform:scale(.94)}to{opacity:1;transform:scale(1)}}
        @media(max-width:860px){.two-col{grid-template-columns:1fr}.stats-grid{grid-template-columns:repeat(2,1fr)}.quick-actions{grid-template-columns:repeat(3,1fr)}}
        @media(max-width:500px){.quick-actions{grid-template-columns:1fr}.hero-inner{flex-direction:column;align-items:flex-start}}
    </style>
</head>
<body>
<div id="toast-wrap"></div>

<nav class="nav">
    <a href="{{ route('home') }}" class="nav-logo">عتاب</a>
    <div class="nav-right">
        <a href="{{ route('profile.show', auth()->user()->username) }}"><button class="btn-ghost">صفحتي</button></a>
        @include('partials.notif-bell')
        <div class="nav-user" onclick="openMoodModal()">
            <div class="nav-av">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
            <span class="nav-name" id="nav-name">@if($todayMood){{ $todayMood->mood->emoji }} @endif{{ auth()->user()->name }}</span>
        </div>
        <a href="{{ route('notifications.index') }}" style="display:inline-flex;align-items:center;gap:.3rem;font-size:.79rem;color:var(--muted);padding:.38rem .9rem;border:1px solid var(--b);border-radius:999px;transition:all .2s;" onmouseover="this.style.borderColor='rgba(198,146,74,.4)';this.style.color='#E8B96A'" onmouseout="this.style.borderColor='rgba(198,146,74,.15)';this.style.color='rgba(245,237,228,.5)'">الإشعارات</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button type="submit" class="btn-ghost">خروج</button></form>
    </div>
</nav>

<div class="page">

    @if(session('success'))<div class="flash flash-s">✓ {{ session('success') }}</div>@endif

    @if($smartAlert)
    <div class="smart-alert">
        <p>{{ $smartAlert }}</p>
        <button class="btn-smart" onclick="openCreateLinkModal()">فضفض الآن 💬</button>
    </div>
    @endif

    @if($journey['pending_received'] > 0 || $journey['active'] > 0 || $journey['reconciled'] > 0)
    <div class="journey-bar">
        @if($journey['pending_received'] > 0)
            <a class="journey-pill pending" href="#section-card" onclick="switchTab('received');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false">⏳ {{ $journey['pending_received'] }} عتاب ينتظر ردك</a>
        @endif
        @if($journey['pending_sent'] > 0)
            <a class="journey-pill pending" href="#section-card" onclick="switchTab('sent');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false">📤 {{ $journey['pending_sent'] }} عتاب لم يُفتح</a>
        @endif
        @if($journey['active'] > 0)
            <a class="journey-pill active" href="#section-card" onclick="switchTab('received');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false">💬 {{ $journey['active'] }} محادثة نشطة</a>
        @endif
        @if($journey['reconciled'] > 0)
            <a class="journey-pill rec" href="{{ route('reconciliations.index') }}">🤝 {{ $journey['reconciled'] }} مصالحة</a>
        @endif
    </div>
    @endif

    <div class="hero">
        <div class="hero-glow"></div><span class="hero-orn">ع</span>
        <div class="hero-inner">
            <div class="hero-left">
                <h2>أهلاً، {{ auth()->user()->name }} 🤍</h2>
                <p id="hero-mood-text">
                    @if($todayMood)حالتك اليوم: {{ $todayMood->mood->emoji }} {{ $todayMood->mood->name_ar }}@if($todayMood->custom_message) · {{ $todayMood->custom_message }}@endif
                    @else ما حددتش حالتك اليوم بعد @endif
                </p>
                <div class="mood-tag" onclick="openMoodModal()" id="mood-tag-btn">
                    @if($todayMood){{ $todayMood->mood->emoji }} غيّر حالتك اليوم@else 🌡️ حدد حالتك الآن@endif
                </div>
            </div>
            <div class="hero-actions">
                <button class="btn-primary" id="main-cta" onclick="handleCTA()">{{ $moodEngine['cta'] }}</button>
                <button class="btn-secondary" onclick="switchTab('received')">📩 الوارد</button>
            </div>
        </div>
    </div>

    <div class="mood-banner">
        <p id="mood-banner-text">{{ $moodEngine['suggestion'] }}</p>
        <button class="btn-sug" id="mood-banner-btn">{{ $moodEngine['cta_action'] === 'send' ? 'ابدأ الآن ✉️' : 'الوارد 📩' }}</button>
    </div>

    <div class="quick-actions">
        <a class="qa-card" href="#" onclick="openCreateLinkModal();return false"><span class="qa-icon">✉️</span><span class="qa-label">إرسال عتاب</span><span class="qa-sub">ابدأ محادثة جديدة</span></a>
        <a class="qa-card" href="#section-card" onclick="switchTab('received');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false"><span class="qa-icon">📩</span><span class="qa-label">الوارد</span><span class="qa-sub">{{ $receivedAtabs->count() }} عتاب</span></a>
        <a class="qa-card" href="#section-card" onclick="switchTab('sent');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false"><span class="qa-icon">📤</span><span class="qa-label">الصادر</span><span class="qa-sub">{{ $sentAtabs->count() }} عتاب</span></a>
    </div>

    <div class="stats-grid">
        <a class="stat stat-recv" href="#section-card" onclick="switchTab('received');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false">
            <span class="stat-icon">📩</span>
            <span class="stat-val">{{ $receivedAtabs->count() }}</span>
            <span class="stat-lbl">عتاب وارد</span>
        </a>
        <a class="stat stat-sent" href="#section-card" onclick="switchTab('sent');document.getElementById('section-card').scrollIntoView({behavior:'smooth'});return false">
            <span class="stat-icon">📤</span>
            <span class="stat-val">{{ $sentAtabs->count() }}</span>
            <span class="stat-lbl">عتاب صادر</span>
        </a>
        <a href="{{ route('reconciliations.index') }}" class="stat stat-rec">
            <span class="stat-icon">🤝</span>
            <span class="stat-val">{{ $receivedAtabs->where('status','reconciled')->count() + $sentAtabs->where('status','reconciled')->count() }}</span>
            <span class="stat-lbl">مصالحة</span>
        </a>
        <a href="{{ route('reconciliations.index') }}" class="stat stat-pend">
            <span class="stat-icon">🤝</span>
            <span class="stat-val">{{ $pendingReconciliations->count() }}</span>
            <span class="stat-lbl">طلبات صلح في الانتظار</span>
        </a>
    </div>

    <div class="two-col">
        <div class="section-card" id="section-card">
            <div class="section-head">
                <h3 class="section-title">العتابات</h3>
                <div class="tabs-mini">
                    <button class="tab-m active" id="tab-recv-btn" onclick="switchTab('received')">الوارد ({{ $receivedAtabs->count() }})</button>
                    <button class="tab-m" id="tab-sent-btn" onclick="switchTab('sent')">الصادر ({{ $sentAtabs->count() }})</button>
                </div>
            </div>
            <div id="tab-received">
                @forelse($receivedAtabs->take(8) as $atab)
                <a href="{{ route('atab.show', $atab) }}" class="atab-item {{ $atab->status==='pending'?'unread':'' }}">
                    <div class="ai-av {{ $atab->is_anonymous?'anon':'' }}">{{ $atab->is_anonymous?'🎭':mb_substr($atab->sender?->name??'؟',0,1) }}</div>
                    <div class="ai-body">
                        <div class="ai-top">
                            <span class="ai-name">{{ $atab->is_anonymous?'❓ مجهول الهوية':($atab->sender?->name??'مجهول') }}</span>
                            <span class="ai-time">{{ $atab->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="ai-msg">{{ $atab->messages->first()?->body??'...' }}</p>
                        <div class="ai-tags">
                            @if($atab->status==='pending')<span class="badge b-pending">📩 جديد</span>@elseif($atab->status==='active')<span class="badge b-active">💬 نشط</span>@elseif($atab->status==='reconciled')<span class="badge b-reconciled">🤝 مصالحة</span>@endif
                            @if($atab->is_anonymous)<span class="badge b-anon">🎭 مجهول</span>@endif
                            @if($atab->sender_id === null && !$atab->is_anonymous)<span class="badge b-guest">👤 زائر</span>@endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-box">
                    <div class="empty-icon">📭</div>
                    <h3 class="empty-title" id="empty-received-title">{{ $moodEngine['empty'] }}</h3>
                    <p class="empty-sub">شارك رابط صفحتك مع اللي تهتم بهم</p>
                    <button class="btn-start" onclick="openCreateLinkModal()">ابدأ الآن</button>
                </div>
                @endforelse
            </div>
            <div id="tab-sent" style="display:none;">
                @forelse($sentAtabs->take(8) as $atab)
                <a href="{{ route('atab.show', $atab) }}" class="atab-item">
                    <div class="ai-av {{ !$atab->receiver?'anon':'' }}">{{ $atab->receiver?mb_substr($atab->receiver->name,0,1):'🔗' }}</div>
                    <div class="ai-body">
                        <div class="ai-top">
                            <span class="ai-name">{{ $atab->receiver?->name??'في انتظار المستلم...' }}</span>
                            <span class="ai-time">{{ $atab->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="ai-msg">{{ $atab->messages->first()?->body??'...' }}</p>
                        <div class="ai-tags">
                            @if($atab->status==='reconciled')
                                <span class="badge b-reconciled">🤝 مصالحة</span>
                            @elseif($atab->status==='active')
                                <span class="badge b-active">💬 نشط</span>
                            @endif
                            {{-- Seen status --}}
                            @if($atab->seen_at)
                                <span class="badge b-seen" title="{{ $atab->seen_at->format('Y-m-d H:i') }}">👁️ تم قراءة عتابك</span>
                            @else
                                <span class="badge b-unseen">⏳ لم يتم الفتح</span>
                            @endif
                            @if($atab->token && !$atab->receiver)<span class="badge b-link">🔗 رابط</span>@endif
                            @if($atab->is_anonymous)<span class="badge b-anon">🎭 مجهول</span>@endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-box"><div class="empty-icon">✉️</div><h3 class="empty-title">ما أرسلت عتاب بعد</h3><p class="empty-sub">جرب تبدأ عتاب جديد</p><button class="btn-start" onclick="openCreateLinkModal()">ابدأ الآن</button></div>
                @endforelse
            </div>
        </div>

        <div class="right-col">

            {{-- ── SHARE CARD ── --}}
            <div class="share-card" id="share-card">
                <div class="share-card-glow"></div>
                <div class="share-head">
                    <p class="share-head-title">📢 مشاركة صفحتي</p>
                    <p class="share-head-sub">📈 كل ما تشارك، هيجيلك عتاب أكتر</p>
                </div>
                <div class="share-body">
                    <div class="share-link-row">
                        <span class="share-link-text" id="share-link-display">3tab.app/{{ auth()->user()->username }}</span>
                        <span class="share-link-badge">رابطك</span>
                    </div>
                    <div class="share-btns">
                        <button class="btn-copy" id="btn-copy-link" onclick="copyProfileLink(this)">
                            📋 نسخ الرابط
                        </button>
                        <button class="btn-share-open" onclick="openShareModal()">
                            📤 مشاركة
                        </button>
                    </div>
                    <p class="share-hint">قول لـ الناس اللي جواهم 👀</p>
                </div>
            </div>

            {{-- ── RECONCILIATION REQUESTS CARD ── --}}
            @if($pendingReconciliations->count() > 0)
            <div class="rec-card">
                <a href="{{ route('reconciliations.index') }}" class="rec-card-head" style="text-decoration:none;">
                    <span class="rec-card-title">🤝 طلبات مصالحة في الانتظار</span>
                    <span class="rec-card-badge">{{ $pendingReconciliations->count() }} جديد</span>
                </a>
                @foreach($pendingReconciliations as $recAtab)
                <div class="rec-item">
                    <div class="rec-item-av">
                        {{ mb_substr($recAtab->reconciliationRequester?->name ?? '؟', 0, 1) }}
                    </div>
                    <div class="rec-item-body">
                        <p class="rec-item-name">{{ $recAtab->reconciliationRequester?->name ?? 'أحدهم' }} يريد الصلح</p>
                        <p class="rec-item-sub">{{ $recAtab->reconciliation_requested_at?->diffForHumans() }}</p>
                    </div>
                    <div class="rec-item-actions">
                        <a href="{{ route('atab.show', $recAtab) }}" class="btn-accept-sm" style="text-decoration:none;display:inline-block;padding:.3rem .8rem;border-radius:8px;background:linear-gradient(135deg,var(--sage),#5a8a7a);color:var(--dark2);font-family:'Tajawal',sans-serif;font-size:.75rem;font-weight:700;">
                            حليب يا قشطة 🤍
                        </a>
                    </div>
                </div>
                @endforeach
                <div style="padding:.6rem 1.3rem;border-top:1px solid rgba(122,158,142,.1);">
                    <a href="{{ route('reconciliations.index') }}" style="font-size:.78rem;color:var(--sage);display:block;text-align:center;padding:.35rem;border-radius:8px;transition:background .2s;" onmouseover="this.style.background='rgba(122,158,142,.07)'" onmouseout="this.style.background='transparent'">
                        عرض الكل ←
                    </a>
                </div>
            </div>
            @endif

            <div class="activity-card">
                <div class="section-head" style="border-bottom:1px solid var(--b);"><h3 class="section-title">آخر النشاطات</h3></div>
                @php $allAtabs = $receivedAtabs->concat($sentAtabs)->sortByDesc('created_at')->take(5); @endphp
                @forelse($allAtabs as $atab)
                @php
                    $isReceived = $receivedAtabs->contains($atab);
                    // رابط الانتقال: لو العتاب مطالب به → المحادثة، لو pending ورابطه موجود → صفحة الرابط
                    if ($atab->isClaimed()) {
                        $actUrl = route('atab.show', $atab);
                    } elseif ($atab->token) {
                        $actUrl = route('atab.link', $atab->token);
                    } else {
                        $actUrl = route('atab.show', $atab);
                    }
                @endphp
                <a href="{{ $actUrl }}" class="act-item">
                    <div class="act-dot {{ $isReceived ? 'recv' : 'sent' }}">{{ $isReceived ? '📩' : '📤' }}</div>
                    <div class="act-body">
                        <p>
                            @if($isReceived)
                                وصلك عتاب من <strong>{{ $atab->is_anonymous ? '❓ مجهول' : ($atab->sender?->name ?? 'مجهول') }}</strong>
                                @if($atab->status==='reconciled') &middot; 🤝 مصالحة @endif
                                @if(!$atab->seen_at) &middot; <span style="color:#E8B96A;font-size:.72rem;">جديد</span> @endif
                            @else
                                أرسلت عتاب لـ <strong>{{ $atab->receiver?->name ?? 'في انتظار المستلم...' }}</strong>
                                @if($atab->seen_at) &middot; 👁️ تم القراءة @elseif($atab->status==='pending') &middot; <span style="color:rgba(245,237,228,.4);font-size:.72rem;">⏳ لم يُفتح</span> @endif
                                @if($atab->status==='reconciled') &middot; 🤝 مصالحة @endif
                            @endif
                        </p>
                        <span>{{ $atab->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="act-arrow">‹</span>
                </a>
                @empty
                <div class="empty-box" style="padding:2rem 1rem;"><div class="empty-icon">🕐</div><p class="empty-sub">ما في نشاطات بعد</p></div>
                @endforelse
            </div>

            <div class="mood-week">
                <div class="section-head" style="border-bottom:1px solid var(--b);"><h3 class="section-title">مزاجك هذا الأسبوع</h3></div>
                <div class="mood-week-grid" id="mood-week-grid"><span style="font-size:.78rem;color:var(--muted);padding:.5rem;">جاري التحميل...</span></div>
            </div>

            {{-- ── SAFETY MODE CARD ── --}}
            <div class="suggest-card" style="border:1px solid var(--b)">
                <div class="section-head" style="border-bottom:1px solid var(--b);padding:.9rem 1.2rem;display:flex;align-items:center;justify-content:space-between;">
                    <h3 class="section-title" style="font-size:.84rem;">🔒 من يرسل لك عتاب؟</h3>
                </div>
                <div style="padding:.9rem 1.2rem;">
                    <div style="display:flex;gap:.5rem;margin-bottom:.55rem;" id="safety-toggle">
                        <button
                            class="safety-btn {{ auth()->user()->send_permission !== 'registered' ? 'safety-active' : '' }}"
                            id="safety-everyone"
                            onclick="setSafety('everyone')"
                            type="button">🌍 الجميع</button>
                        <button
                            class="safety-btn {{ auth()->user()->send_permission === 'registered' ? 'safety-active' : '' }}"
                            id="safety-registered"
                            onclick="setSafety('registered')"
                            type="button">🔐 المسجّلون فقط</button>
                    </div>
                    <p style="font-size:.72rem;color:var(--muted);line-height:1.6;" id="safety-hint">
                        @if(auth()->user()->send_permission === 'registered')
                            لن يتمكن الزوار من إرسال عتاب إليك
                        @else
                            أي شخص يمكنه إرسال عتاب — حتى بدون حساب
                        @endif
                    </p>
                </div>
            </div>

            <div class="suggest-card">
                <div class="section-head" style="border-bottom:1px solid var(--b);"><h3 class="section-title">💡 اقتراحات لك</h3></div>
                <div class="suggest-item">
                    <p class="suggest-text" id="dynamic-suggestion">{{ $moodEngine['suggestion'] }}</p>
                    <button class="btn-sm" id="dynamic-suggestion-btn">{{ $moodEngine['cta_action']==='send'?'ابعت عتاب ✉️':'الوارد 📩' }}</button>
                </div>
                @if($journey['pending_received'] > 0)
                <div class="suggest-item"><p class="suggest-text">👀 عندك <strong>{{ $journey['pending_received'] }}</strong> عتاب لسه ما فتحتهوش</p><button class="btn-sm" onclick="switchTab('received');document.querySelector('.section-card').scrollIntoView({behavior:'smooth'})">افتح الآن</button></div>
                @endif
                @if($journey['pending_sent'] > 0)
                <div class="suggest-item"><p class="suggest-text">⏳ في <strong>{{ $journey['pending_sent'] }}</strong> عتاب أرسلته ولسه ما اتردش</p><button class="btn-sm" onclick="switchTab('sent');document.querySelector('.section-card').scrollIntoView({behavior:'smooth'})">شوف الصادر</button></div>
                @endif
                @if(!$todayMood)
                <div class="suggest-item"><p class="suggest-text">🌡️ ما حددتش حالتك اليوم</p><button class="btn-sm" onclick="openMoodModal()">حدد الآن</button></div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── SHARE MODAL ── --}}
<div class="modal-overlay" id="share-modal" onclick="if(event.target===this)closeShareModal()">
    <div class="share-modal">
        <h2 class="share-modal-title">📤 شارك صفحتك</h2>
        <p class="share-modal-sub">اختار المنصة وابعت رسالتك لكل الناس اللي عندهم كلام</p>

        <div class="share-msg-preview" id="share-msg-preview">
            قول اللي جواك ليا بصراحة 👀 لو زعلان مني أو عندك حاجة عايز تقولها، ابعتها هنا 👇<br>
            <span style="color:var(--pl);font-weight:600;direction:ltr;display:inline-block;margin-top:.3rem">3tab.app/{{ auth()->user()->username }}</span>
        </div>

        <div class="share-platforms">
            <a class="share-platform-btn sp-wa" id="share-wa" href="#" target="_blank" rel="noopener" onclick="trackShare('whatsapp')">
                <span class="share-platform-icon">💬</span>
                <span>واتساب</span>
            </a>
            <a class="share-platform-btn sp-fb" id="share-fb" href="#" target="_blank" rel="noopener" onclick="trackShare('facebook')">
                <span class="share-platform-icon">📘</span>
                <span>فيسبوك</span>
            </a>
            <a class="share-platform-btn sp-tw" id="share-tw" href="#" target="_blank" rel="noopener" onclick="trackShare('twitter')">
                <span class="share-platform-icon">𝕏</span>
                <span>تويتر (X)</span>
            </a>
            <button class="share-platform-btn sp-copy" onclick="copyFromModal()">
                <span class="share-platform-icon">📋</span>
                <span id="modal-copy-label">نسخ الرابط + الرسالة</span>
            </button>
        </div>

        <button class="share-modal-close" onclick="closeShareModal()">إغلاق</button>
    </div>
</div>

{{-- MOOD MODAL --}}
<div class="modal-overlay" id="mood-modal" onclick="if(event.target===this)closeMoodModal()">
    <div class="modal">
        <button class="modal-close" onclick="closeMoodModal()">✕</button>
        <h2 class="modal-title">كيف حالك اليوم؟</h2>
        <p class="modal-sub">اختر حالتك وسيراها زوار صفحتك</p>
        <div class="mood-grid-m">
            @foreach($moods as $mood)
            <button type="button" class="mood-pill {{ $todayMood && $todayMood->mood_id===$mood->id?'selected':'' }}"
                onclick="selectMood({{ $mood->id }},this)"
                data-id="{{ $mood->id }}" data-type="{{ $mood->name_en }}"
                data-name="{{ $mood->name_ar }}" data-emoji="{{ $mood->emoji }}">
                {{ $mood->emoji }} {{ $mood->name_ar }}
            </button>
            @endforeach
        </div>
        <input type="text" id="mood-note" class="mood-inp" placeholder="أضف رسالة... (مثال: يوم صعب، تمهّل)" value="{{ $todayMood?->custom_message }}" maxlength="500" />
        <button id="mood-save-btn" class="mood-save" onclick="saveMood()">حفظ الحالة ✓</button>
    </div>
</div>

{{-- CREATE LINK MODAL --}}
<div class="modal-overlay" id="create-link-modal" onclick="if(event.target===this)closeCreateLinkModal()">
    <div class="modal" style="max-width:480px;">
        <button class="modal-close" onclick="closeCreateLinkModal()">✕</button>
        <div id="step-write">
            <h2 class="modal-title" id="create-modal-title">{{ $moodEngine['cta'] }}</h2>
            <p class="modal-sub">اكتب عتابك وشارك الرابط مع من تريد</p>
            <textarea id="link-body" class="link-textarea" placeholder="اكتب عتابك هنا... كلام الصدق أحسن من الصمت" maxlength="500" oninput="document.getElementById('link-cc').textContent=this.value.length"></textarea>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:.7rem;">
                <label style="display:flex;align-items:center;gap:.5rem;font-size:.83rem;color:rgba(245,237,228,.55);cursor:pointer;"><input type="checkbox" id="link-anon" style="accent-color:#C6924A;width:15px;height:15px;" /> أرسل مجهول الهوية</label>
                <span style="font-size:.75rem;color:rgba(245,237,228,.4);"><span id="link-cc">0</span>/500</span>
            </div>
            {{-- One-Time toggle --}}
            <div id="ot-toggle-wrap" style="display:flex;align-items:flex-start;gap:.7rem;background:rgba(194,113,90,.07);border:1px solid rgba(194,113,90,.2);border-radius:12px;padding:.75rem 1rem;margin-bottom:1rem;cursor:pointer;" onclick="document.getElementById('link-one-time').click()">
                <input type="checkbox" id="link-one-time" style="accent-color:#C2715A;width:16px;height:16px;margin-top:2px;flex-shrink:0;cursor:pointer;" onclick="event.stopPropagation()"/>
                <div>
                    <div style="font-size:.83rem;color:rgba(245,237,228,.7);font-weight:600;">🔒 رسالة تُعرض مرة واحدة فقط</div>
                    <div style="font-size:.74rem;color:rgba(245,237,228,.38);margin-top:.2rem;">المستقبل لن يتمكن من رؤيتها مجدداً إلا بالتسجيل — يزيد فرصة التحويل</div>
                </div>
            </div>
            <div style="margin-bottom:1.2rem;">
                <label style="display:block;font-size:.8rem;color:rgba(245,237,228,.45);margin-bottom:.4rem;">صلاحية الرابط (اختياري)</label>
                <select id="link-expires" class="link-select"><option value="">بدون تحديد (دائم)</option><option value="1">يوم واحد</option><option value="3">3 أيام</option><option value="7">أسبوع</option><option value="30">شهر</option></select>
            </div>
            <button id="create-btn" class="btn-create" onclick="createAtabLink()">إنشاء الرابط ✨</button>
        </div>
        <div id="step-link" style="display:none;">
            <div style="text-align:center;margin-bottom:1.5rem;"><div style="font-size:2.5rem;margin-bottom:.8rem;">🎉</div><h2 class="modal-title">الرابط جاهز!</h2><p class="modal-sub">شاركه — بعد التسجيل العتاب يتضاف تلقائياً</p></div>
            <div id="ot-notice" style="display:none;background:rgba(194,113,90,.1);border:1px solid rgba(194,113,90,.3);border-radius:11px;padding:.65rem 1rem;font-size:.78rem;color:rgba(245,237,228,.65);margin-bottom:.9rem;">🔒 هذه الرسالة صالحة للعرض مرة واحدة فقط — الضغط على الرابط من متصفح جديد سيُظهر صفحة انتهاء الصلاحية</div>
            <div class="link-row"><span id="generated-link"></span><button id="copy-link-btn" class="copy-btn" onclick="copyGeneratedLink()">نسخ</button></div>
            <div class="share-grid">
                <button class="share-btn" onclick="shareWhatsApp()" style="background:rgba(37,211,102,.12);color:#25d366;border:1px solid rgba(37,211,102,.2);">📱 واتساب</button>
                <button class="share-btn" onclick="shareTwitter()" style="background:rgba(29,161,242,.12);color:#1da1f2;border:1px solid rgba(29,161,242,.2);">𝕏 تويتر</button>
                <button class="share-btn" onclick="shareFacebook()" style="background:rgba(24,119,242,.12);color:#1877f2;border:1px solid rgba(24,119,242,.2);">👥 فيسبوك</button>
                <button class="share-btn" onclick="copyGeneratedLink()" style="background:rgba(198,146,74,.1);color:#E8B96A;border:1px solid rgba(198,146,74,.2);">📋 نسخ</button>
            </div>
            <div style="background:rgba(198,146,74,.06);border:1px solid rgba(198,146,74,.15);border-radius:11px;padding:.75rem 1rem;font-size:.78rem;color:rgba(245,237,228,.45);text-align:center;margin-bottom:.9rem;">📊 ستجد إحصائيات المشاهدات في لوحة التحكم</div>
            <button onclick="resetCreateModal()" style="width:100%;padding:.7rem;border-radius:11px;background:transparent;border:1px solid rgba(198,146,74,.2);color:rgba(245,237,228,.5);font-family:'Tajawal',sans-serif;font-size:.85rem;cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor='rgba(198,146,74,.4)';this.style.color='rgba(245,237,228,.8)'" onmouseout="this.style.borderColor='rgba(198,146,74,.2)';this.style.color='rgba(245,237,228,.5)'">➕ إنشاء عتاب آخر</button>
        </div>
    </div>
</div>

<script>
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
const MOOD_DATA = {!! \App\Services\MoodEngine::allAsJson() !!};
let selectedMoodId  = {{ $todayMood?->mood_id ?? 'null' }};
let currentMoodType = '{{ $todayMood?->mood?->name_en ?? '' }}';
let generatedLink   = '';

// ── Share Profile ─────────────────────────────────────────────────────────────
const PROFILE_URL  = '{{ url("/".auth()->user()->username) }}';
const SHARE_TEXT   = 'قول اللي جواك ليا بصراحة 👀 لو زعلان مني أو عندك حاجة عايز تقولها، ابعتها هنا 👇 ' + PROFILE_URL;

function openShareModal() {
    // Build dynamic platform links
    const enc     = encodeURIComponent(SHARE_TEXT);
    const encUrl  = encodeURIComponent(PROFILE_URL);

    document.getElementById('share-wa').href = 'https://wa.me/?text=' + enc;
    document.getElementById('share-fb').href = 'https://www.facebook.com/sharer/sharer.php?u=' + encUrl + '&quote=' + enc;
    document.getElementById('share-tw').href = 'https://twitter.com/intent/tweet?text=' + enc;

    document.getElementById('share-modal').classList.add('open');
}

function closeShareModal() {
    document.getElementById('share-modal').classList.remove('open');
}

function copyProfileLink(btn) {
    copyText(PROFILE_URL);
    if (!btn) return;
    const orig = btn.innerHTML;
    btn.innerHTML = '✅ تم النسخ';
    btn.classList.add('copied');
    setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2200);
    showToast('✔ تم نسخ الرابط', 's');
}

function copyFromModal() {
    copyText(SHARE_TEXT);
    const lbl = document.getElementById('modal-copy-label');
    if (lbl) { lbl.textContent = '✅ تم النسخ!'; setTimeout(() => lbl.textContent = 'نسخ الرابط + الرسالة', 2200); }
    showToast('✔ تم نسخ الرسالة والرابط', 's');
}

function trackShare(platform) {
    // lightweight — just close modal after small delay
    setTimeout(closeShareModal, 600);
}

function copyText(txt) {
    if (navigator.clipboard) { navigator.clipboard.writeText(txt).catch(()=>{}); }
    else {
        const el = document.createElement('textarea');
        el.value = txt; el.style.cssText = 'position:fixed;opacity:0;pointer-events:none';
        document.body.appendChild(el); el.select(); document.execCommand('copy');
        document.body.removeChild(el);
    }
}

// ── Safety Mode ──────────────────────────────────────────────────────────────
const CSRF_TOKEN = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

async function setSafety(perm) {
    try {
        const r = await fetch('{{ route("settings.safety") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN(), 'Accept': 'application/json' },
            body: JSON.stringify({ send_permission: perm })
        });
        const d = await r.json();
        if (d.success) {
            document.getElementById('safety-everyone').classList.toggle('safety-active',  perm === 'everyone');
            document.getElementById('safety-registered').classList.toggle('safety-active', perm === 'registered');
            document.getElementById('safety-hint').textContent = perm === 'registered'
                ? 'لن يتمكن الزوار من إرسال عتاب إليك'
                : 'أي شخص يمكنه إرسال عتاب — حتى بدون حساب';
            showToast(d.message, 'i');
        }
    } catch(_) { showToast('حصل خطأ', 'e'); }
}

function showToast(msg,type='s',dur=3500){const w=document.getElementById('toast-wrap');const el=document.createElement('div');el.className=`toast toast-${type}`;el.textContent=msg;w.appendChild(el);setTimeout(()=>{el.style.animation='toastOut .3s ease forwards';setTimeout(()=>el.remove(),300)},dur)}

function switchTab(tab){document.getElementById('tab-received').style.display=tab==='received'?'block':'none';document.getElementById('tab-sent').style.display=tab==='sent'?'block':'none';document.getElementById('tab-recv-btn').classList.toggle('active',tab==='received');document.getElementById('tab-sent-btn').classList.toggle('active',tab==='sent')}

function handleCTA(){const e=MOOD_DATA[currentMoodType]||MOOD_DATA.default;if(e.cta_action==='inbox'){switchTab('received');document.querySelector('.section-card')?.scrollIntoView({behavior:'smooth'})}else{openCreateLinkModal()}}

function applyMoodEngine(type){
    const e=MOOD_DATA[type]||MOOD_DATA.default;
    currentMoodType=type;
    const cta=document.getElementById('main-cta');if(cta)cta.textContent=e.cta;
    const mt=document.getElementById('create-modal-title');if(mt)mt.textContent=e.cta;
    const bt=document.getElementById('mood-banner-text');if(bt)bt.textContent=e.suggestion;
    const bb=document.getElementById('mood-banner-btn');
    if(bb){bb.textContent=e.cta_action==='send'?'ابدأ الآن ✉️':'الوارد 📩';bb.onclick=e.cta_action==='send'?openCreateLinkModal:()=>{switchTab('received');document.querySelector('.section-card')?.scrollIntoView({behavior:'smooth'})}}
    const ds=document.getElementById('dynamic-suggestion');if(ds)ds.textContent=e.suggestion;
    const db=document.getElementById('dynamic-suggestion-btn');
    if(db){db.textContent=e.cta_action==='send'?'ابعت عتاب ✉️':'الوارد 📩';db.onclick=e.cta_action==='send'?openCreateLinkModal:()=>switchTab('received')}
    const et=document.getElementById('empty-received-title');if(et)et.textContent=e.empty;
}

function openMoodModal(){document.getElementById('mood-modal').classList.add('open')}
function closeMoodModal(){document.getElementById('mood-modal').classList.remove('open')}
function selectMood(id,el){document.querySelectorAll('.mood-pill').forEach(p=>p.classList.remove('selected'));el.classList.add('selected');selectedMoodId=id}

async function saveMood(){
    if(!selectedMoodId){showToast('اختر حالتك أولاً','e');return}
    const note=document.getElementById('mood-note').value;
    const btn=document.getElementById('mood-save-btn');
    btn.disabled=true;btn.textContent='جاري الحفظ...';
    try{
        const res=await fetch('{{ route("mood.store") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},body:JSON.stringify({mood_id:selectedMoodId,custom_message:note})});
        const data=await res.json();
        if(data.success){
            closeMoodModal();showToast(data.message,'s');
            document.getElementById('hero-mood-text').textContent=`حالتك اليوم: ${data.mood.emoji} ${data.mood.name}${note?' · '+note:''}`;
            document.getElementById('mood-tag-btn').textContent=`${data.mood.emoji} غيّر حالتك اليوم`;
            document.getElementById('nav-name').textContent=`${data.mood.emoji} {{ auth()->user()->name }}`;
            applyMoodEngine(data.mood.type);
            setTimeout(()=>showToast(data.engine.toast,'i'),500);
            if(data.smart_suggestion)setTimeout(()=>showToast(data.smart_suggestion,'i',6000),1200);
            loadMoodHistory();
        }else{showToast('حدث خطأ، حاول مرة أخرى','e')}
    }catch(e){showToast('حدث خطأ في الاتصال','e')}
    finally{btn.disabled=false;btn.textContent='حفظ الحالة ✓'}
}

async function loadMoodHistory(){
    try{
        const res=await fetch('{{ route("mood.history") }}',{headers:{'Accept':'application/json','X-CSRF-TOKEN':CSRF}});
        const data=await res.json();
        const grid=document.getElementById('mood-week-grid');
        if(!data.history?.length){grid.innerHTML='<span style="font-size:.78rem;color:var(--muted);padding:.5rem;">ما في سجل هذا الأسبوع</span>';return}
        const today=new Date().toISOString().split('T')[0];
        grid.innerHTML=data.history.map(d=>`<div class="mood-day ${d.date===today?'today':''}" title="${d.name}"><span class="mood-day-emoji">${d.emoji}</span><span class="mood-day-label">${new Date(d.date+'T12:00:00').toLocaleDateString('ar-EG',{weekday:'short'})}</span><span class="mood-day-dot"></span></div>`).join('');
        if(data.smart)showToast(data.smart,'i',6000);
    }catch(e){}
}

function openCreateLinkModal(){document.getElementById('create-link-modal').classList.add('open');setTimeout(()=>document.getElementById('link-body').focus(),100)}
function closeCreateLinkModal(){document.getElementById('create-link-modal').classList.remove('open')}
function resetCreateModal(){document.getElementById('step-write').style.display='block';document.getElementById('step-link').style.display='none';document.getElementById('link-body').value='';document.getElementById('link-anon').checked=false;document.getElementById('link-one-time').checked=false;document.getElementById('link-expires').value='';document.getElementById('link-cc').textContent='0';const btn=document.getElementById('create-btn');btn.disabled=false;btn.textContent='إنشاء الرابط ✨';generatedLink=''}

async function createAtabLink(){
    const body=document.getElementById('link-body').value.trim();
    const anon=document.getElementById('link-anon').checked;
    const oneTime=document.getElementById('link-one-time').checked;
    const expires=document.getElementById('link-expires').value;
    const btn=document.getElementById('create-btn');
    if(!body||body.length<3){showToast('اكتب رسالة لا تقل عن 3 أحرف','e');return}
    btn.disabled=true;btn.textContent='جاري الإنشاء...';
    try{
        const res=await fetch('{{ route("atab.link.store") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},body:JSON.stringify({body,is_anonymous:anon,is_one_time:oneTime,expires_days:expires?parseInt(expires):null})});
        const data=await res.json();
        if(data.success){generatedLink=data.link;document.getElementById('generated-link').textContent=data.link;document.getElementById('step-write').style.display='none';document.getElementById('step-link').style.display='block';document.getElementById('ot-notice').style.display=oneTime?'block':'none';showToast('خطوة كويسة 👏 التعبير بيريّح','s')}
        else{showToast('حدث خطأ، حاول مرة أخرى','e');btn.disabled=false;btn.textContent='إنشاء الرابط ✨'}
    }catch(e){showToast('حدث خطأ في الاتصال','e');btn.disabled=false;btn.textContent='إنشاء الرابط ✨'}
}

function copyGeneratedLink(){if(!generatedLink)return;navigator.clipboard.writeText(generatedLink).then(()=>{showToast('تم نسخ الرابط 📋','s');const btn=document.getElementById('copy-link-btn');btn.textContent='✓ تم';btn.style.color='#4ade80';setTimeout(()=>{btn.textContent='نسخ';btn.style.color=''},2000)})}
function shareWhatsApp(){if(generatedLink)window.open('https://wa.me/?text='+encodeURIComponent('عندك عتاب مني 💌\n'+generatedLink),'_blank')}
function shareTwitter(){if(generatedLink)window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent('عندك عتاب مني 💌 '+generatedLink),'_blank')}
function shareFacebook(){if(generatedLink)window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(generatedLink),'_blank')}

document.addEventListener('DOMContentLoaded',()=>{
    loadMoodHistory();
    if(currentMoodType)applyMoodEngine(currentMoodType);
    document.getElementById('mood-banner-btn').onclick=
        '{{ $moodEngine["cta_action"] }}'==='send'?openCreateLinkModal:()=>{switchTab('received');document.querySelector('.section-card')?.scrollIntoView({behavior:'smooth'})};
    document.getElementById('dynamic-suggestion-btn').onclick=
        '{{ $moodEngine["cta_action"] }}'==='send'?openCreateLinkModal:()=>switchTab('received');
    @if(session('success'))showToast('{{ session('success') }}','s');@endif

    // ربط عتابات الزائر بالحساب بعد أول تسجيل دخول/تسجيل
    (function(){
        const token = localStorage.getItem('atab_guest_token');
        if (!token) return;
        fetch('{{ route("atab.link.guest") }}', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF,'Accept':'application/json'},
            body: JSON.stringify({ guest_token: token }),
        }).then(r => {
            if (r.ok) {
                localStorage.removeItem('atab_guest_token');
                localStorage.removeItem('atab_after_register_user');
                showToast('تم ربط عتابك بحسابك 🤍','s');
            }
        }).catch(()=>{});
    })();
});
</script>
</body>
</html>