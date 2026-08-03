@extends('layouts.admin')

@section('title', 'Subscriptions')
@section('page_title', 'Subscriptions')
@section('page_subtitle', 'Manage newsletter subscribers and exports.')

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
</style>
@endpush

@section('content')
    @php $queryParameters = request()->only('search', 'period', 'sort', 'direction', 'page'); @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Total Subscribers</p><p class="text-xl font-display font-bold text-[var(--navy)] mt-1">{{ number_format($stats['total']) }}</p></div>
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">Today</p><p class="text-xl font-display font-bold text-sky-600 mt-1">{{ number_format($stats['today']) }}</p></div>
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">This Week</p><p class="text-xl font-display font-bold text-emerald-600 mt-1">{{ number_format($stats['week']) }}</p></div>
        <div class="card p-4"><p class="text-xs text-slate-400 font-medium">This Month</p><p class="text-xl font-display font-bold text-amber-600 mt-1">{{ number_format($stats['month']) }}</p></div>
    </div>

    <div class="card overflow-hidden">
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="p-4 sm:p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center gap-3">
            <div class="relative flex-1 max-w-sm"><svg class="absolute left-3.5 top-1/2 -translate-y-1/2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg><input name="search" value="{{ request('search') }}" placeholder="Search by email..." class="w-full bg-[#F1F4F8] rounded-lg pl-10 pr-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-[var(--sky)] placeholder:text-slate-400" /></div>
            <div class="flex items-center gap-2 flex-wrap"><select name="period" onchange="this.form.submit()" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white"><option value="">All time</option><option value="today" @selected(request('period') === 'today')>Today</option><option value="week" @selected(request('period') === 'week')>This week</option><option value="month" @selected(request('period') === 'month')>This month</option></select><a href="{{ route('admin.subscriptions.index') }}" class="text-sm font-medium text-slate-400 hover:text-[var(--navy)] px-2">Clear</a></div>
            <input type="hidden" name="sort" value="{{ $sort }}"><input type="hidden" name="direction" value="{{ $direction }}">
            <div class="lg:ml-auto"><a href="{{ route('admin.subscriptions.export', request()->only('search', 'period')) }}" class="flex items-center gap-2 border border-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-slate-50 transition"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>Export CSV</a></div>
        </form>

        <div id="bulkBar" class="hidden items-center gap-4 px-5 py-3 bg-[#EAF3FC] border-b border-[#D6E7F7] text-sm"><span class="font-semibold text-[var(--navy)]"><span id="selectedCount">0</span> selected</span><button type="button" onclick="submitBulkDelete()" class="text-rose-500 hover:text-rose-600 font-medium flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14z"/></svg>Delete</button><button type="button" onclick="clearSelection()" class="ml-auto text-slate-400 hover:text-slate-600" aria-label="Clear selection"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button></div>

        <div class="overflow-x-auto scrollbar-thin"><table class="w-full text-sm min-w-[800px]"><thead><tr class="text-left text-slate-400 border-b border-slate-100 bg-[#FBFCFD]"><th class="py-3 pl-5 pr-2 w-10"><input type="checkbox" id="selectAll" class="checkbox w-4 h-4 rounded" /></th>
            @foreach (['email' => 'Email', 'date' => 'Date', 'time' => 'Time'] as $key => $label)
                @php $nextDirection = $sort === $key && $direction === 'asc' ? 'desc' : 'asc'; @endphp
                <th class="sortable font-medium py-3 pr-4 {{ $sort === $key ? 'sort-'.$direction : '' }}"><a href="{{ route('admin.subscriptions.index', array_merge($queryParameters, ['sort' => $key, 'direction' => $nextDirection])) }}" class="inline-flex items-center gap-1">{{ $label }}<svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg></a></th>
            @endforeach
            <th class="font-medium py-3 pr-5 text-right">Actions</th></tr></thead><tbody>
            @forelse ($subscriptions as $subscription)
                <tr class="subscription-row border-b border-slate-50 last:border-0 hover:bg-[#F8FAFD] transition" data-id="{{ $subscription->id }}"><td class="py-3 pl-5 pr-2"><input type="checkbox" class="checkbox row-check w-4 h-4 rounded" value="{{ $subscription->id }}" /></td><td class="py-3 pr-4 font-medium text-slate-700">{{ $subscription->email }}</td><td class="py-3 pr-4 text-slate-500">{{ $subscription->subscribed_at?->format('M j, Y') }}</td><td class="py-3 pr-4 text-slate-500">{{ $subscription->subscribed_at?->format('g:i A') }}</td><td class="py-3 pr-5 text-right"><form method="POST" action="{{ route('admin.subscriptions.destroy', $subscription) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this subscriber? This action cannot be undone.');">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50" title="Delete"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg></button></form></td></tr>
            @empty
            @endforelse
        </tbody></table></div>

        @if ($subscriptions->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" class="mb-3"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg><p class="font-semibold text-slate-500">No subscribers found</p><p class="text-sm text-slate-400 mt-1">Try a different search term or clear filters.</p></div>
        @endif
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-between px-5 py-4 border-t border-slate-100"><div class="text-sm text-slate-500">@if ($subscriptions->total()) Showing {{ $subscriptions->firstItem() }}–{{ $subscriptions->lastItem() }} of {{ $subscriptions->total() }} @else No results @endif</div><div>{{ $subscriptions->onEachSide(1)->links() }}</div></div>
    </div>

    <form id="bulkDeleteForm" method="POST" action="{{ route('admin.subscriptions.bulk-delete') }}" class="hidden">@csrf</form>
@endsection

@push('scripts')
<script>
    const selectedSubscriptionIds = new Set();
    function refreshBulkBar() { const bar = document.getElementById('bulkBar'); document.getElementById('selectedCount').textContent = selectedSubscriptionIds.size; bar.classList.toggle('hidden', selectedSubscriptionIds.size === 0); bar.classList.toggle('flex', selectedSubscriptionIds.size > 0); document.querySelectorAll('.subscription-row').forEach(row => row.classList.toggle('row-selected', selectedSubscriptionIds.has(row.dataset.id))); const checks = [...document.querySelectorAll('.row-check')]; const selectAll = document.getElementById('selectAll'); selectAll.checked = checks.length > 0 && checks.every(check => check.checked); selectAll.indeterminate = !selectAll.checked && checks.some(check => check.checked); }
    document.querySelectorAll('.row-check').forEach(check => check.addEventListener('change', function () { this.checked ? selectedSubscriptionIds.add(this.value) : selectedSubscriptionIds.delete(this.value); refreshBulkBar(); }));
    document.getElementById('selectAll').addEventListener('change', function () { document.querySelectorAll('.row-check').forEach(check => { check.checked = this.checked; this.checked ? selectedSubscriptionIds.add(check.value) : selectedSubscriptionIds.delete(check.value); }); refreshBulkBar(); });
    function clearSelection() { selectedSubscriptionIds.clear(); document.querySelectorAll('.row-check').forEach(check => check.checked = false); refreshBulkBar(); }
    function submitBulkDelete() { if (!confirm('Are you sure you want to delete the selected subscribers? This action cannot be undone.')) return; const form = document.getElementById('bulkDeleteForm'); form.querySelectorAll('input[name="ids[]"]').forEach(input => input.remove()); selectedSubscriptionIds.forEach(id => { const input = document.createElement('input'); input.type = 'hidden'; input.name = 'ids[]'; input.value = id; form.appendChild(input); }); form.submit(); }
    @if (session('success')) showToast(@json(session('success'))); @endif
</script>
@endpush
