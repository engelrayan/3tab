@extends('admin.layout')
@section('title', 'نظرة عامة')
@section('crumb', 'Dashboard')

@section('content')

{{-- ══════════════════════════════════════════════════════
     🚨  PRIORITY ALERTS  (full-width top band)
══════════════════════════════════════════════════════ --}}
@if($alerts['total'] > 0 || $alerts['suspected'] > 0)
<div class="alert-top">
    <div class="alert-top-inner">
        <span class="alert-top-title">
            <span class="alert-pulse-dot"></span>
            تنبيهات تحتاج تدخلاً
        </span>
        <div class="alert-chips">
            @if($alerts['reports'] > 0)
            <a href="{{ route('admin.reports') }}" class="achip achip-red">
                🚩 بلاغات <span class="achip-n">{{ $alerts['reports'] }}</span>
            </a>
            @endif
            @if($alerts['flagged'] > 0)
            <a href="{{ route('admin.moderation') }}" class="achip achip-yellow">
                ⚠️ مشبوهة <span class="achip-n achip-n-y">{{ $alerts['flagged'] }}</span>
            </a>
            @endif
            @if($alerts['suspected'] > 0)
            <a href="{{ route('admin.users', ['filter'=>'suspicious']) }}" class="achip achip-orange">
                🚫 مستخدمون مشبوهون <span class="achip-n achip-n-o">{{ $alerts['suspected'] }}</span>
            </a>
            @endif
        </div>
        <a href="{{ route('admin.reports') }}" class="alert-top-cta">راجع الآن ←</a>
    </div>
</div>
@else
<div class="clear-banner">
    <span style="font-size:1rem">🎉</span>
    <span class="clear-banner-text">النظام يعمل بشكل مثالي</span>
    <span class="clear-banner-sub">لا يوجد بلاغات أو رسائل مشبوهة تحتاج مراجعة</span>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     ⚡  QUICK ACTIONS  (full-width)
══════════════════════════════════════════════════════ --}}
<div class="qab">
    <span class="qab-label">⚡ إجراءات سريعة</span>
    <a href="{{ route('admin.reports') }}" class="qa-btn qa-btn-red">
        🚩 البلاغات
        @if($alerts['reports'] > 0)<span class="qab-badge qab-badge-r">{{ $alerts['reports'] }}</span>@endif
    </a>
    <a href="{{ route('admin.moderation') }}" class="qa-btn qa-btn-gold">
        ⚠️ المشبوهة
        @if($alerts['flagged'] > 0)<span class="qab-badge qab-badge-y">{{ $alerts['flagged'] }}</span>@endif
    </a>
    <a href="{{ route('admin.users') }}" class="qa-btn qa-btn-blue">👥 المستخدمون</a>
    <a href="{{ route('admin.atabs') }}" class="qa-btn qa-btn-sage">💬 العتابات</a>
    <a href="{{ route('admin.reconciliations') }}" class="qa-btn qa-btn-sage">🤝 المصالحات</a>
    <a href="{{ route('admin.analytics') }}" class="qa-btn qa-btn-gold" style="margin-right:auto">📈 الإحصائيات</a>
</div>

{{-- ══════════════════════════════════════════════════════
     📊  STAT CARDS  (full-width responsive grid)
══════════════════════════════════════════════════════ --}}
@php
    $uTrend = $stats['users_today']   <=> $stats['users_yesterday'];
    $aTrend = $stats['atabs_today']   <=> $stats['atabs_yesterday'];
    $rTrend = $stats['reports_today'] <=> $stats['reports_yesterday'];
