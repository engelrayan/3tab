@extends('admin.layout')
@section('title', 'العتابات')
@section('crumb', 'العتابات')

@section('content')
<div class="card">
    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.atabs') }}" style="display:contents">
            <input class="search-inp" type="text" name="q" value="{{ request('q') }}" placeholder="🔍 ابحث في محتوى الرسائل...">
            <a href="{{ route('admin.atabs') }}"                               class="filter-pill {{ !request('filter') ? 'active' : '' }}">الكل ({{ $atabs->total() }})</a>
            <a href="{{ route('admin.atabs', ['filter'=>'flagged']) }}"         class="filter-pill {{ request('filter')==='flagged'   ? 'active' : '' }}">⚠️ مشبوهة</a>
            <a href="{{ route('admin.atabs', ['filter'=>'reported']) }}"        class="filter-pill {{ request('filter')==='reported'  ? 'active' : '' }}">🚩 مُبلَّغ</a>
            <a href="{{ route('admin.atabs', ['filter'=>'anonymous']) }}"       class="filter-pill {{ request('filter')==='anonymous' ? 'active' : '' }}">🎭 مجهول</a>
        </form>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>المحتوى</th>
                    <th>المرسل</th>
                    <th>المستلم</th>
                    <th>الحالة</th>
                    <th>بلاغات</th>
                    <th>التاريخ</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($atabs as $atab)
            <tr id="atab-row-{{ $atab->id }}">
                <td class="td-muted">{{ $atab->id }}</td>
                <td style="max-width:220px">
                    <div style="font-size:.8rem;color:var(--soft);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ Str::limit($atab->messages()->first()?->body ?? '—', 55) }}
                    </div>
                    @if($atab->is_flagged)
                        <span class="badge b-yellow" style="margin-top:.3rem">⚠️ مشبوه</span>
                    @endif
                </td>
                <td class="td-muted">
                    @if($atab->is_anonymous) 🎭 مجهول
                    @elseif($atab->sender) {{ $atab->sender->name }}
                    @else <span style="color:var(--muted)">زائر</span>
                    @endif
                </td>
                <td class="td-name">{{ $atab->receiver?->name ?? '—' }}</td>
                <td>
                    @php $s = $atab->status @endphp
                    @if($s==='reconciled') <span class="badge b-sage">🤝 مصالحة</span>
                    @elseif($s==='active')  <span class="badge b-blue">💬 نشط</span>
                    @elseif($s==='closed')  <span class="badge b-muted">🔒 مغلق</span>
                    @else                   <span class="badge b-gold">⏳ انتظار</span>
                    @endif
                </td>
                <td style="text-align:center">
                    @if($atab->reports_count > 0)
                        <span class="badge b-red">{{ $atab->reports_count }}</span>
                    @else
                        <span class="td-muted">—</span>
                    @endif
                </td>
                <td class="td-muted">{{ $atab->created_at->format('m/d H:i') }}</td>
                <td>
                    <div class="btn-acts">
                        @if($atab->is_flagged)
                            <button class="act-btn ab-green" onclick="atabAction({{ $atab->id }}, 'unflag')">✓ إلغاء</button>
                        @else
                            <button class="act-btn ab-gold"  onclick="atabAction({{ $atab->id }}, 'flag')">⚠️ تحذير</button>
                        @endif
                        <button class="act-btn ab-red" onclick="atabAction({{ $atab->id }}, 'delete')">🗑️</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="8">لا توجد عتابات</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pag">
        <span class="pag-info">{{ $atabs->firstItem() }}–{{ $atabs->lastItem() }} من {{ $atabs->total() }}</span>
        <div class="pag-links">{!! $atabs->links('admin.pagination') !!}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function atabAction(id, action) {
    if (action === 'delete' && !confirm('حذف العتاب نهائياً؟')) return;
    const methods = { delete: 'DELETE', flag: 'POST', unflag: 'POST' };
    const urls    = {
        delete: `/admin/atabs/${id}`,
        flag:   `/admin/atabs/${id}/flag`,
        unflag: `/admin/atabs/${id}/unflag`,
    };
    await adminAction(urls[action], methods[action], () => {
        if (action === 'delete') {
            document.getElementById('atab-row-' + id)?.remove();
        } else {
            location.reload();
        }
    });
}
</script>
@endpush
