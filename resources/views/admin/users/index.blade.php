@extends('admin.layout')
@section('title', 'المستخدمون')
@section('crumb', 'المستخدمون')

@section('content')

{{-- ── FILTER BAR ── --}}
<div class="card" style="margin-bottom:1rem">
    <form method="GET" action="{{ route('admin.users') }}">
        <div class="filter-bar">
            <input class="search-inp" type="text" name="q" value="{{ request('q') }}"
                   placeholder="🔍 ابحث بالاسم أو المعرّف أو البريد..." style="flex:1;max-width:320px">
            <a href="{{ route('admin.users') }}"
               class="filter-pill {{ !request('filter') ? 'active' : '' }}">
                الكل <span style="opacity:.6">({{ $users->total() }})</span>
            </a>
            <a href="{{ route('admin.users', ['filter'=>'suspicious', 'q'=>request('q')]) }}"
               class="filter-pill danger-pill {{ request('filter')==='suspicious' ? 'active' : '' }}">
                🚨 مشبوهون
            </a>
            <a href="{{ route('admin.users', ['filter'=>'blocked', 'q'=>request('q')]) }}"
               class="filter-pill {{ request('filter')==='blocked' ? 'active' : '' }}">
                🚫 محظورون
            </a>
            <a href="{{ route('admin.users', ['filter'=>'admin', 'q'=>request('q')]) }}"
               class="filter-pill {{ request('filter')==='admin' ? 'active' : '' }}">
                ⭐ أدمن
            </a>
            <button type="submit" class="act-btn ab-ghost" style="margin-right:auto">بحث</button>
        </div>
    </form>
</div>

{{-- ── SMART TABLE ── --}}
<div class="card">
    <div class="tbl-wrap">
        <table style="table-layout:fixed;width:100%">
            <colgroup>
                <col style="width:42px">
                <col style="width:220px">
                <col style="width:130px">
                <col style="width:65px">
                <col style="width:65px">
                <col style="width:90px">
                <col style="width:110px">
                <col style="width:105px">
                <col style="width:90px">
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>المستخدم</th>
                    <th>المعرّف</th>
                    <th style="text-align:center">أرسل</th>
                    <th style="text-align:center">استقبل</th>
                    <th style="text-align:center">بلاغات</th>
                    <th>خطورة</th>
                    <th>تاريخ الانضمام</th>
                    <th>الحالة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $u)
            @php
                $rep = $u->reports_on_sent ?? 0;
                $riskScore = match(true) {
                    $rep >= 5 => 3,
                    $rep >= 3 => 2,
                    $rep >= 1 => 1,
                    default   => 0,
                };
                $riskLabel = ['منخفض','متوسط','مرتفع','خطر'][$riskScore];
                $riskClass = ['spam-0','spam-1','spam-2','spam-3'][$riskScore];
                $riskColor = ['var(--green)','var(--yellow)','#fb923c','#f87171'][$riskScore];
            @endphp
            <tr id="user-row-{{ $u->id }}" class="{{ $u->is_blocked ? 'row-blocked' : '' }}">
                <td class="td-muted" style="font-size:.7rem;text-align:center">{{ $u->id }}</td>

                {{-- User cell --}}
                <td>
                    <div style="display:flex;align-items:center;gap:.6rem;min-width:0">
                        <div style="
                            width:34px;height:34px;border-radius:50%;flex-shrink:0;
                            background:linear-gradient(135deg,rgba(198,146,74,.25),rgba(198,146,74,.08));
                            border:1px solid rgba(198,146,74,.2);
                            display:flex;align-items:center;justify-content:center;
                            font-family:'Amiri',serif;font-size:.95rem;color:var(--pl);
                        ">{{ mb_substr($u->name,0,1) }}</div>
                        <div style="min-width:0;overflow:hidden">
                            <div class="td-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $u->name }}
                                @if($u->is_admin)
                                    <span class="badge b-gold" style="font-size:.55rem;vertical-align:middle;margin-right:.2rem">ADMIN</span>
                                @endif
                            </div>
                            <div style="font-size:.69rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>

                {{-- Username --}}
                <td>
                    <span class="td-mono" style="direction:ltr;display:inline-block;background:rgba(90,143,194,.07);border:1px solid rgba(90,143,194,.15);border-radius:6px;padding:.12rem .45rem;font-size:.74rem">
                        {{ $u->username }}
                    </span>
                </td>

                {{-- Sent --}}
                <td style="text-align:center">
                    <span style="color:var(--p);font-weight:700;font-size:.88rem">{{ $u->sent_count }}</span>
                </td>

                {{-- Received --}}
                <td style="text-align:center">
                    <span style="color:var(--blue);font-weight:700;font-size:.88rem">{{ $u->received_count }}</span>
                </td>

                {{-- Reports --}}
                <td style="text-align:center">
                    @if($rep > 0)
                        <span class="badge {{ $rep >= 3 ? 'b-red' : 'b-yellow' }}" style="font-size:.7rem">
                            {{ $rep }} بلاغ
                        </span>
                    @else
                        <span style="color:var(--muted);font-size:.72rem">—</span>
                    @endif
                </td>

                {{-- Risk --}}
                <td>
                    <div style="display:flex;align-items:center;gap:.5rem">
                        <div style="flex:1;height:5px;background:rgba(255,255,255,.06);border-radius:3px;overflow:hidden;min-width:40px">
                            <div style="height:100%;background:{{ $riskColor }};width:{{ [$riskScore * 25 + 5, 100][($riskScore * 25 + 5) >= 100 ? 1 : 0] }}%;border-radius:3px;transition:width .3s"></div>
                        </div>
                        <span style="font-size:.67rem;color:{{ $riskColor }};white-space:nowrap;font-weight:600">{{ $riskLabel }}</span>
                    </div>
                </td>

                {{-- Date --}}
                <td class="td-muted" style="font-size:.73rem;white-space:nowrap">
                    {{ $u->created_at->format('Y/m/d') }}<br>
                    <span style="font-size:.64rem;opacity:.65">{{ $u->created_at->diffForHumans() }}</span>
                </td>

                {{-- Status --}}
                <td id="status-{{ $u->id }}">
                    @if($u->is_blocked)
                        <span class="badge b-red">🚫 محظور</span>
                    @elseif($rep >= 3)
                        <span class="badge b-orange">⚠️ مشبوه</span>
                    @elseif($u->is_admin)
                        <span class="badge b-gold">⭐ أدمن</span>
                    @else
                        <span class="badge b-green">● نشط</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td>
                    <div class="btn-acts" id="acts-{{ $u->id }}">
                        <a href="{{ route('profile.show', $u->username) }}" target="_blank"
                           class="act-btn ab-blue" title="عرض الصفحة">👁</a>

                        @if($u->is_blocked)
                            <button class="act-btn ab-green" onclick="toggleBlock({{ $u->id }}, false)">رفع الحظر</button>
                        @else
                            <button class="act-btn ab-yellow" title="تحذير" onclick="warnUser({{ $u->id }})">⚠️</button>
                            @if(!$u->is_admin || auth()->id() === $u->id)
                            <button class="act-btn ab-red" title="حظر" onclick="blockUser({{ $u->id }})">🚫</button>
                            @endif
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="padding:3.5rem 1rem;text-align:center">
                    <div style="font-size:2.4rem;margin-bottom:.8rem;opacity:.4">👥</div>
                    <div style="font-size:.88rem;color:var(--muted)">🎉 تمام! مفيش نتائج للفلتر المحدد</div>
                    <div style="font-size:.75rem;color:rgba(240,232,223,.25);margin-top:.3rem">جرّب تغيير الفلتر أو البحث</div>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pag">
        <span class="pag-info">
            @if($users->total() > 0)
                {{ $users->firstItem() }}–{{ $users->lastItem() }} من {{ number_format($users->total()) }} مستخدم
            @else
                لا توجد نتائج
            @endif
        </span>
        <div class="pag-links">{!! $users->links('admin.pagination') !!}</div>
    </div>
