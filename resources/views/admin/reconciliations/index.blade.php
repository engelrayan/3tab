@extends('admin.layout')
@section('title', 'المصالحات')
@section('crumb', 'المصالحات')

@section('content')
<div class="card">
    <div class="filter-bar">
        <a href="{{ route('admin.reconciliations') }}"                              class="filter-pill {{ !request('filter') ? 'active' : '' }}">الكل</a>
        <a href="{{ route('admin.reconciliations', ['filter'=>'requested']) }}"     class="filter-pill {{ request('filter')==='requested' ? 'active' : '' }}">⏳ في الانتظار</a>
        <a href="{{ route('admin.reconciliations', ['filter'=>'accepted']) }}"      class="filter-pill {{ request('filter')==='accepted'  ? 'active' : '' }}">✅ مقبولة</a>
        <a href="{{ route('admin.reconciliations', ['filter'=>'rejected']) }}"      class="filter-pill {{ request('filter')==='rejected'  ? 'active' : '' }}">❌ مرفوضة</a>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الطرف الأول</th>
                    <th>الطرف الثاني</th>
                    <th>طلب بواسطة</th>
                    <th>حالة الطلب</th>
                    <th>حالة العتاب</th>
                    <th>تاريخ الطلب</th>
                    <th>تاريخ التأكيد</th>
                </tr>
            </thead>
            <tbody>
            @forelse($atabs as $atab)
            <tr>
                <td class="td-muted">{{ $atab->id }}</td>
                <td class="td-name">{{ $atab->sender?->name ?? '🎭 مجهول' }}</td>
                <td class="td-name">{{ $atab->receiver?->name ?? '—' }}</td>
                <td class="td-muted">{{ $atab->reconciliationRequester?->name ?? '—' }}</td>
                <td>
                    @php $rs = $atab->reconciliation_status @endphp
                    @if($rs==='requested') <span class="badge b-gold">⏳ في الانتظار</span>
                    @elseif($rs==='accepted') <span class="badge b-green">✅ مقبول</span>
                    @elseif($rs==='rejected') <span class="badge b-red">❌ مرفوض</span>
                    @else <span class="badge b-muted">—</span>
                    @endif
                </td>
                <td>
                    @if($atab->status === 'reconciled') <span class="badge b-sage">🤝 مصالحة</span>
                    @elseif($atab->status === 'active')  <span class="badge b-blue">💬 نشط</span>
                    @else <span class="badge b-muted">{{ $atab->status }}</span>
                    @endif
                </td>
                <td class="td-muted">{{ $atab->reconciliation_requested_at?->format('Y/m/d H:i') ?? '—' }}</td>
                <td class="td-muted">{{ $atab->reconciliation_confirmed_at?->format('Y/m/d H:i') ?? '—' }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="8">لا توجد طلبات مصالحة</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pag">
        <span class="pag-info">{{ $atabs->total() }} طلب</span>
        <div class="pag-links">{!! $atabs->links('admin.pagination') !!}</div>
    </div>
</div>
@endsection