@endphp
<div class="stats-row">
    <div class="scard sc-users">
        <div style="display:flex;align-items:flex-start;justify-content:space-between">
            <span class="scard-icon">👥</span>
            <span class="scard-delta {{ $uTrend>0?'trend-up':($uTrend<0?'trend-down':'trend-flat') }}">{{ $stats['users_today'] }} اليوم</span>
        </div>
        <span class="scard-val">{{ number_format($stats['users']) }}</span>
        <span class="scard-lbl">إجمالي المستخدمين</span>
        <div class="scard-foot"><span class="scard-ctx">أمس: {{ $stats['users_yesterday'] }}</span></div>
    </div>
    <div class="scard sc-atabs">
        <div style="display:flex;align-items:flex-start;justify-content:space-between">
            <span class="scard-icon">💬</span>
            <span class="scard-delta {{ $aTrend>0?'trend-up':($aTrend<0?'trend-down':'trend-flat') }}">{{ $stats['atabs_today'] }} اليوم</span>
        </div>
        <span class="scard-val">{{ number_format($stats['atabs']) }}</span>
        <span class="scard-lbl">إجمالي العتابات</span>
        <div class="scard-foot"><span class="scard-ctx">{{ $stats['anonymous'] }} مجهول</span></div>
    </div>
    <div class="scard sc-reps">
        <div style="display:flex;align-items:flex-start;justify-content:space-between">
            <span class="scard-icon">🚩</span>
            <span class="scard-delta {{ $rTrend>0?'trend-up':($rTrend<0?'trend-down':'trend-flat') }}">{{ $stats['reports_today'] }} اليوم</span>
        </div>
        <span class="scard-val">{{ number_format($stats['reports']) }}</span>
        <span class="scard-lbl">عتابات مُبلَّغ عنها</span>
        <div class="scard-foot"><span class="scard-ctx">{{ $stats['reports_total'] }} بلاغ كلي</span></div>
    </div>
    <div class="scard sc-flag">
        <div style="display:flex;align-items:flex-start;justify-content:space-between">
            <span class="scard-icon">⚠️</span>
            @if($stats['flagged']>0)<span class="scard-delta trend-down">{{ $stats['flagged'] }}</span>@endif
        </div>
        <span class="scard-val">{{ number_format($stats['flagged']) }}</span>
        <span class="scard-lbl">رسائل مشبوهة</span>
        <div class="scard-foot"><span class="scard-ctx">{{ $stats['blocked_users'] }} محظور</span></div>
    </div>
    <div class="scard sc-rec">
        <div style="display:flex;align-items:flex-start;justify-content:space-between">
            <span class="scard-icon">🤝</span>
            <span class="scard-delta trend-flat">{{ $stats['guests_today'] }} زائر</span>
        </div>
        <span class="scard-val">{{ number_format($stats['reconciled']) }}</span>
        <span class="scard-lbl">مصالحات ناجحة</span>
        <div class="scard-foot"><span class="scard-ctx">اليوم</span></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MASTER 2-COLUMN LAYOUT
     main (1fr) : timeline + reports table
     side (340px): health + recent users