</div>

@endsection

@push('styles')
<style>
.row-blocked td { opacity:.6 }
</style>
@endpush

@push('scripts')
<script>
function toggleBlock(userId, block) {
    if (block) {
        showConfirm('🚫 حظر المستخدم', 'لن يتمكن من تسجيل الدخول أو إرسال رسائل.', '🚫', () => doBlock(userId, true));
    } else {
        doBlock(userId, false);
    }
}
function blockUser(userId) {
    showConfirm('🚫 حظر المستخدم', 'لن يتمكن من تسجيل الدخول أو إرسال رسائل.', '🚫', () => doBlock(userId, true));
}
function doBlock(userId, block) {
    adminAction(
        block ? `/admin/users/${userId}/block` : `/admin/users/${userId}/unblock`,
        'POST',
        () => {
            const row = document.getElementById('user-row-' + userId);
            const status = document.getElementById('status-' + userId);
            const acts   = document.getElementById('acts-' + userId);
            if (block) {
                row.classList.add('row-blocked');
                status.innerHTML = '<span class="badge b-red">🚫 محظور</span>';
                acts.innerHTML = `<button class="act-btn ab-green" onclick="toggleBlock(${userId},false)">رفع الحظر</button>`;
            } else {
                row.classList.remove('row-blocked');
                status.innerHTML = '<span class="badge b-green">● نشط</span>';
                acts.innerHTML = `<button class="act-btn ab-yellow" onclick="warnUser(${userId})">⚠️</button>
                    <button class="act-btn ab-red" onclick="blockUser(${userId})">🚫</button>`;
            }
        }
    );
}
function warnUser(userId) {
    adminAction(`/admin/users/${userId}/warn`, 'POST', () => {
        const row = document.getElementById('user-row-' + userId);
        if (row) { row.style.outline = '1px solid rgba(251,191,36,.3)'; setTimeout(() => row.style.outline = '', 2500); }
    });
}
</script>
@endpush
