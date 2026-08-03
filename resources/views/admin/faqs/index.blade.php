@extends('layouts.admin')

@section('title', 'FAQ Manager')
@section('page_title', 'FAQ Manager')
@section('page_subtitle', 'Create, update, and organize frequently asked questions.')

@push('styles')
<style>
    .card { box-shadow: 0 4px 12px rgba(0,0,0,.02); }
    th.sortable { cursor: pointer; user-select: none; }
    th.sortable:hover { color: var(--navy); }
    .sort-icon { opacity: .3; transition: opacity .15s, transform .15s; }
    th.sort-asc .sort-icon { opacity: 1; transform: rotate(0deg); }
    th.sort-desc .sort-icon { opacity: 1; transform: rotate(180deg); }
    tr.row-selected { background: rgba(122,185,236,.10); }
    .checkbox { accent-color: var(--navy); }
    #bulkBar { transition: transform .25s ease, opacity .25s ease; }
    .input-field { transition: all .18s ease; }
    .input-field:focus { border-color: var(--sky); box-shadow: 0 0 0 4px rgba(122,185,236,.25); outline: none; }
    #modalPanel { transition: transform .2s ease, opacity .2s ease; transform: scale(.95); opacity: 0; }
    #modalPanel.scale-100 { transform: scale(1); opacity: 1; }
</style>
@endpush

