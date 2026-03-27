@extends('admin.layout')
@section('title', 'الإحصائيات')
@section('crumb', 'الإحصائيات')

@section('content')

{{-- Mini stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.4rem">
    <div class="scard sc-users">
        <span style="font-size:1.2rem">👥</span>
        <span class="scard-val">{{ number_format($totalUsers) }}</span>
        <span class="scard-lbl">إجمالي المستخدمين</span>
        <span class="scard-delta">{{ $activeUsers }} نشيط</span>
    </div>
    <div class="scard sc-atabs">
        <span style="font-size:1.2rem">🎭</span>
        <span class="scard-val">{{ $anonCount }}</span>
        <span class="scard-lbl">رسائل مجهولة</span>
        <span class="scard-delta">{{ $namedCount }} برسالة مسمّاة</span>
    </div>
    <div class="scard sc-rec">
        <span style="font-size:1.2rem">📩</span>
        <span class="scard-val">{{ $guestCount }}</span>
        <span class="scard-lbl">رسائل الزوار</span>
        <span class="scard-delta">{{ $authCount }} من مسجّلين</span>
    </div>
    <div class="scard sc-flag">
        <span style="font-size:1.2rem">📊</span>
        <span class="scard-val">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0 }}%</span>
        <span class="scard-lbl">معدل النشاط</span>
        <span class="scard-delta">active / total</span>
    </div>
</div>

<div class="grid2" style="margin-bottom:1.2rem">

    {{-- Users per day --}}
    <div class="card">
        <div class="card-head"><span class="card-title">👥 تسجيلات يومية (30 يوم)</span></div>
        <div class="chart-wrap"><canvas id="users-chart"></canvas></div>
    </div>

    {{-- Atabs per day --}}
    <div class="card">
        <div class="card-head"><span class="card-title">💬 عتابات يومية (30 يوم)</span></div>
        <div class="chart-wrap"><canvas id="atabs-chart"></canvas></div>
    </div>
</div>

<div class="grid3">

    {{-- Anonymous pie --}}
    <div class="card">
        <div class="card-head"><span class="card-title">🎭 مجهول vs مسمّى</span></div>
        <div class="chart-wrap" style="height:200px"><canvas id="anon-chart"></canvas></div>
    </div>

    {{-- Status distribution --}}
    <div class="card">
        <div class="card-head"><span class="card-title">📊 توزيع الحالات</span></div>
        <div class="chart-wrap" style="height:200px"><canvas id="status-chart"></canvas></div>
    </div>

    {{-- Top receivers --}}
    <div class="card">
        <div class="card-head"><span class="card-title">🏆 الأكثر استقبالاً</span></div>
        <div class="card-body" style="padding:.8rem 1.2rem">
            @foreach($topReceivers as $u)
            <div style="display:flex;align-items:center;gap:.8rem;padding:.5rem 0;border-bottom:1px solid var(--b)">
                <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--pl),var(--rose));display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:.85rem;color:var(--dark2);font-weight:700;flex-shrink:0">{{ mb_substr($u->name, 0, 1) }}</div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:.82rem;font-weight:600;color:var(--text);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $u->name }}</div>
                    <div style="font-size:.68rem;color:var(--muted)">{{ $u->username }}</div>
                </div>
                <span class="badge b-gold">{{ $u->received_count }}</span>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const labels = @json($labels);
const userData = @json($userData);
const atabData = @json($atabData);

const chartDefaults = {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { grid: { color: 'rgba(198,146,74,.05)' }, ticks: { color: 'rgba(245,237,228,.35)', font: { family: 'Tajawal', size: 10 }, maxTicksLimit: 8 } },
        y: { grid: { color: 'rgba(198,146,74,.05)' }, ticks: { color: 'rgba(245,237,228,.35)', font: { family: 'Tajawal', size: 10 } }, beginAtZero: true }
    }
};

new Chart(document.getElementById('users-chart'), {
    type: 'line',
    data: { labels, datasets: [{ data: userData, borderColor: '#5A8FC2', backgroundColor: 'rgba(90,143,194,.12)', borderWidth: 2, tension: 0.4, fill: true, pointRadius: 2 }] },
    options: chartDefaults
});

new Chart(document.getElementById('atabs-chart'), {
    type: 'line',
    data: { labels, datasets: [{ data: atabData, borderColor: '#C6924A', backgroundColor: 'rgba(198,146,74,.12)', borderWidth: 2, tension: 0.4, fill: true, pointRadius: 2 }] },
    options: chartDefaults
});

new Chart(document.getElementById('anon-chart'), {
    type: 'doughnut',
    data: {
        labels: ['مجهول', 'مسمّى'],
        datasets: [{ data: [{{ $anonCount }}, {{ $namedCount }}], backgroundColor: ['rgba(198,146,74,.6)', 'rgba(90,143,194,.6)'], borderColor: ['rgba(198,146,74,.8)', 'rgba(90,143,194,.8)'], borderWidth: 1 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { color: 'rgba(245,237,228,.5)', font: { family: 'Tajawal' }, padding: 12 } } }
    }
});

const statusLabels = @json(array_keys($statusDist));
const statusData   = @json(array_values($statusDist));
const statusColors = { pending: 'rgba(198,146,74,.6)', active: 'rgba(90,143,194,.6)', reconciled: 'rgba(122,158,142,.6)', closed: 'rgba(245,237,228,.2)' };

new Chart(document.getElementById('status-chart'), {
    type: 'doughnut',
    data: {
        labels: statusLabels.map(s => s === 'pending' ? 'انتظار' : s === 'active' ? 'نشط' : s === 'reconciled' ? 'مصالحة' : 'مغلق'),
        datasets: [{ data: statusData, backgroundColor: statusLabels.map(s => statusColors[s] || 'rgba(245,237,228,.2)'), borderWidth: 1 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { color: 'rgba(245,237,228,.5)', font: { family: 'Tajawal' }, padding: 10 } } }
    }
});
</script>
@endpush
