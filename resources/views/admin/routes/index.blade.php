@extends('layouts.admin')

@section('title', 'Routes')
@section('page_title', 'Route Management')
@section('page_subtitle', 'Create, edit, and track your route network.')

@section('content')

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Total Routes</p>
            <p class="text-xl font-display font-bold text-[var(--navy)] mt-1">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Active</p>
            <p class="text-xl font-display font-bold text-emerald-600 mt-1">{{ $stats['active'] ?? 0 }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Inactive</p>
            <p class="text-xl font-display font-bold text-rose-600 mt-1">{{ $stats['inactive'] ?? 0 }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Pending</p>
            <p class="text-xl font-display font-bold text-amber-600 mt-1">{{ $stats['pending'] ?? 0 }}</p>
        </div>
    </div>

    <div class="card overflow-hidden">

        {{-- Filters / search --}}
        <form method="GET" action="{{ route('admin.routes.index') }}" class="p-4 sm:p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search route, origin or destination…" class="w-full bg-[#F1F4F8] rounded-lg pl-10 pr-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-[var(--sky)] placeholder:text-slate-400" />
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white" onchange="this.form.submit()">
                    <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All statuses</option>
                    @foreach (['Active', 'Inactive', 'Pending'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                    @endforeach
                </select>

                <select name="type" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white" onchange="this.form.submit()">
                    <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>All types</option>
                    @foreach (['City', 'Regional', 'Express'] as $typeOption)
                        <option value="{{ $typeOption }}" {{ request('type') === $typeOption ? 'selected' : '' }}>{{ $typeOption }}</option>
                    @endforeach
                </select>

                <a href="{{ route('admin.routes.index') }}" class="text-sm font-medium text-slate-400 hover:text-[var(--navy)] px-2">Clear</a>
            </div>

            <div class="lg:ml-auto flex items-center gap-2">
                <a href="{{ route('admin.routes.export') }}" class="flex items-center gap-2 border border-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-slate-50 transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
                    Export
                </a>
                <button type="button" onclick="openModal()" class="flex items-center gap-2 grad-a text-white text-sm font-semibold px-4 py-2.5 rounded-lg glow hover:opacity-90 transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Add Route
                </button>
            </div>
        </form>

        {{-- Bulk action bar --}}
        <form id="bulkForm" method="POST" action="{{ route('admin.routes.bulk') }}">
            @csrf
            <div id="bulkBar" class="hidden items-center gap-4 px-5 py-3 bg-[#EAF3FC] border-b border-[#D6E7F7] text-sm">
                <span class="font-semibold text-[var(--navy)]"><span id="selectedCount">0</span> selected</span>

                <button type="submit" name="action" value="Active" class="text-slate-600 hover:text-[var(--navy)] font-medium flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12l5 5L20 7"/></svg>
                    Mark Active
                </button>
                <button type="submit" name="action" value="Inactive" class="text-slate-600 hover:text-[var(--navy)] font-medium flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 6L5 20"/></svg>
                    Mark Inactive
                </button>
                <button type="submit" name="action" value="Deleted" onclick="return confirm('Delete selected routes?')" class="text-rose-500 hover:text-rose-600 font-medium flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg>
                    Delete
                </button>

                <button type="button" onclick="clearSelection()" class="ml-auto text-slate-400 hover:text-slate-600">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto scrollbar-thin">
                <table class="w-full text-sm min-w-[920px]">
                    <thead>
                        <tr class="text-left text-slate-400 border-b border-slate-100 bg-[#FBFCFD]">
                            <th class="py-3 pl-5 pr-2 w-10"><input type="checkbox" id="selectAll" class="checkbox w-4 h-4 rounded" /></th>
                            @php
                                $columns = [
                                    'name' => 'Route',
                                    'origin' => 'Origin',
                                    'destination' => 'Destination',
                                    'distance' => 'Distance',
                                    'status' => 'Status',
                                    'created_at' => 'Created',
                                ];
                            @endphp
                            @foreach ($columns as $key => $label)
                                <th class="sortable font-medium py-3 pr-4 {{ request('sort') === $key ? 'sort-' . request('direction', 'asc') : '' }}">
                                    <a href="{{ route('admin.routes.index', array_merge(request()->query(), ['sort' => $key, 'direction' => request('sort') === $key && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1">
                                        {{ $label }}
                                        <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                    </a>
                                </th>
                            @endforeach
                            <th class="font-medium py-3 pr-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($routes as $route)
                            @php
                                $statusStyle = [
                                    'Active' => 'bg-emerald-50 text-emerald-600',
                                    'Inactive' => 'bg-rose-50 text-rose-600',
                                    'Pending' => 'bg-amber-50 text-amber-600',
                                ];
                                $typeStyle = [
                                    'City' => 'bg-slate-100 text-slate-600',
                                    'Regional' => 'bg-[#E9F2FC] text-[var(--navy)]',
                                    'Express' => 'bg-[#EAEAF9] text-[#1D2B62]',
                                ];
                            @endphp
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-[#F8FAFD] transition">
                                <td class="py-3 pl-5 pr-2">
                                    <input type="checkbox" name="ids[]" value="{{ $route->id }}" class="checkbox row-check w-4 h-4 rounded" form="bulkForm" />
                                </td>
                                <td class="py-3 pr-4">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-700 truncate">{{ $route->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $route->type }} route</p>
                                    </div>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $typeStyle[$route->type] ?? 'bg-slate-100 text-slate-600' }}">{{ $route->origin }}</span>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $typeStyle[$route->type] ?? 'bg-slate-100 text-slate-600' }}">{{ $route->destination }}</span>
                                </td>
                                <td class="py-3 pr-4 text-slate-500">{{ $route->distance }} km</td>
                                <td class="py-3 pr-4">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusStyle[$route->status] ?? 'bg-slate-100 text-slate-600' }}">{{ $route->status }}</span>
                                </td>
                                <td class="py-3 pr-4 text-slate-500">{{ optional($route->created_at)->format('M j, Y') }}</td>
                                <td class="py-3 pr-5 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button type="button"
                                                onclick='editRoute(@json($route))'
                                                class="p-1.5 rounded-lg text-slate-400 hover:text-[var(--navy)] hover:bg-slate-100" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                                        </button>

                                        <form method="POST" action="{{ route('admin.routes.destroy', $route) }}" onsubmit="return confirm('Delete this route?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50" title="Delete">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Empty state rendered below the table --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if ($routes->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" class="mb-3"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <p class="font-semibold text-slate-500">No routes match your filters</p>
                <p class="text-sm text-slate-400 mt-1">Try a different search term or clear filters.</p>
            </div>
        @endif

        {{-- Pagination --}}
        <div class="flex flex-col sm:flex-row items-center gap-3 justify-between px-5 py-4 border-t border-slate-100">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span>
                    @if ($routes->total() > 0)
                        Showing {{ $routes->firstItem() }}–{{ $routes->lastItem() }} of {{ $routes->total() }}
                    @else
                        No results
                    @endif
                </span>

                <form method="GET" action="{{ route('admin.routes.index') }}" id="pageSizeForm">
                    @foreach (request()->except('per_page', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="per_page" class="ml-2 border border-slate-200 rounded-lg px-2 py-1 text-sm outline-none bg-white" onchange="this.form.submit()">
                        @foreach ([8, 10, 20, 50] as $size)
                            <option value="{{ $size }}" {{ (int) request('per_page', 10) === $size ? 'selected' : '' }}>{{ $size }} / page</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="flex items-center gap-1 flex-wrap justify-center">
                {{ $routes->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    {{-- Add / edit route modal --}}
    <div id="modalOverlay" class="hidden fixed inset-0 z-50 items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div id="modalPanel" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl transform transition-all duration-200 scale-95 opacity-0">
            <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="font-display font-bold text-lg text-[var(--navy)]">Add Route</h3>
                        <p class="text-sm text-slate-500">Define a new route for your fleet.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="routeForm" method="POST" action="{{ route('admin.routes.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST" />

                <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto scrollbar-thin">
                    <div>
                        <label for="routeName" class="text-sm font-medium text-slate-600">Route name</label>
                        <input id="routeName" name="name" type="text" placeholder="Airport express" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('name') border-rose-400 @enderror" value="{{ old('name') }}" />
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="routeOrigin" class="text-sm font-medium text-slate-600">Origin</label>
                            <input id="routeOrigin" name="origin" type="text" placeholder="Downtown" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('origin') border-rose-400 @enderror" value="{{ old('origin') }}" />
                            @error('origin')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="routeDestination" class="text-sm font-medium text-slate-600">Destination</label>
                            <input id="routeDestination" name="destination" type="text" placeholder="Airport" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('destination') border-rose-400 @enderror" value="{{ old('destination') }}" />
                            @error('destination')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="routeDistance" class="text-sm font-medium text-slate-600">Distance (km)</label>
                            <input id="routeDistance" name="distance" type="number" min="1" placeholder="18" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('distance') border-rose-400 @enderror" value="{{ old('distance') }}" />
                            @error('distance')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="routeType" class="text-sm font-medium text-slate-600">Route type</label>
                            <select id="routeType" name="type" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white">
                                @foreach (['City', 'Regional', 'Express'] as $typeOption)
                                    <option value="{{ $typeOption }}" {{ old('type') === $typeOption ? 'selected' : '' }}>{{ $typeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="routeStatus" class="text-sm font-medium text-slate-600">Status</label>
                            <select id="routeStatus" name="status" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white">
                                @foreach (['Active', 'Inactive', 'Pending'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status') === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="routeCreated" class="text-sm font-medium text-slate-600">Created date</label>
                            <input id="routeCreated" name="created_at" type="date" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white" value="{{ old('created_at') }}" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-6 py-4 border-t border-slate-100 bg-[#FBFCFD] rounded-b-2xl">
                    <button type="button" onclick="closeModal()" class="flex-1 border border-slate-200 text-slate-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" id="routeSubmitBtn" class="flex-1 grad-a text-white text-sm font-semibold py-2.5 rounded-xl glow hover:opacity-90 transition">
                        <span id="routeSubmitText">Add Route</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const modalOverlay = document.getElementById('modalOverlay');
    const modalPanel = document.getElementById('modalPanel');

    function openModal() {
        modalOverlay.classList.remove('hidden');
        modalOverlay.classList.add('flex');
        requestAnimationFrame(() => {
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        });
        document.body.classList.add('overflow-hidden');
        setTimeout(() => document.getElementById('routeName').focus(), 150);
    }

    function closeModal() {
        modalPanel.classList.remove('scale-100', 'opacity-100');
        modalPanel.classList.add('scale-95', 'opacity-0');
        document.body.classList.remove('overflow-hidden');
        setTimeout(() => {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
            resetRouteForm();
        }, 180);
    }

    function resetRouteForm() {
        const form = document.getElementById('routeForm');
        form.reset();
        form.action = "{{ route('admin.routes.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('modalTitle').textContent = 'Add Route';
        document.getElementById('routeSubmitText').textContent = 'Add Route';
    }

    function editRoute(route) {
        document.getElementById('routeName').value = route.name;
        document.getElementById('routeOrigin').value = route.origin;
        document.getElementById('routeDestination').value = route.destination;
        document.getElementById('routeDistance').value = route.distance;
        document.getElementById('routeType').value = route.type;
        document.getElementById('routeStatus').value = route.status;
        document.getElementById('routeCreated').value = route.created_at ? route.created_at.substring(0, 10) : '';

        document.getElementById('routeForm').action = `/admin/routes/${route.id}`;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('modalTitle').textContent = 'Edit Route';
        document.getElementById('routeSubmitText').textContent = 'Save changes';

        openModal();
    }

    modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) closeModal(); });

    // Reopen modal automatically if validation failed server-side
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', openModal);
    @endif

    // Selection / bulk bar
    const bulkBar = document.getElementById('bulkBar');
    const selectedCount = document.getElementById('selectedCount');
    const selectAll = document.getElementById('selectAll');

    function refreshBulkBar() {
        const checked = document.querySelectorAll('.row-check:checked');
        if (checked.length > 0) {
            bulkBar.classList.remove('hidden');
            bulkBar.classList.add('flex');
            selectedCount.textContent = checked.length;
        } else {
            bulkBar.classList.add('hidden');
            bulkBar.classList.remove('flex');
        }
    }

    function clearSelection() {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = false);
        selectAll.checked = false;
        refreshBulkBar();
    }

    document.querySelectorAll('.row-check').forEach(cb => cb.addEventListener('change', refreshBulkBar));
    selectAll.addEventListener('change', function () {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
        refreshBulkBar();
    });

    // Show a toast if the server flashed a status message
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success'))));
    @endif
</script>
@endpush