══════════════════════════════════════════════════════ --}}
<div class="dash-layout">

    {{-- ── MAIN COLUMN ── --}}
    <div class="dash-main">

        {{-- Activity Timeline --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">⏱ النشاط الأخير</span>
                <span style="font-size:.7rem;color:var(--muted)">آخر {{ $timeline->count() }} حدث</span>
            </div>
            <div style="padding:.3rem 1rem 0;max-height:380px;overflow-y:auto">
                @if($timeline->isEmpty())
                    <div class="tl-empty">🎉 لا يوجد نشاط حديث</div>
                @else
                <div class="timeline">
                @foreach($timeline as $item)
                    <div class="tl-item">
                        <div class="tl-dot type-{{ $item['type'] }}">{{ $item['icon'] }}</div>
                        <div class="tl-content">
                            <div class="tl-text {{ $item['urgent'] ? 'urgent' : '' }}">{{ $item['text'] }}</div>
                            @if($item['sub'])<div class="tl-sub">{{ $item['sub'] }}</div>@endif
                            @if($item['link'])<a href="{{ $item['link'] }}" class="tl-link">راجع الآن →</a>@endif
                        </div>
                        <span class="tl-time">{{ $item['time']?->diffForHumans() }}</span>
                    </div>
                @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- Top Reported Atabs --}}
        @if($recentReports->isNotEmpty())
        <div class="card">
            <div class="card-head">
                <span class="card-title">🚩 أعلى العتابات بلاغاً</span>
                <a href="{{ route('admin.reports') }}" class="act-btn ab-red" style="font-size:.7rem">عرض الكل</a>
            </div>
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>المرسل</th>
                            <th>المستقبل</th>
                            <th style="text-align:center">البلاغات</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recentReports as $atab)
                    <tr id="rep-row-{{ $atab->id }}">
                        <td>
                            @if($atab->is_anonymous)
                                <span class="badge b-muted">🎭 مجهول</span>
                            @else
                                <div class="td-name" style="font-size:.81rem">{{ $atab->sender?->name ?? '—' }}</div>
                            @endif
                        </td>
                        <td><div class="td-name" style="font-size:.81rem">{{ $atab->receiver?->name ?? '—' }}</div></td>
                        <td style="text-align:center">
                            <span class="badge {{ $atab->reports_count >= 5 ? 'b-red' : 'b-yellow' }}">
                                {{ $atab->reports_count }}
                            </span>
                        </td>
                        <td>
                            @if($atab->is_flagged)
                                <span class="badge b-orange">⚠️ مشبوه</span>
                            @else
                                <span class="badge b-muted">عادي</span>
                            @endif
                        </td>
                        <td class="td-muted" style="font-size:.72rem;white-space:nowrap">{{ $atab->created_at->format('d/m H:i') }}</td>
                        <td>
                            <div class="btn-acts">
                                <button class="act-btn ab-gold" style="font-size:.7rem"
                                    onclick="flagAtab({{ $atab->id }},{{ $atab->is_flagged?'false':'true' }})">
                                    {{ $atab->is_flagged ? '✓ رُفع' : '🙈 إخفاء' }}
                                </button>
                                <button class="act-btn ab-red" style="font-size:.7rem"
                                    onclick="deleteAtab({{ $atab->id }})">🗑</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="card">
            <div style="padding:2.5rem;text-align:center">
                <div style="font-size:2rem;margin-bottom:.6rem;opacity:.4">🚩</div>
                <div style="font-size:.85rem;color:var(--muted)">🎉 تمام! مفيش بلاغات مشبوهة</div>
            </div>
        </div>
        @endif

    </div>{{-- end dash-main --}}

    {{-- ── SIDE COLUMN ── --}}
    <div class="dash-side">

        {{-- System Health --}}
        <div class="health-card {{ $health['class'] }}">
            <div class="health-status">
                <div class="health-dot">{{ $health['dot'] }}</div>
                <div>
                    <div class="health-title">{{ $health['label'] }}</div>
                    <div class="health-sub">صحة النظام · {{ $health['score'] }}/100</div>
                </div>
            </div>
            <div class="health-meter">
                <div class="health-fill" style="width:{{ $health['score'] }}%"></div>
            </div>
            <div class="health-items">
                <div class="health-item">
                    <span class="health-item-lbl">بلاغات نشطة</span>
                    <span class="health-item-val {{ $stats['reports']===0?'ok':($stats['reports']<5?'warn':'bad') }}">
                        {{ $stats['reports'] }}
                    </span>
                </div>
                <div class="health-item">
                    <span class="health-item-lbl">رسائل مشبوهة</span>
                    <span class="health-item-val {{ $stats['flagged']===0?'ok':($stats['flagged']<3?'warn':'bad') }}">
                        {{ $stats['flagged'] }}
                    </span>
                </div>
                <div class="health-item">
                    <span class="health-item-lbl">محظورون</span>
                    <span class="health-item-val {{ $stats['blocked_users']===0?'ok':'warn' }}">
                        {{ $stats['blocked_users'] }}
                    </span>
                </div>
                <div class="health-item">
                    <span class="health-item-lbl">مشبوهون</span>
                    <span class="health-item-val {{ $alerts['suspected']===0?'ok':'bad' }}">
                        {{ $alerts['suspected'] }}
                    </span>
                </div>
            </div>
            <a href="{{ route('admin.reports') }}" class="act-btn ab-ghost" style="width:100%;justify-content:center;font-size:.75rem">
                عرض كل التقارير →
            </a>
        </div>

        {{-- Recent Users --}}
        <div class="card">
            <div class="card-head">
                <span class="card-title">👤 آخر المنضمين</span>
                <a href="{{ route('admin.users') }}" class="act-btn ab-ghost" style="font-size:.7rem">الكل</a>
            </div>
            <div style="padding:.5rem .8rem;display:flex;flex-direction:column;gap:.4rem">
                @forelse($recentUsers as $u)
                <div class="user-row-mini" onclick="window.open('{{ route('profile.show', $u->username) }}','_blank')">
                    <div class="urm-av">{{ mb_substr($u->name,0,1) }}</div>
                    <div class="urm-info">
                        <div class="urm-name">
                            {{ $u->name }}
                            @if($u->is_admin)<span class="badge b-gold" style="font-size:.5rem;vertical-align:middle">ADMIN</span>@endif
                            @if($u->is_blocked)<span class="badge b-red" style="font-size:.5rem;vertical-align:middle">محظور</span>@endif
                        </div>
                        <div class="urm-sub">{{ $u->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="urm-arrow">›</span>
                </div>
                @empty
                <div style="padding:1.5rem;text-align:center;font-size:.82rem;color:var(--muted)">لا يوجد مستخدمون</div>
                @endforelse
            </div>
        </div>

    </div>{{-- end dash-side --}}

</div>{{-- end dash-layout --}}

@endsection

@push('styles')
<style>
/* ── Alert Top Band ── */
.alert-top{
    background:linear-gradient(135deg,rgba(239,68,68,.13),rgba(239,68,68,.05));
    border:1px solid rgba(239,68,68,.3);border-radius:14px;
    padding:.9rem 1.2rem;margin-bottom:1.1rem;position:relative;overflow:hidden;
}
.alert-top::before{content:'';position:absolute;top:0;right:0;left:0;height:2px;
    background:linear-gradient(90deg,#ef4444,rgba(239,68,68,.2),transparent)}
.alert-top-inner{display:flex;align-items:center;gap:.9rem;flex-wrap:wrap}
.alert-top-title{display:flex;align-items:center;gap:.55rem;font-size:.83rem;font-weight:800;color:#f87171;flex-shrink:0;white-space:nowrap}
.alert-pulse-dot{width:8px;height:8px;border-radius:50%;background:#ef4444;flex-shrink:0;
    animation:dotPulse 1.4s ease-in-out infinite;box-shadow:0 0 0 0 rgba(239,68,68,.4)}
@keyframes dotPulse{0%{box-shadow:0 0 0 0 rgba(239,68,68,.5)}70%{box-shadow:0 0 0 7px rgba(239,68,68,0)}100%{box-shadow:0 0 0 0 rgba(239,68,68,0)}}
.alert-chips{display:flex;flex-wrap:wrap;gap:.5rem;flex:1}
.achip{display:inline-flex;align-items:center;gap:.45rem;border-radius:9px;padding:.3rem .8rem;font-size:.77rem;font-weight:600;text-decoration:none;transition:all .18s;border:1px solid}
.achip-red{background:rgba(239,68,68,.12);border-color:rgba(239,68,68,.28);color:#fca5a5}
.achip-red:hover{background:rgba(239,68,68,.22)}
.achip-yellow{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.25);color:#fde68a}
.achip-yellow:hover{background:rgba(251,191,36,.2)}
.achip-orange{background:rgba(249,115,22,.1);border-color:rgba(249,115,22,.25);color:#fdba74}
.achip-orange:hover{background:rgba(249,115,22,.2)}
.achip-n{background:#ef4444;color:#fff;border-radius:999px;padding:.06rem .42rem;font-size:.63rem;font-weight:800}
.achip-n-y{background:#fbbf24;color:#0b0703}
.achip-n-o{background:#f97316;color:#fff}
.alert-top-cta{padding:.35rem 1rem;border-radius:8px;background:rgba(239,68,68,.18);border:1px solid rgba(239,68,68,.32);color:#f87171;font-size:.77rem;font-weight:700;text-decoration:none;white-space:nowrap;flex-shrink:0;transition:all .18s}
.alert-top-cta:hover{background:rgba(239,68,68,.28)}

/* ── Clear Banner ── */
.clear-banner{display:flex;align-items:center;gap:.75rem;background:rgba(74,222,128,.06);border:1px solid rgba(74,222,128,.2);border-radius:12px;padding:.8rem 1.1rem;margin-bottom:1.1rem}
.clear-banner-text{font-size:.83rem;color:var(--green);font-weight:700}
.clear-banner-sub{font-size:.75rem;color:var(--muted)}

/* ── Quick Actions Bar ── */
.qab{display:flex;align-items:center;gap:.55rem;flex-wrap:wrap;margin-bottom:1.1rem;padding:.6rem .85rem;background:rgba(0,0,0,.2);border:1px solid var(--b);border-radius:12px}
.qab-label{font-size:.66rem;font-weight:800;letter-spacing:.1em;color:rgba(240,232,223,.2);text-transform:uppercase;white-space:nowrap}
.qab-badge{display:inline-block;border-radius:999px;padding:.04rem .42rem;font-size:.62rem;font-weight:800;margin-right:.15rem}
.qab-badge-r{background:rgba(239,68,68,.3);color:#fca5a5}
.qab-badge-y{background:rgba(251,191,36,.25);color:#fde68a}

/* ── Mini User Row ── */
.user-row-mini{display:flex;align-items:center;gap:.6rem;padding:.45rem .5rem;border-radius:10px;cursor:pointer;transition:background .15s}
.user-row-mini:hover{background:rgba(198,146,74,.06)}
.urm-av{width:32px;height:32px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,rgba(198,146,74,.2),rgba(198,146,74,.06));border:1px solid var(--bm);display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:.88rem;color:var(--pl)}
.urm-info{flex:1;min-width:0}
.urm-name{font-size:.8rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.urm-sub{font-size:.67rem;color:var(--muted)}
.urm-arrow{font-size:1rem;color:var(--muted);flex-shrink:0;opacity:.5}

/* Stat card layout fix */
.scard{padding:1rem 1.1rem}

@keyframes alertPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}
</style>
@endpush

@push('scripts')
<script>
function flagAtab(id, flag) {
    adminAction(`/admin/atabs/${id}/flag`, 'POST', () => {
        const row = document.getElementById('rep-row-' + id);
        if (row) { row.style.opacity = '.35'; setTimeout(() => row.remove(), 600); }
    });
}
function deleteAtab(id) {
    showConfirm('🗑 حذف العتاب', 'سيتم حذف العتاب وجميع رسائله نهائياً.', '🗑', () => {
        adminAction(`/admin/atabs/${id}`, 'DELETE', () => {
            const row = document.getElementById('rep-row-' + id);
            if (row) { row.style.transition = 'all .3s'; row.style.opacity = '0'; setTimeout(() => row.remove(), 320); }
        });
    });
}
</script>
@endpush
