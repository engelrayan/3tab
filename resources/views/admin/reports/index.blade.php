@extends('admin.layout')
@section('title', 'البلاغات')
@section('crumb', 'البلاغات')

@section('content')
<div class="card">
    <div class="filter-bar">
        <a href="{{ route('admin.reports') }}"                            class="filter-pill {{ !request('filter') ? 'active' : '' }}">الكل</a>
        <a href="{{ route('admin.reports', ['filter'=>'high']) }}"        class="filter-pill {{ request('filter')==='high' ? 'active' : '' }}">🔴 3+ بلاغات</a>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>محتوى العتاب</th>
                    <th>المرسل</th>
                    <th>المستلم</th>
                    <th>البلاغات</th>
                    <th>السبب (آخر بلاغ)</th>
                    <th>مشبوه</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($atabs as $atab)
            <tr id="rep-row-{{ $atab->id }}">
                <td style="max-width:250px">
                    <div style="font-size:.8rem;color:var(--soft);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ Str::limit($atab->messages()->first()?->body ?? '—', 60) }}
                    </div>
                </td>
                <td class="td-muted">
                    @if($atab->is_anonymous) 🎭 مجهول
                    @elseif($atab->sender_id) {{ $atab->sender?->name ?? '—' }}
                    @else زائر
                    @endif
                </td>
                <td class="td-name">{{ $atab->receiver?->name ?? '—' }}</td>
                <td style="text-align:center">
                    <span class="badge {{ $atab->reports_count >= 3 ? 'b-red' : 'b-yellow' }}">
                        {{ $atab->reports_count }}
                    </span>
                </td>
                <td class="td-muted" style="font-size:.75rem">
                    {{ $atab->reports->first()?->reason ?? '—' }}
                </td>
                <td>
                    @if($atab->is_flagged) <span class="badge b-yellow">⚠️ نعم</span>
                    @else <span class="badge b-muted">لا</span>
                    @endif
                </td>
                <td>
                    <div class="btn-acts">
                        <button class="act-btn ab-red"   onclick="repAction({{ $atab->id }}, 'delete')">🗑️ حذف</button>
                        <button class="act-btn ab-ghost" onclick="repAction({{ $atab->id }}, 'dismiss')">تجاهل</button>
                        @if($atab->sender_id && !$atab->is_anonymous)
                        <button class="act-btn ab-red"   onclick="repAction({{ $atab->id }}, 'block-sender')">🚫 حظر</button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="7">🎉 لا توجد بلاغات</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pag">
        <span class="pag-info">{{ $atabs->total() }} عتاب مُبلَّغ عنه</span>
        <div class="pag-links">{!! $atabs->links('admin.pagination') !!}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function repAction(id, action) {
    if (action === 'delete' && !confirm('حذف العتاب نهائياً؟')) return;
    const urls = {
        'delete':       `/admin/reports/${id}/delete-atab`,
        'dismiss':      `/admin/reports/${id}/dismiss`,
        'block-sender': `/admin/reports/${id}/block-sender`,
    };
    const methods = { delete: 'DELETE', dismiss: 'DELETE', 'block-sender': 'POST' };
    await adminAction(urls[action], methods[action], () => {
        if (action === 'delete') document.getElementById('rep-row-' + id)?.remove();
        else location.reload();
    });
}
</script>
@endpush