@section('content')
    @php
        $openModal = $selectedFaq || $errors->any();
        $isEditing = (bool) $selectedFaq;
        $formFaq = $selectedFaq ?? new \App\Models\Faq(['category' => 'General', 'status' => 'Published']);
        $queryParameters = request()->only('search', 'status', 'category', 'sort', 'direction', 'page');
        $closeModalUrl = route('admin.faqs.index', $queryParameters);
        $statusStyles = ['Published' => 'bg-emerald-50 text-emerald-600', 'Draft' => 'bg-amber-50 text-amber-600', 'Archived' => 'bg-rose-50 text-rose-600'];
        $categoryStyles = ['General' => 'bg-slate-100 text-slate-600', 'Billing' => 'bg-[#E9F2FC] text-[var(--navy)]', 'Technical' => 'bg-[#EAEAF9] text-[#1D2B62]'];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Total FAQs</p><p class="text-xl font-display font-bold text-[var(--navy)] mt-1">{{ number_format($stats['total']) }}</p></div>
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Published</p><p class="text-xl font-display font-bold text-emerald-600 mt-1">{{ number_format($stats['published']) }}</p></div>
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Draft</p><p class="text-xl font-display font-bold text-amber-600 mt-1">{{ number_format($stats['draft']) }}</p></div>
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Archived</p><p class="text-xl font-display font-bold text-rose-600 mt-1">{{ number_format($stats['archived']) }}</p></div>
    </div>

    <div class="card overflow-hidden">
        <form id="filterForm" method="GET" action="{{ route('admin.faqs.index') }}" class="p-4 sm:p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input name="search" value="{{ request('search') }}" placeholder="Search questions or answers..." class="w-full bg-[#F1F4F8] rounded-lg pl-10 pr-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-[var(--sky)] placeholder:text-slate-400" />
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <select name="status" onchange="this.form.submit()" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white">
                    <option value="">All statuses</option>
                    @foreach (['Published', 'Draft', 'Archived'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <select name="category" onchange="this.form.submit()" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.faqs.index') }}" class="text-sm font-medium text-slate-400 hover:text-[var(--navy)] px-2">Clear</a>
            </div>
            <input type="hidden" name="sort" value="{{ $sort }}"><input type="hidden" name="direction" value="{{ $direction }}">
            <div class="lg:ml-auto flex items-center gap-2">
                <a href="{{ route('admin.faqs.export', request()->only('search', 'status', 'category')) }}" class="flex items-center gap-2 border border-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-slate-50 transition"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>Export</a>
                <button type="button" onclick="openModal()" class="flex items-center gap-2 grad-a text-white text-sm font-semibold px-4 py-2.5 rounded-lg glow hover:opacity-90 transition"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Add FAQ</button>
            </div>
        </form>

        <div id="bulkBar" class="hidden items-center gap-4 px-5 py-3 bg-[#EAF3FC] border-b border-[#D6E7F7] text-sm">
            <span class="font-semibold text-[var(--navy)]"><span id="selectedCount">0</span> selected</span>
            <button type="button" onclick="submitBulkAction('archive')" class="text-slate-600 hover:text-[var(--navy)] font-medium flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v4H4z"/><path d="M4 8v12h16V8"/><path d="M9 12h6"/></svg>Archive</button>
            <button type="button" onclick="submitBulkAction('delete')" class="text-rose-500 hover:text-rose-600 font-medium flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg>Delete</button>
            <button type="button" onclick="clearSelection()" class="ml-auto text-slate-400 hover:text-slate-600" aria-label="Clear selection"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
        </div>

        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full text-sm min-w-[860px]">
                <thead><tr class="text-left text-slate-400 border-b border-slate-100 bg-[#FBFCFD]">
                    <th class="py-3 pl-5 pr-2 w-10"><input type="checkbox" id="selectAll" class="checkbox w-4 h-4 rounded" /></th>
                    @foreach (['question' => 'Question', 'category' => 'Category', 'status' => 'Status', 'created' => 'Created'] as $key => $label)
                        @php $nextDirection = $sort === $key && $direction === 'asc' ? 'desc' : 'asc'; @endphp
                        <th class="sortable font-medium py-3 pr-4 {{ $sort === $key ? 'sort-'.$direction : '' }}"><a href="{{ route('admin.faqs.index', array_merge($queryParameters, ['sort' => $key, 'direction' => $nextDirection])) }}" class="inline-flex items-center gap-1">{{ $label }}<svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg></a></th>
                    @endforeach
                    <th class="font-medium py-3 pr-5 text-right">Actions</th>
                </tr></thead>
                <tbody>
                    @forelse ($faqs as $faq)
                        <tr class="faq-row border-b border-slate-50 last:border-0 hover:bg-[#F8FAFD] transition" data-id="{{ $faq->id }}">
                            <td class="py-3 pl-5 pr-2"><input type="checkbox" class="checkbox row-check w-4 h-4 rounded" value="{{ $faq->id }}" /></td>
                            <td class="py-3 pr-4"><div class="min-w-0"><p class="font-medium text-slate-700 truncate">{{ $faq->question }}</p><p class="text-xs text-slate-400 truncate">{{ $faq->answer }}</p></div></td>
                            <td class="py-3 pr-4"><span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $categoryStyles[$faq->category] ?? 'bg-slate-100 text-slate-600' }}">{{ $faq->category }}</span></td>
                            <td class="py-3 pr-4">
                                <form method="POST" action="{{ route('admin.faqs.status', $faq) }}">@csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs font-semibold px-2.5 py-1 rounded-full border-0 outline-none cursor-pointer {{ $statusStyles[$faq->status] }}"><option value="Published" @selected($faq->status === 'Published')>Published</option><option value="Draft" @selected($faq->status === 'Draft')>Draft</option><option value="Archived" @selected($faq->status === 'Archived')>Archived</option></select>
                                </form>
                            </td>
                            <td class="py-3 pr-4 text-slate-500">{{ $faq->created_at?->format('M j, Y') }}</td>
                            <td class="py-3 pr-5 text-right"><div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.faqs.edit', array_merge([$faq], $queryParameters)) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-[var(--navy)] hover:bg-slate-100" title="Edit"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg></a>
                                <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Are you sure you want to delete this FAQ? This action cannot be undone.');">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50" title="Delete"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg></button></form>
                            </div></td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($faqs->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" class="mb-3"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg><p class="font-semibold text-slate-500">No FAQs match your filters</p><p class="text-sm text-slate-400 mt-1">Try a different search term or clear filters.</p></div>
        @endif

        <div class="flex flex-col sm:flex-row items-center gap-3 justify-between px-5 py-4 border-t border-slate-100">
            <div class="text-sm text-slate-500">@if ($faqs->total()) Showing {{ $faqs->firstItem() }}–{{ $faqs->lastItem() }} of {{ $faqs->total() }} @else No results @endif</div>
            <div>{{ $faqs->onEachSide(1)->links() }}</div>
        </div>
    </div>

    <form id="bulkForm" method="POST" action="{{ route('admin.faqs.bulk-action') }}" class="hidden">@csrf<input type="hidden" name="action" id="bulkAction"></form>

    <div id="modalOverlay" class="{{ $openModal ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div id="modalPanel" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl {{ $openModal ? 'scale-100' : 'scale-95 opacity-0' }}">
            <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-slate-100"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><div><h3 class="font-display font-bold text-lg text-[var(--navy)]">{{ $isEditing ? 'Edit FAQ' : 'Add FAQ' }}</h3><p class="text-sm text-slate-500">Create or update a frequently asked question.</p></div></div><button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 p-1"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button></div>
            <form method="POST" action="{{ $isEditing ? route('admin.faqs.update', $formFaq) : route('admin.faqs.store') }}" novalidate>
                @csrf @if ($isEditing) @method('PUT') @endif
                <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto scrollbar-thin">
                    <div><label for="faqQuestion" class="text-sm font-medium text-slate-600">Question</label><input id="faqQuestion" name="question" type="text" value="{{ old('question', $formFaq->question) }}" placeholder="What is NOVA?" class="input-field mt-1.5 w-full border {{ $errors->has('question') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none" />@error('question')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                    <div><label for="faqAnswer" class="text-sm font-medium text-slate-600">Answer</label><textarea id="faqAnswer" name="answer" rows="5" placeholder="NOVA is an EV transport platform..." class="input-field mt-1.5 w-full border {{ $errors->has('answer') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none resize-none">{{ old('answer', $formFaq->answer) }}</textarea>@error('answer')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div>
                    <div class="grid grid-cols-2 gap-4"><div><label for="faqCategory" class="text-sm font-medium text-slate-600">Category</label><input id="faqCategory" name="category" list="faqCategories" value="{{ old('category', $formFaq->category) }}" class="input-field mt-1.5 w-full border {{ $errors->has('category') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white" /><datalist id="faqCategories"><option value="General"><option value="Billing"><option value="Technical">@foreach ($categories as $category)<option value="{{ $category }}">@endforeach</datalist>@error('category')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div><div><label for="faqStatus" class="text-sm font-medium text-slate-600">Status</label><select id="faqStatus" name="status" class="input-field mt-1.5 w-full border {{ $errors->has('status') ? 'border-rose-400' : 'border-slate-200' }} rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white">@foreach (['Published', 'Draft', 'Archived'] as $status)<option value="{{ $status }}" @selected(old('status', $formFaq->status) === $status)>{{ $status }}</option>@endforeach</select>@error('status')<p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>@enderror</div></div>
                </div>
                <div class="flex items-center gap-3 px-6 py-4 border-t border-slate-100 bg-[#FBFCFD] rounded-b-2xl"><button type="button" onclick="closeModal()" class="flex-1 border border-slate-200 text-slate-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-slate-50 transition">Cancel</button><button type="submit" class="flex-1 grad-a text-white text-sm font-semibold py-2.5 rounded-xl glow hover:opacity-90 transition">{{ $isEditing ? 'Save changes' : 'Add FAQ' }}</button></div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const modalOverlay = document.getElementById('modalOverlay');
    const modalPanel = document.getElementById('modalPanel');
    const selectedFaqIds = new Set();

    function openModal() { modalOverlay.classList.remove('hidden'); modalOverlay.classList.add('flex'); document.body.classList.add('overflow-hidden'); requestAnimationFrame(() => { modalPanel.classList.add('scale-100'); modalPanel.classList.remove('opacity-0'); }); setTimeout(() => document.getElementById('faqQuestion').focus(), 150); }
    function closeModal() { modalPanel.classList.remove('scale-100'); modalPanel.classList.add('opacity-0'); document.body.classList.remove('overflow-hidden'); setTimeout(() => { window.location.href = @json($closeModalUrl); }, 180); }
    modalOverlay.addEventListener('click', event => { if (event.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown', event => { if (event.key === 'Escape' && !modalOverlay.classList.contains('hidden')) closeModal(); });

    function refreshBulkBar() { const bar = document.getElementById('bulkBar'); document.getElementById('selectedCount').textContent = selectedFaqIds.size; bar.classList.toggle('hidden', selectedFaqIds.size === 0); bar.classList.toggle('flex', selectedFaqIds.size > 0); document.querySelectorAll('.faq-row').forEach(row => row.classList.toggle('row-selected', selectedFaqIds.has(row.dataset.id))); const checks = [...document.querySelectorAll('.row-check')]; const selectAll = document.getElementById('selectAll'); selectAll.checked = checks.length > 0 && checks.every(check => check.checked); selectAll.indeterminate = !selectAll.checked && checks.some(check => check.checked); }
    document.querySelectorAll('.row-check').forEach(check => check.addEventListener('change', function () { this.checked ? selectedFaqIds.add(this.value) : selectedFaqIds.delete(this.value); refreshBulkBar(); }));
    document.getElementById('selectAll').addEventListener('change', function () { document.querySelectorAll('.row-check').forEach(check => { check.checked = this.checked; this.checked ? selectedFaqIds.add(check.value) : selectedFaqIds.delete(check.value); }); refreshBulkBar(); });
    function clearSelection() { selectedFaqIds.clear(); document.querySelectorAll('.row-check').forEach(check => check.checked = false); refreshBulkBar(); }
    function submitBulkAction(action) { if (action === 'delete' && !confirm('Are you sure you want to delete the selected FAQs? This action cannot be undone.')) return; const form = document.getElementById('bulkForm'); form.querySelectorAll('input[name="ids[]"]').forEach(input => input.remove()); selectedFaqIds.forEach(id => { const input = document.createElement('input'); input.type = 'hidden'; input.name = 'ids[]'; input.value = id; form.appendChild(input); }); document.getElementById('bulkAction').value = action; form.submit(); }
    @if (session('success')) showToast(@json(session('success'))); @endif
    @if ($openModal) document.addEventListener('DOMContentLoaded', () => { document.body.classList.add('overflow-hidden'); }); @endif
</script>
@endpush
