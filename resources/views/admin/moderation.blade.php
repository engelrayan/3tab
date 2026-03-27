@extends('admin.layout')
@section('title', 'الإشراف')
@section('crumb', 'الإشراف')

@section('content')
<div class="grid2" style="margin-bottom:1.2rem">

    {{-- Custom blocked words --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">🚫 الكلمات المحظورة (مخصصة)</span>
            <span class="badge b-red">{{ count($customWords) }}</span>
        </div>
        <div class="card-body">
            <div style="display:flex;gap:.6rem;margin-bottom:1rem">
                <input id="new-word-inp" class="form-inp" type="text" placeholder="أضف كلمة محظورة..." style="flex:1" maxlength="40">
                <button class="act-btn ab-red" onclick="addWord()" style="padding:.6rem 1.1rem;font-size:.82rem">+ إضافة</button>
            </div>
            <div class="word-tags" id="custom-words-wrap">
                @forelse($customWords as $word)
                <span class="word-tag" id="word-{{ md5($word) }}">
                    {{ $word }}
                    <button class="word-tag-remove" onclick="removeWord('{{ $word }}', '{{ md5($word) }}')">✕</button>
                </span>
                @empty
                <span class="td-muted" style="font-size:.8rem">لا توجد كلمات مخصصة بعد</span>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Config words (read-only) --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">⚙️ الكلمات المحظورة (config)</span>
            <span class="badge b-muted">{{ count($configWords) }} · للقراءة فقط</span>
        </div>
        <div class="card-body">
            <p style="font-size:.75rem;color:var(--muted);margin-bottom:.75rem">هذه الكلمات محددة في <code style="color:var(--pl)">config/abuse.php</code> ولا يمكن تعديلها من هنا</p>
            <div class="word-tags">
                @foreach($configWords as $word)
                <span class="word-tag config-tag">{{ $word }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Flagged messages --}}
<div class="card">
    <div class="card-head">
        <span class="card-title">⚠️ الرسائل المشبوهة ({{ $flaggedAtabs->total() }})</span>
        <form method="GET" action="{{ route('admin.moderation') }}">
            <input class="search-inp" type="text" name="q" value="{{ request('q') }}" placeholder="🔍 بحث...">
        </form>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>المحتوى</th>
                    <th>المرسل</th>
                    <th>المستلم</th>
                    <th>بلاغات</th>
                    <th>التاريخ</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody id="flagged-tbody">
            @forelse($flaggedAtabs as $atab)
            <tr id="flagged-row-{{ $atab->id }}">
                <td style="max-width:260px">
                    <div style="font-size:.8rem;color:var(--soft);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ Str::limit($atab->messages()->first()?->body ?? '—', 60) }}
                    </div>
                </td>
                <td class="td-muted">
                    @if($atab->is_anonymous) 🎭 مجهول
                    @else {{ $atab->sender?->name ?? 'زائر' }}
                    @endif
                </td>
                <td class="td-name">{{ $atab->receiver?->name ?? '—' }}</td>
                <td style="text-align:center">
                    @php $rc = $atab->reports()->count() @endphp
                    @if($rc) <span class="badge b-red">{{ $rc }}</span>
                    @else <span class="td-muted">—</span>
                    @endif
                </td>
                <td class="td-muted">{{ $atab->created_at->format('m/d H:i') }}</td>
                <td>
                    <div class="btn-acts">
                        <button class="act-btn ab-green" onclick="modAction({{ $atab->id }}, 'unflag')">✓ إلغاء التحذير</button>
                        <button class="act-btn ab-red"   onclick="modAction({{ $atab->id }}, 'delete')">🗑️ حذف</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="6">🎉 لا توجد رسائل مشبوهة</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pag">
        <span class="pag-info">{{ $flaggedAtabs->total() }} رسالة مشبوهة</span>
        <div class="pag-links">{!! $flaggedAtabs->links('admin.pagination') !!}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function addWord() {
    const inp  = document.getElementById('new-word-inp');
    const word = inp.value.trim();
    if (!word) return;

    const r = await fetch('{{ route("admin.moderation.words.add") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: JSON.stringify({ word })
    });
    const d = await r.json();
    if (d.success) {
        aToast('✅ تمت الإضافة', 's');
        inp.value = '';
        renderWords(d.words);
    } else { aToast('⚠️ خطأ', 'e'); }
}

async function removeWord(word, hash) {
    const r = await fetch('{{ route("admin.moderation.words.remove") }}', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: JSON.stringify({ word })
    });
    const d = await r.json();
    if (d.success) {
        aToast('✅ تم الحذف', 's');
        renderWords(d.words);
    }
}

function renderWords(words) {
    const wrap = document.getElementById('custom-words-wrap');
    if (!words.length) { wrap.innerHTML = '<span class="td-muted" style="font-size:.8rem">لا توجد كلمات مخصصة بعد</span>'; return; }
    wrap.innerHTML = words.map(w => `
        <span class="word-tag" id="word-${hashCode(w)}">
            ${escHtml(w)}
            <button class="word-tag-remove" onclick="removeWord('${escHtml(w)}', '${hashCode(w)}')">✕</button>
        </span>
    `).join('');
}

function hashCode(str) { return btoa(encodeURIComponent(str)).replace(/[^a-zA-Z0-9]/g, '').slice(0, 8); }
function escHtml(s)    { return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

async function modAction(id, action) {
    if (action === 'delete' && !confirm('حذف الرسالة نهائياً؟')) return;
    const url    = action === 'delete' ? `/admin/moderation/atabs/${id}` : `/admin/moderation/unflag/${id}`;
    const method = action === 'delete' ? 'DELETE' : 'POST';
    await adminAction(url, method, () => document.getElementById('flagged-row-' + id)?.remove());
}

// Add word on Enter
document.getElementById('new-word-inp')?.addEventListener('keydown', e => { if (e.key === 'Enter') addWord(); });
</script>
@endpush
