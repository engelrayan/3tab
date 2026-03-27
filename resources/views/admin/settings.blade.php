@extends('admin.layout')
@section('title', 'الإعدادات')
@section('crumb', 'الإعدادات')

@section('content')
<div class="grid2">

    <div style="display:flex;flex-direction:column;gap:1.2rem">

        {{-- Sending settings --}}
        <div class="card">
            <div class="card-head"><span class="card-title">📨 إعدادات الإرسال</span></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.8rem">

                <div class="toggle-wrap">
                    <div>
                        <div class="toggle-label">🎭 السماح بالرسائل المجهولة</div>
                        <div class="toggle-sub">يسمح للمستخدمين بإرسال عتاب بدون ذكر اسمهم</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="allow_anonymous" {{ $settings['allow_anonymous'] ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="toggle-wrap">
                    <div>
                        <div class="toggle-label">🌍 السماح للزوار بالإرسال</div>
                        <div class="toggle-sub">يسمح للزوار غير المسجلين بإرسال عتاب</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" id="allow_guest_sending" {{ $settings['allow_guest_sending'] ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

            </div>
        </div>

        {{-- Rate limits --}}
        <div class="card">
            <div class="card-head"><span class="card-title">⏱️ حدود المعدل (Rate Limits)</span></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.9rem">

                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">رسائل الزوار — في الدقيقة</label>
                    <input class="form-inp" type="number" id="guest_rate_limit" value="{{ $settings['guest_rate_limit'] }}" min="1" max="100" style="max-width:160px">
                    <span style="font-size:.72rem;color:var(--muted)">الافتراضي: 5 رسائل/دقيقة لكل IP</span>
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">رسائل المسجّلين — في الدقيقة</label>
                    <input class="form-inp" type="number" id="auth_rate_limit" value="{{ $settings['auth_rate_limit'] }}" min="1" max="200" style="max-width:160px">
                    <span style="font-size:.72rem;color:var(--muted)">الافتراضي: 20 رسالة/دقيقة لكل مستخدم</span>
                </div>

            </div>
        </div>

        <div>
            <button class="btn-save" onclick="saveSettings()">💾 حفظ الإعدادات</button>
        </div>
    </div>

    {{-- System info --}}
    <div style="display:flex;flex-direction:column;gap:1.2rem">
        <div class="card">
            <div class="card-head"><span class="card-title">ℹ️ معلومات النظام</span></div>
            <div class="card-body">
                @php
                    $info = [
                        'إصدار Laravel'  => app()->version(),
                        'إصدار PHP'      => PHP_VERSION,
                        'البيئة'         => app()->environment(),
                        'قاعدة البيانات' => config('database.default'),
                        'Cache Driver'   => config('cache.default'),
                        'التاريخ'        => now()->format('Y-m-d H:i:s'),
                    ];
                @endphp
                @foreach($info as $k => $v)
                <div style="display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--b);font-size:.82rem">
                    <span style="color:var(--muted)">{{ $k }}</span>
                    <span style="color:var(--pl);font-family:monospace;font-size:.78rem">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-head"><span class="card-title">⚡ إجراءات سريعة</span></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem">
                <button class="act-btn ab-gold" onclick="clearCache()" style="justify-content:center;padding:.65rem">🗑️ مسح الكاش</button>
                <a href="{{ route('admin.moderation') }}" class="act-btn ab-ghost" style="text-align:center;display:block;padding:.65rem">🛡️ فتح الإشراف</a>
                <a href="{{ route('admin.reports') }}" class="act-btn ab-ghost" style="text-align:center;display:block;padding:.65rem">🚩 فتح البلاغات</a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
async function saveSettings() {
    const payload = {
        allow_anonymous:     document.getElementById('allow_anonymous').checked ? 1 : 0,
        allow_guest_sending: document.getElementById('allow_guest_sending').checked ? 1 : 0,
        guest_rate_limit:    parseInt(document.getElementById('guest_rate_limit').value) || 5,
        auth_rate_limit:     parseInt(document.getElementById('auth_rate_limit').value) || 20,
    };

    const r = await fetch('{{ route("admin.settings.update") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: JSON.stringify(payload)
    });
    const d = await r.json();
    aToast(d.message || (d.success ? '✅ تم الحفظ' : '⚠️ خطأ'), d.success ? 's' : 'e');
}

async function clearCache() {
    // Trigger a simple fetch to a non-existent endpoint is not ideal.
    // Instead, we inform the admin to run artisan cache:clear
    aToast('شغّل: php artisan cache:clear من الـ terminal', 'i');
}
</script>
@endpush
