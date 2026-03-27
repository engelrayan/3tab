<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') · Admin · عتاب</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --p:#C6924A;--pl:#E8B96A;--pd:#A07035;
            --dark:#08050300;--dark1:#0c0702;--dark2:#100904;--card:#161008;--card2:#1e1309;
            --b:rgba(198,146,74,.1);--bm:rgba(198,146,74,.2);--bh:rgba(198,146,74,.35);
            --text:#F0E8DF;--muted:rgba(240,232,223,.42);--soft:rgba(240,232,223,.68);
            --glow:rgba(198,146,74,.14);--glow2:rgba(198,146,74,.28);
            --rose:#C2715A;--sage:#7A9E8E;--blue:#5A8FC2;
            --red:#ef4444;--red-bg:rgba(239,68,68,.08);--red-b:rgba(239,68,68,.2);
            --yellow:#fbbf24;--yellow-bg:rgba(251,191,36,.08);--yellow-b:rgba(251,191,36,.2);
            --green:#4ade80;--green-bg:rgba(74,222,128,.08);--green-b:rgba(74,222,128,.2);
            --sidebar-w:252px;
            --radius:14px;--radius-sm:10px;
        }
        html{height:100%}
        body{min-height:100vh;width:100%;background:var(--dark2);color:var(--text);font-family:'Tajawal',sans-serif;display:flex;flex-direction:row}
        a{text-decoration:none;color:inherit}
        ::-webkit-scrollbar{width:3px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(198,146,74,.18);border-radius:2px}
        input,textarea,select{font-family:'Tajawal',sans-serif}

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar{
            width:var(--sidebar-w);min-height:100vh;
            background:#0b0703;
            border-left:1px solid var(--b);
            display:flex;flex-direction:column;
            position:fixed;top:0;right:0;z-index:200;
            overflow-y:auto;overflow-x:hidden;
        }

        /* Brand */
        .sb-brand{padding:1.2rem 1.1rem .9rem;border-bottom:1px solid var(--b);display:flex;align-items:center;gap:.75rem}
        .sb-logo{font-family:'Amiri',serif;font-size:1.9rem;background:linear-gradient(135deg,var(--pl),var(--p));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;flex-shrink:0}
        .sb-brand-text{}
        .sb-brand-title{font-size:.73rem;font-weight:700;color:var(--soft);letter-spacing:.04em}
        .sb-brand-sub{font-size:.62rem;color:var(--muted);margin-top:.1rem}
        .sb-online{display:inline-flex;align-items:center;gap:.3rem;font-size:.6rem;color:var(--green);background:var(--green-bg);border:1px solid var(--green-b);border-radius:999px;padding:.1rem .5rem;margin-top:.3rem}
        .sb-online::before{content:'';width:5px;height:5px;border-radius:50%;background:var(--green);animation:onlinePulse 2s ease-in-out infinite}
        @keyframes onlinePulse{0%,100%{opacity:1}50%{opacity:.4}}

        /* User */
        .sb-user{display:flex;align-items:center;gap:.7rem;padding:.8rem 1.1rem;border-bottom:1px solid var(--b)}
        .sb-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--pl),var(--rose));display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:.9rem;color:#0b0703;font-weight:700;flex-shrink:0}
        .sb-uname{font-size:.78rem;color:var(--soft);font-weight:600}
        .sb-badge{font-size:.58rem;background:rgba(198,146,74,.15);border:1px solid rgba(198,146,74,.28);color:var(--pl);border-radius:999px;padding:.07rem .4rem;font-weight:700;letter-spacing:.05em;display:inline-block;margin-top:.15rem}

        /* Nav */
        .sb-nav{flex:1;padding:.6rem 0}
        .sb-section{font-size:.58rem;font-weight:700;letter-spacing:.12em;color:rgba(240,232,223,.18);padding:.7rem 1.1rem .25rem;text-transform:uppercase}
        .sb-link{
            display:flex;align-items:center;gap:.65rem;
            padding:.58rem 1.1rem;font-size:.83rem;color:var(--muted);
            transition:all .18s;border-right:2px solid transparent;
            cursor:pointer;position:relative;
        }
        .sb-link:hover{color:var(--pl);background:rgba(198,146,74,.05);border-right-color:rgba(198,146,74,.25)}
        .sb-link.active{color:var(--pl);background:rgba(198,146,74,.09);border-right-color:var(--p);font-weight:600}
        .sb-link.active .sb-link-icon{filter:none}
        .sb-link-icon{font-size:.95rem;width:18px;text-align:center;flex-shrink:0;opacity:.7}
        .sb-link.active .sb-link-icon,.sb-link:hover .sb-link-icon{opacity:1}
        .sb-count{
            margin-right:auto;border-radius:999px;
            padding:.1rem .48rem;font-size:.63rem;font-weight:700;
            background:rgba(198,146,74,.14);color:var(--pl);
        }
        .sb-count.urgent{
            background:rgba(239,68,68,.15);color:#f87171;
            border:1px solid rgba(239,68,68,.25);
            animation:urgentBadge 2s ease-in-out infinite;
        }
        @keyframes urgentBadge{0%,100%{box-shadow:none}50%{box-shadow:0 0 8px rgba(239,68,68,.35)}}

        /* Divider */
        .sb-divider{height:1px;background:var(--b);margin:.3rem .9rem}

        /* Footer */
        .sb-footer{padding:.85rem 1.1rem;border-top:1px solid var(--b)}
        .sb-logout{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);cursor:pointer;transition:all .2s;background:none;border:none;width:100%;font-family:'Tajawal',sans-serif;padding:0;border-radius:8px}
        .sb-logout:hover{color:#f87171}
        .sb-version{font-size:.6rem;color:rgba(240,232,223,.15);text-align:center;margin-top:.5rem}

        /* ══════════════════════════════════════
           MAIN LAYOUT
        ══════════════════════════════════════ */
        .main{margin-right:var(--sidebar-w);flex:1;min-height:100vh;display:flex;flex-direction:column;min-width:0;width:calc(100% - var(--sidebar-w));overflow-x:hidden}
        .topbar{
            height:54px;
            background:rgba(11,7,3,.96);
            backdrop-filter:blur(24px);
            border-bottom:1px solid var(--b);
            padding:0 1.8rem;
            display:flex;align-items:center;justify-content:space-between;
            position:sticky;top:0;z-index:100;
        }
        .topbar-left{}
        .topbar-crumb{font-size:.7rem;color:var(--muted);display:flex;align-items:center;gap:.35rem;margin-bottom:.15rem}
        .topbar-crumb a{color:var(--muted);transition:color .2s}.topbar-crumb a:hover{color:var(--pl)}
        .topbar-crumb-sep{color:rgba(240,232,223,.2);font-size:.65rem}
        .topbar-title{font-size:.95rem;font-weight:700;color:var(--text)}
        .topbar-right{display:flex;align-items:center;gap:.8rem}
        .topbar-time{font-size:.72rem;color:var(--muted)}
        .health-pill{
            display:inline-flex;align-items:center;gap:.35rem;
            padding:.25rem .7rem;border-radius:999px;font-size:.7rem;font-weight:700;
            cursor:default;
        }
        .health-pill.h-green{background:var(--green-bg);border:1px solid var(--green-b);color:var(--green)}
        .health-pill.h-yellow{background:var(--yellow-bg);border:1px solid var(--yellow-b);color:var(--yellow)}
        .health-pill.h-red{background:var(--red-bg);border:1px solid var(--red-b);color:#f87171;animation:healthAlert 1.8s ease-in-out infinite}
        @keyframes healthAlert{0%,100%{box-shadow:none}50%{box-shadow:0 0 10px rgba(239,68,68,.3)}}
        .alert-badge-top{
            display:inline-flex;align-items:center;gap:.3rem;
            background:var(--red-bg);border:1px solid var(--red-b);
            border-radius:999px;padding:.2rem .65rem;font-size:.7rem;color:#f87171;font-weight:700;
        }

        .content{flex:1;padding:1.4rem 1.6rem 3rem;width:100%;min-width:0}

        /* ══════════════════════════════════════
           ALERT BANNER
        ══════════════════════════════════════ */
        .alert-banner{
            background:linear-gradient(135deg,rgba(239,68,68,.1),rgba(239,68,68,.04));
            border:1px solid rgba(239,68,68,.22);
            border-radius:var(--radius);
            padding:1rem 1.3rem;
            margin-bottom:1.3rem;
            display:flex;align-items:center;gap:1.2rem;flex-wrap:wrap;
        }
        .alert-banner-title{font-size:.85rem;font-weight:700;color:#f87171;flex-shrink:0}
        .alert-items{display:flex;flex-wrap:wrap;gap:.6rem;flex:1}
        .alert-chip{
            display:inline-flex;align-items:center;gap:.5rem;
            background:rgba(0,0,0,.3);border:1px solid rgba(239,68,68,.2);
            border-radius:10px;padding:.35rem .85rem;
            font-size:.78rem;color:rgba(240,232,223,.75);
            transition:border-color .2s;
        }
        .alert-chip:hover{border-color:rgba(239,68,68,.4)}
        .alert-chip strong{color:#f87171}
        .alert-chip-count{
            background:rgba(239,68,68,.18);border-radius:999px;
            padding:.08rem .45rem;font-size:.65rem;font-weight:700;color:#f87171;
        }
        .alert-btn{
            padding:.4rem 1rem;border-radius:9px;border:1px solid rgba(239,68,68,.3);
            background:rgba(239,68,68,.1);color:#f87171;font-family:'Tajawal',sans-serif;
            font-size:.75rem;font-weight:700;cursor:pointer;transition:all .2s;white-space:nowrap;
            text-decoration:none;display:inline-block;
        }
        .alert-btn:hover{background:rgba(239,68,68,.2);color:#fca5a5}

        /* ══════════════════════════════════════
           QUICK ACTIONS BAR
        ══════════════════════════════════════ */
        .qa-bar{
            display:flex;align-items:center;gap:.6rem;
            flex-wrap:wrap;margin-bottom:1.3rem;
        }
        .qa-label{font-size:.72rem;font-weight:700;color:var(--muted);letter-spacing:.06em;text-transform:uppercase;margin-left:.3rem}
        .qa-btn{
            display:inline-flex;align-items:center;gap:.4rem;
            padding:.42rem 1rem;border-radius:999px;
            font-family:'Tajawal',sans-serif;font-size:.78rem;font-weight:600;
            cursor:pointer;transition:all .2s;border:1px solid;
            text-decoration:none;
        }
        .qa-btn-gold{background:rgba(198,146,74,.08);border-color:var(--bm);color:var(--pl)}.qa-btn-gold:hover{background:rgba(198,146,74,.16)}
        .qa-btn-red{background:var(--red-bg);border-color:var(--red-b);color:#f87171}.qa-btn-red:hover{background:rgba(239,68,68,.15)}
        .qa-btn-blue{background:rgba(90,143,194,.08);border-color:rgba(90,143,194,.2);color:var(--blue)}.qa-btn-blue:hover{background:rgba(90,143,194,.16)}
        .qa-btn-sage{background:rgba(122,158,142,.08);border-color:rgba(122,158,142,.2);color:var(--sage)}.qa-btn-sage:hover{background:rgba(122,158,142,.16)}

        /* ══════════════════════════════════════
           CARDS
        ══════════════════════════════════════ */
        .card{background:var(--card);border:1px solid var(--b);border-radius:var(--radius);overflow:hidden}
        .card-head{display:flex;align-items:center;justify-content:space-between;padding:.85rem 1.2rem;border-bottom:1px solid var(--b)}
        .card-title{font-size:.87rem;font-weight:700;color:var(--soft);display:flex;align-items:center;gap:.4rem}
        .card-body{padding:1.1rem 1.2rem}
        .card-foot{padding:.65rem 1.2rem;border-top:1px solid var(--b);display:flex;align-items:center;justify-content:space-between}

        /* ══════════════════════════════════════
           STAT CARDS
        ══════════════════════════════════════ */
        .stats-row{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:.85rem;margin-bottom:1.2rem}
        .scard{
            border-radius:var(--radius);padding:1rem .95rem;
            display:flex;flex-direction:column;gap:.25rem;
            position:relative;overflow:hidden;border:1px solid;
        }
        .scard::before{content:'';position:absolute;top:0;left:0;right:0;height:2px}
        .scard-icon{font-size:1.3rem;margin-bottom:.1rem}
        .scard-val{font-family:'Amiri',serif;font-size:2rem;font-weight:700;line-height:1}
        .scard-lbl{font-size:.7rem;color:var(--muted)}
        .scard-foot{display:flex;align-items:center;gap:.4rem;margin-top:.2rem}
        .scard-delta{font-size:.67rem}
        .trend-up{color:#4ade80}.trend-up::before{content:'↑ '}
        .trend-down{color:#f87171}.trend-down::before{content:'↓ '}
        .trend-flat{color:var(--muted)}.trend-flat::before{content:'→ '}
        .scard-ctx{font-size:.65rem;color:var(--muted)}

        .sc-users{background:linear-gradient(145deg,rgba(90,143,194,.07),transparent);border-color:rgba(90,143,194,.15)}.sc-users::before{background:var(--blue)}.sc-users .scard-val{color:var(--blue)}
        .sc-atabs{background:linear-gradient(145deg,rgba(198,146,74,.07),transparent);border-color:var(--b)}.sc-atabs::before{background:var(--p)}.sc-atabs .scard-val{color:var(--p)}
        .sc-reps{background:linear-gradient(145deg,rgba(239,68,68,.07),transparent);border-color:var(--red-b)}.sc-reps::before{background:var(--red)}.sc-reps .scard-val{color:#f87171}
        .sc-rec{background:linear-gradient(145deg,rgba(122,158,142,.07),transparent);border-color:rgba(122,158,142,.15)}.sc-rec::before{background:var(--sage)}.sc-rec .scard-val{color:var(--sage)}
        .sc-flag{background:linear-gradient(145deg,rgba(251,191,36,.07),transparent);border-color:var(--yellow-b)}.sc-flag::before{background:var(--yellow)}.sc-flag .scard-val{color:var(--yellow)}

        /* ══════════════════════════════════════
           SYSTEM HEALTH
        ══════════════════════════════════════ */
        .health-card{border-radius:var(--radius);border:1px solid;padding:1.3rem;display:flex;flex-direction:column;gap:1rem}
        .health-card.h-green{background:linear-gradient(145deg,rgba(74,222,128,.06),transparent);border-color:var(--green-b)}
        .health-card.h-yellow{background:linear-gradient(145deg,rgba(251,191,36,.06),transparent);border-color:var(--yellow-b)}
        .health-card.h-red{background:linear-gradient(145deg,rgba(239,68,68,.08),transparent);border-color:var(--red-b)}
        .health-status{display:flex;align-items:center;gap:.7rem}
        .health-dot{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
        .h-green .health-dot{background:var(--green-bg);border:1px solid var(--green-b)}
        .h-yellow .health-dot{background:var(--yellow-bg);border:1px solid var(--yellow-b)}
        .h-red .health-dot{background:var(--red-bg);border:1px solid var(--red-b);animation:healthPulse 1.5s ease-in-out infinite}
        @keyframes healthPulse{0%,100%{box-shadow:none}50%{box-shadow:0 0 14px rgba(239,68,68,.3)}}
        .health-title{font-size:1rem;font-weight:700;color:var(--text)}
        .health-sub{font-size:.75rem;color:var(--muted);margin-top:.1rem}
        .health-meter{background:rgba(0,0,0,.3);border-radius:999px;height:6px;overflow:hidden}
        .health-fill{height:100%;border-radius:999px;transition:width .6s ease}
        .h-green .health-fill{background:linear-gradient(90deg,#4ade80,#22c55e)}
        .h-yellow .health-fill{background:linear-gradient(90deg,#fbbf24,#f59e0b)}
        .h-red .health-fill{background:linear-gradient(90deg,#f87171,#ef4444)}
        .health-items{display:flex;flex-direction:column;gap:.5rem}
        .health-item{display:flex;align-items:center;justify-content:space-between;font-size:.76rem}
        .health-item-lbl{color:var(--muted)}
        .health-item-val{font-weight:700;color:var(--text)}
        .health-item-val.ok{color:var(--green)}
        .health-item-val.warn{color:var(--yellow)}
        .health-item-val.bad{color:#f87171}

        /* ══════════════════════════════════════
           ACTIVITY TIMELINE
        ══════════════════════════════════════ */
        .timeline{display:flex;flex-direction:column;gap:0;padding:.2rem 0}
        .tl-item{display:flex;align-items:flex-start;gap:.75rem;padding:.55rem .2rem;position:relative}
        .tl-item:not(:last-child)::after{content:'';position:absolute;right:1.28rem;top:2.1rem;bottom:0;width:1px;background:var(--b)}
        .tl-dot{
            width:28px;height:28px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            font-size:.78rem;flex-shrink:0;z-index:1;
            border:1px solid;
        }
        .tl-dot.type-user{background:rgba(90,143,194,.1);border-color:rgba(90,143,194,.25)}
        .tl-dot.type-atab{background:rgba(198,146,74,.1);border-color:var(--bm)}
        .tl-dot.type-flag{background:rgba(251,191,36,.1);border-color:var(--yellow-b)}
        .tl-dot.type-report{background:var(--red-bg);border-color:var(--red-b)}
        .tl-dot.type-reconciliation{background:rgba(122,158,142,.1);border-color:rgba(122,158,142,.25)}
        .tl-content{flex:1;min-width:0;padding-top:.08rem}
        .tl-text{font-size:.81rem;color:var(--soft);font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .tl-text.urgent{color:#f87171}
        .tl-sub{font-size:.71rem;color:var(--muted);margin-top:.1rem}
        .tl-time{font-size:.66rem;color:rgba(240,232,223,.28);flex-shrink:0;padding-top:.15rem;white-space:nowrap}
        .tl-link{color:var(--p);font-size:.67rem;display:inline-block;margin-top:.12rem}
        .tl-link:hover{color:var(--pl)}
        .tl-empty{text-align:center;padding:2rem;font-size:.83rem;color:var(--muted)}

        /* ══════════════════════════════════════
           TABLES
        ══════════════════════════════════════ */
        .tbl-wrap{overflow-x:auto}
        table{width:100%;border-collapse:collapse;font-size:.82rem}
        thead tr{border-bottom:1px solid var(--b)}
        th{padding:.65rem 1rem;text-align:right;font-size:.68rem;font-weight:700;letter-spacing:.06em;color:var(--muted);text-transform:uppercase;white-space:nowrap}
        td{padding:.7rem 1rem;border-bottom:1px solid rgba(198,146,74,.05);color:var(--soft);vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:rgba(198,146,74,.025)}
        .td-name{font-weight:700;color:var(--text);font-size:.84rem}
        .td-muted{color:var(--muted);font-size:.75rem}
        .td-mono{font-family:monospace;font-size:.77rem;color:var(--blue);direction:ltr;text-align:left}

        /* ══════════════════════════════════════
           BADGES
        ══════════════════════════════════════ */
        .badge{display:inline-flex;align-items:center;padding:.16rem .55rem;border-radius:999px;font-size:.65rem;font-weight:700;white-space:nowrap}
        .b-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-b)}
        .b-red{background:var(--red-bg);color:#f87171;border:1px solid var(--red-b)}
        .b-yellow{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-b)}
        .b-blue{background:rgba(90,143,194,.1);color:var(--blue);border:1px solid rgba(90,143,194,.22)}
        .b-gold{background:rgba(198,146,74,.1);color:var(--pl);border:1px solid var(--bm)}
        .b-sage{background:rgba(122,158,142,.1);color:var(--sage);border:1px solid rgba(122,158,142,.22)}
        .b-muted{background:rgba(240,232,223,.04);color:var(--muted);border:1px solid rgba(240,232,223,.08)}
        .b-orange{background:rgba(249,115,22,.1);color:#fb923c;border:1px solid rgba(249,115,22,.22)}

        /* Spam score */
        .spam-bar{display:flex;align-items:center;gap:.4rem}
        .spam-fill{height:4px;border-radius:2px;min-width:2px;max-width:60px;transition:width .3s}
        .spam-0{background:var(--green);width:12px}
        .spam-1{background:var(--yellow);width:24px}
        .spam-2{background:#fb923c;width:36px}
        .spam-3{background:#f87171;width:50px}

        /* ══════════════════════════════════════
           ACTION BUTTONS
        ══════════════════════════════════════ */
        .act-btn{padding:.26rem .7rem;border-radius:8px;font-family:'Tajawal',sans-serif;font-size:.73rem;font-weight:600;cursor:pointer;transition:all .18s;border:1px solid;white-space:nowrap;display:inline-flex;align-items:center;gap:.25rem}
        .ab-red{background:var(--red-bg);border-color:var(--red-b);color:#f87171}.ab-red:hover{background:rgba(239,68,68,.16)}
        .ab-green{background:var(--green-bg);border-color:var(--green-b);color:var(--green)}.ab-green:hover{background:rgba(74,222,128,.14)}
        .ab-gold{background:rgba(198,146,74,.08);border-color:var(--bm);color:var(--pl)}.ab-gold:hover{background:rgba(198,146,74,.18)}
        .ab-blue{background:rgba(90,143,194,.08);border-color:rgba(90,143,194,.22);color:var(--blue)}.ab-blue:hover{background:rgba(90,143,194,.16)}
        .ab-yellow{background:var(--yellow-bg);border-color:var(--yellow-b);color:var(--yellow)}.ab-yellow:hover{background:rgba(251,191,36,.15)}
        .ab-ghost{background:transparent;border-color:var(--b);color:var(--muted)}.ab-ghost:hover{border-color:var(--bm);color:var(--text)}
        .btn-acts{display:flex;gap:.3rem;flex-wrap:wrap;align-items:center}

        /* ══════════════════════════════════════
           SEARCH / FILTER BAR
        ══════════════════════════════════════ */
        .filter-bar{display:flex;align-items:center;gap:.65rem;padding:.85rem 1.2rem;border-bottom:1px solid var(--b);flex-wrap:wrap}
        .search-inp{background:rgba(0,0,0,.4);border:1px solid var(--b);border-radius:10px;padding:.42rem .85rem;color:var(--text);font-family:'Tajawal',sans-serif;font-size:.82rem;outline:none;transition:border-color .2s;min-width:180px}
        .search-inp:focus{border-color:var(--p)}
        .search-inp::placeholder{color:var(--muted)}
        .filter-pill{padding:.32rem .8rem;border-radius:999px;font-family:'Tajawal',sans-serif;font-size:.74rem;cursor:pointer;transition:all .18s;background:rgba(198,146,74,.05);border:1px solid var(--b);color:var(--muted);text-decoration:none;display:inline-block}
        .filter-pill:hover,.filter-pill.active{background:linear-gradient(135deg,var(--pl),var(--p));color:#0b0703;border-color:transparent;font-weight:700}
        .filter-pill.danger-pill{background:var(--red-bg);border-color:var(--red-b);color:#f87171}
        .filter-pill.danger-pill:hover,.filter-pill.danger-pill.active{background:rgba(239,68,68,.2);color:#fca5a5}

        /* ══════════════════════════════════════
           PAGINATION
        ══════════════════════════════════════ */
        .pag{display:flex;align-items:center;justify-content:space-between;padding:.7rem 1.2rem;border-top:1px solid var(--b)}
        .pag-info{font-size:.72rem;color:var(--muted)}
        .pag-links{display:flex;gap:.3rem}
        .pag-links a,.pag-links span{padding:.28rem .65rem;border-radius:8px;font-size:.77rem;border:1px solid var(--b);color:var(--muted);transition:all .18s}
        .pag-links a:hover{border-color:var(--bm);color:var(--pl)}
        .pag-links .active-page{background:linear-gradient(135deg,var(--pl),var(--p));color:#0b0703;border-color:transparent;font-weight:700}

        /* ══════════════════════════════════════
           LAYOUT GRIDS
        ══════════════════════════════════════ */
        .grid2{display:grid;grid-template-columns:1fr 1fr;gap:1.1rem}
        .grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.1rem}
        .grid-health{display:grid;grid-template-columns:2fr 1fr;gap:1.1rem}

        /* Dashboard master 2-col layout */
        .dash-layout{display:grid;grid-template-columns:1fr 340px;gap:1.2rem;align-items:start}
        .dash-main{display:flex;flex-direction:column;gap:1.2rem;min-width:0}
        .dash-side{display:flex;flex-direction:column;gap:1.2rem;min-width:0}

        /* ══════════════════════════════════════
           CHART CONTAINER
        ══════════════════════════════════════ */
        .chart-wrap{position:relative;height:240px;padding:.4rem}

        /* ══════════════════════════════════════
           TOAST
        ══════════════════════════════════════ */
        #a-toast{position:fixed;bottom:1.5rem;left:50%;transform:translateX(-50%) translateY(12px);background:var(--card2);border:1px solid var(--bm);border-radius:var(--radius);padding:.65rem 1.4rem;font-size:.82rem;z-index:9999;opacity:0;pointer-events:none;transition:all .28s;white-space:nowrap;box-shadow:0 8px 30px rgba(0,0,0,.65)}
        #a-toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
        #a-toast.t-s{border-color:var(--green-b);color:var(--green)}
        #a-toast.t-e{border-color:var(--red-b);color:#f87171}
        #a-toast.t-i{border-color:var(--bm);color:var(--pl)}

        /* ══════════════════════════════════════
           CONFIRM DIALOG
        ══════════════════════════════════════ */
        .confirm-overlay{position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:8000;display:none;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(4px)}
        .confirm-overlay.open{display:flex}
        .confirm-box{background:var(--card2);border:1px solid var(--bm);border-radius:18px;padding:1.8rem;max-width:360px;width:100%;text-align:center}
        .confirm-icon{font-size:2.2rem;margin-bottom:.7rem}
        .confirm-title{font-size:1rem;font-weight:700;color:var(--text);margin-bottom:.4rem}
        .confirm-sub{font-size:.82rem;color:var(--muted);line-height:1.6;margin-bottom:1.3rem}
        .confirm-btns{display:flex;gap:.6rem;justify-content:center}
        .confirm-yes{padding:.55rem 1.4rem;border-radius:10px;border:none;background:linear-gradient(135deg,#f87171,#ef4444);color:#fff;font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:700;cursor:pointer;transition:all .2s}
        .confirm-yes:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(239,68,68,.4)}
        .confirm-no{padding:.55rem 1.4rem;border-radius:10px;background:transparent;border:1px solid var(--b);color:var(--muted);font-family:'Tajawal',sans-serif;font-size:.88rem;cursor:pointer;transition:all .2s}
        .confirm-no:hover{border-color:var(--bm);color:var(--text)}

        /* ══════════════════════════════════════
           FORMS
        ══════════════════════════════════════ */
        .form-group{display:flex;flex-direction:column;gap:.4rem;margin-bottom:.9rem}
        .form-label{font-size:.76rem;color:var(--muted);font-weight:700}
        .form-inp{background:rgba(0,0,0,.35);border:1px solid var(--b);border-radius:10px;padding:.58rem .85rem;color:var(--text);font-family:'Tajawal',sans-serif;font-size:.84rem;outline:none;transition:border-color .2s;width:100%}
        .form-inp:focus{border-color:var(--p)}
        .form-inp::placeholder{color:var(--muted)}
        .form-select{background:rgba(0,0,0,.45);border:1px solid var(--b);border-radius:10px;padding:.58rem .85rem;color:var(--text);font-family:'Tajawal',sans-serif;font-size:.84rem;outline:none;width:100%;cursor:pointer}
        .toggle-wrap{display:flex;align-items:center;justify-content:space-between;padding:.75rem .95rem;background:rgba(0,0,0,.2);border:1px solid var(--b);border-radius:12px;margin-bottom:.6rem}
        .toggle-label{font-size:.83rem;color:var(--soft)}
        .toggle-sub{font-size:.7rem;color:var(--muted);margin-top:.1rem}
        .toggle{position:relative;width:42px;height:22px;flex-shrink:0}
        .toggle input{opacity:0;width:0;height:0}
        .toggle-slider{position:absolute;inset:0;background:rgba(255,255,255,.08);border-radius:999px;cursor:pointer;transition:.28s;border:1px solid var(--b)}
        .toggle-slider::before{content:'';position:absolute;left:3px;top:50%;transform:translateY(-50%);width:14px;height:14px;border-radius:50%;background:var(--muted);transition:.28s}
        .toggle input:checked + .toggle-slider{background:rgba(198,146,74,.22);border-color:var(--p)}
        .toggle input:checked + .toggle-slider::before{transform:translateY(-50%) translateX(20px);background:var(--p)}
        .btn-save{padding:.6rem 1.5rem;border-radius:11px;border:none;background:linear-gradient(135deg,var(--pl),var(--p));color:#0b0703;font-family:'Tajawal',sans-serif;font-size:.88rem;font-weight:700;cursor:pointer;transition:all .3s;box-shadow:0 4px 14px var(--glow2)}
        .btn-save:hover{transform:translateY(-2px);box-shadow:0 7px 22px var(--glow2)}

        /* Word tags */
        .word-tags{display:flex;flex-wrap:wrap;gap:.45rem;min-height:36px}
        .word-tag{display:inline-flex;align-items:center;gap:.35rem;background:var(--red-bg);border:1px solid var(--red-b);border-radius:999px;padding:.2rem .7rem;font-size:.76rem;color:#f87171}
        .word-tag-remove{cursor:pointer;opacity:.6;transition:opacity .2s;background:none;border:none;color:inherit;padding:0;line-height:1;font-size:.73rem}
        .word-tag-remove:hover{opacity:1}
        .config-tag{background:rgba(240,232,223,.04);border-color:rgba(240,232,223,.08);color:var(--muted)}

        /* Empty */
        .empty-row td{text-align:center;padding:2.5rem;color:var(--muted);font-size:.83rem}
        .empty-state{text-align:center;padding:3rem 1rem}
        .empty-state-icon{font-size:2.8rem;margin-bottom:.8rem;opacity:.5}
        .empty-state-text{font-size:.88rem;color:var(--muted)}
        .empty-state-sub{font-size:.77rem;color:rgba(240,232,223,.28);margin-top:.3rem}

        /* Section header */
        .section-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:.85rem}
        .section-title{font-size:.92rem;font-weight:700;color:var(--soft);display:flex;align-items:center;gap:.4rem}

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media(max-width:1280px){.dash-layout{grid-template-columns:1fr 300px}}
        @media(max-width:1100px){.dash-layout{grid-template-columns:1fr}.dash-side{flex-direction:row;flex-wrap:wrap}.dash-side>*{flex:1;min-width:280px}}
        @media(max-width:1000px){.grid-health{grid-template-columns:1fr}}
        @media(max-width:900px){.grid2,.grid3{grid-template-columns:1fr}.dash-side{flex-direction:column}}
        @media(max-width:768px){
            .sidebar{display:none}
            .main{margin-right:0;width:100%}
            .stats-row{grid-template-columns:repeat(2,1fr)}
            .dash-layout{grid-template-columns:1fr}
            .dash-side{flex-direction:column}
            .content{padding:.9rem}
            .topbar{padding:0 1rem}
        }
        @media(max-width:480px){
            .stats-row{grid-template-columns:1fr 1fr}
            .scard-val{font-size:1.6rem}
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ── --}}
@php
    $sbReports = \App\Models\Report::distinct('atab_id')->count('atab_id');
    $sbFlagged = \App\Models\Atab::where('is_flagged', true)->count();
    $sbAlerts  = $sbReports + $sbFlagged;
@endphp

<aside class="sidebar">
    <div class="sb-brand">
        <span class="sb-logo">ع</span>
        <div class="sb-brand-text">
            <div class="sb-brand-title">عتاب · Admin</div>
            <div class="sb-brand-sub">لوحة التحكم</div>
            <div class="sb-online">متصل</div>
        </div>
    </div>

    <div class="sb-user">
        <div class="sb-av">{{ mb_substr(auth()->user()->name, 0, 1) }}</div>
        <div>
            <div class="sb-uname">{{ auth()->user()->name }}</div>
            <span class="sb-badge">ADMIN</span>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">عام</div>
        <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sb-link-icon">📊</span> نظرة عامة
            @if($sbAlerts > 0)
                <span class="sb-count urgent">{{ $sbAlerts }}</span>
            @endif
        </a>
        <a href="{{ route('admin.analytics') }}" class="sb-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <span class="sb-link-icon">📈</span> الإحصائيات
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">المحتوى</div>
        <a href="{{ route('admin.users') }}" class="sb-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <span class="sb-link-icon">👥</span> المستخدمون
        </a>
        <a href="{{ route('admin.atabs') }}" class="sb-link {{ request()->routeIs('admin.atabs*') ? 'active' : '' }}">
            <span class="sb-link-icon">💬</span> العتابات
        </a>
        <a href="{{ route('admin.reconciliations') }}" class="sb-link {{ request()->routeIs('admin.reconciliations*') ? 'active' : '' }}">
            <span class="sb-link-icon">🤝</span> المصالحات
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">الإشراف</div>
        <a href="{{ route('admin.reports') }}" class="sb-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
            <span class="sb-link-icon">🚩</span> البلاغات
            @if($sbReports > 0)<span class="sb-count urgent">{{ $sbReports }}</span>@endif
        </a>
        <a href="{{ route('admin.moderation') }}" class="sb-link {{ request()->routeIs('admin.moderation*') ? 'active' : '' }}">
            <span class="sb-link-icon">🛡️</span> الإشراف
            @if($sbFlagged > 0)<span class="sb-count urgent">{{ $sbFlagged }}</span>@endif
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">النظام</div>
        <a href="{{ route('admin.settings') }}" class="sb-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <span class="sb-link-icon">⚙️</span> الإعدادات
        </a>
        <a href="{{ route('dashboard') }}" target="_blank" class="sb-link">
            <span class="sb-link-icon">🏠</span> صندوقي
        </a>
    </nav>

    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <span>🚪</span> تسجيل الخروج
            </button>
        </form>
        <div class="sb-version">v2.0 · عتاب</div>
    </div>
</aside>

{{-- ── MAIN ── --}}
<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-crumb">
                <a href="{{ route('admin.dashboard') }}">Admin</a>
                <span class="topbar-crumb-sep">›</span>
                <span>@yield('crumb', 'Dashboard')</span>
            </div>
            <div class="topbar-title">@yield('title', 'لوحة التحكم')</div>
        </div>
        <div class="topbar-right">
            @if($sbAlerts > 0)
            <a href="{{ route('admin.reports') }}" class="alert-badge-top">
                🚨 {{ $sbAlerts }} تنبيه
            </a>
            @endif
            <span class="topbar-time" id="tb-time"></span>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

{{-- Toast --}}
<div id="a-toast"></div>

{{-- Confirm Dialog --}}
<div class="confirm-overlay" id="confirm-overlay">
    <div class="confirm-box">
        <div class="confirm-icon" id="confirm-icon">⚠️</div>
        <div class="confirm-title" id="confirm-title">هل أنت متأكد؟</div>
        <div class="confirm-sub" id="confirm-sub">هذا الإجراء لا يمكن التراجع عنه.</div>
        <div class="confirm-btns">
            <button class="confirm-yes" id="confirm-yes">تأكيد</button>
            <button class="confirm-no" onclick="closeConfirm()">إلغاء</button>
        </div>
    </div>
</div>

<script>
// ── Clock ──────────────────────────────────────────────────
(function tick(){
    const t = document.getElementById('tb-time');
    if (t) t.textContent = new Date().toLocaleTimeString('ar-SA', {hour:'2-digit', minute:'2-digit'});
    setTimeout(tick, 30000);
})();

// ── CSRF ───────────────────────────────────────────────────
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.content || '';

// ── Toast ──────────────────────────────────────────────────
function aToast(msg, type = 'i') {
    const t = document.getElementById('a-toast');
    t.textContent = msg;
    t.className = 'show t-' + type;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.className = '', 3400);
}

// ── Generic AJAX ───────────────────────────────────────────
async function adminAction(url, method, onSuccess, onError) {
    try {
        const r = await fetch(url, {
            method: method || 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
            },
        });
        const d = await r.json();
        if (d.success) {
            aToast(d.message || '✅ تم', 's');
            if (onSuccess) onSuccess(d);
        } else {
            aToast(d.message || '⚠️ خطأ', 'e');
            if (onError) onError(d);
        }
    } catch (e) { aToast('⚠️ خطأ في الاتصال', 'e'); }
}

// ── Confirm Dialog ─────────────────────────────────────────
let _confirmCb = null;
function showConfirm(title, sub, icon, onConfirm) {
    document.getElementById('confirm-title').textContent = title;
    document.getElementById('confirm-sub').textContent = sub;
    document.getElementById('confirm-icon').textContent = icon || '⚠️';
    _confirmCb = onConfirm;
    document.getElementById('confirm-overlay').classList.add('open');
}
function closeConfirm() {
    document.getElementById('confirm-overlay').classList.remove('open');
    _confirmCb = null;
}
document.getElementById('confirm-yes').onclick = function() {
    closeConfirm();
    if (_confirmCb) _confirmCb();
};
document.getElementById('confirm-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});
</script>
@stack('scripts')
</body>
</html>
