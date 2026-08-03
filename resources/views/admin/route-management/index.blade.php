@extends('layouts.admin')

@section('title', 'Route Management')
@section('page_title', 'Route Management')
@section('page_subtitle', 'Create, edit, and track your route network.')

@section('content')

    @php
        $queryParameters = request()->only(['search', 'status', 'type', 'sort', 'direction', 'per_page']);
        $statusStyles = ['Active' => 'bg-emerald-50 text-emerald-600', 'Inactive' => 'bg-rose-50 text-rose-600', 'Pending' => 'bg-amber-50 text-amber-600'];
        $typeStyles = ['City' => 'bg-slate-100 text-slate-600', 'Regional' => 'bg-[#E9F2FC] text-[var(--navy)]', 'Express' => 'bg-[#EAEAF9] text-[#1D2B62]'];
        $selectedIds = old('ids', []) ?? [];
        $sortClasses = function ($key) use ($sort, $direction) {
            $classes = 'sortable font-medium py-3 pr-4';
            if ($sort === $key) {
                $classes .= $direction === 'asc' ? ' sort-asc' : ' sort-desc';
            }
            return $classes;
        };
        $sortUrl = function ($key) use ($queryParameters, $sort, $direction) {
            $params = $queryParameters;
            if ($sort === $key) {
                $params['direction'] = $direction === 'asc' ? 'desc' : 'asc';
            } else {
                $params['sort'] = $key;
                $params['direction'] = 'asc';
            }
            return route('admin.route-management.index', $params);
        };
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Total Routes</p>
            <p class="text-xl font-display font-bold text-[var(--navy)] mt-1">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Active</p>
            <p class="text-xl font-display font-bold text-emerald-600 mt-1">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Inactive</p>
            <p class="text-xl font-display font-bold text-rose-600 mt-1">{{ number_format($stats['inactive']) }}</p>
        </div>
        <div class="card p-4">
            <p class="text-xs text-slate-400 font-medium">Pending</p>
            <p class="text-xl font-display font-bold text-amber-600 mt-1">{{ number_format($stats['pending']) }}</p>
        </div>
    </div>

    <div class="card overflow-hidden">

        <form method="GET" action="{{ route('admin.route-management.index') }}" class="p-4 sm:p-5 border-b border-slate-100 flex flex-col lg:flex-row lg:items-center gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input name="search" value="{{ request('search', '') }}" placeholder="Search route, origin or destination&#8230;" class="w-full bg-[#F1F4F8] rounded-lg pl-10 pr-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-[var(--sky)] placeholder:text-slate-400" />
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white">
                    <option value="all" {{ request('status') === null || request('status') === 'all' ? 'selected' : '' }}>All statuses</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                </select>
                <select name="type" class="text-sm border border-slate-200 rounded-lg px-3 py-2.5 outline-none text-slate-600 bg-white">
                    <option value="all" {{ request('type') === null || request('type') === 'all' ? 'selected' : '' }}>All types</option>
                    <option value="City" {{ request('type') === 'City' ? 'selected' : '' }}>City</option>
                    <option value="Regional" {{ request('type') === 'Regional' ? 'selected' : '' }}>Regional</option>
                    <option value="Express" {{ request('type') === 'Express' ? 'selected' : '' }}>Express</option>
                </select>
                <a href="{{ route('admin.route-management.index') }}" class="text-sm font-medium text-slate-400 hover:text-[var(--navy)] px-2">Clear</a>
            </div>
            <div class="lg:ml-auto flex items-center gap-2">
                <a href="{{ route('admin.route-management.export', $queryParameters) }}" class="flex items-center gap-2 border border-slate-200 text-slate-600 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-slate-50 transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
                    Export
                </a>
                <button type="button" onclick="openModal()" class="flex items-center gap-2 grad-a text-white text-sm font-semibold px-4 py-2.5 rounded-lg glow hover:opacity-90 transition">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Add Route
                </button>
            </div>
        </form>

        <form id="bulkForm" method="POST" action="{{ route('admin.route-management.bulk-action') }}">
            @csrf
            <input type="hidden" name="action" id="bulkActionInput" value="delete" />

            <div id="bulkBar" class="hidden items-center gap-4 px-5 py-3 bg-[#EAF3FC] border-b border-[#D6E7F7] text-sm">
                <span class="font-semibold text-[var(--navy)]"><span id="selectedCount">0</span> selected</span>
                <button type="button" onclick="submitBulk('active')" class="text-slate-600 hover:text-[var(--navy)] font-medium flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12l5 5L20 7"/></svg>
                    Mark Active
                </button>
                <button type="button" onclick="submitBulk('inactive')" class="text-slate-600 hover:text-[var(--navy)] font-medium flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 6L5 20"/></svg>
                    Mark Inactive
                </button>
                <button type="button" onclick="submitBulk('delete')" class="text-rose-500 hover:text-rose-600 font-medium flex items-center gap-1.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/></svg>
                    Delete
                </button>
                <button type="button" onclick="clearSelection()" class="ml-auto text-slate-400 hover:text-slate-600">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="overflow-x-auto scrollbar-thin">
                <table class="w-full text-sm min-w-[920px]">
                    <thead>
                        <tr class="text-left text-slate-400 border-b border-slate-100 bg-[#FBFCFD]">
                            <th class="py-3 pl-5 pr-2 w-10">
                                <input type="checkbox" id="selectAll" class="checkbox w-4 h-4 rounded" />
                            </th>
                            <th class="{{ $sortClasses('name') }}" onclick="window.location='{{ $sortUrl('name') }}'">
                                <span class="inline-flex items-center gap-1">Route
                                    <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                </span>
                            </th>
                            <th class="{{ $sortClasses('origin') }}" onclick="window.location='{{ $sortUrl('origin') }}'">
                                <span class="inline-flex items-center gap-1">Origin
                                    <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                </span>
                            </th>
                            <th class="{{ $sortClasses('destination') }}" onclick="window.location='{{ $sortUrl('destination') }}'">
                                <span class="inline-flex items-center gap-1">Destination
                                    <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                </span>
                            </th>
                            <th class="{{ $sortClasses('distance') }}" onclick="window.location='{{ $sortUrl('distance') }}'">
                                <span class="inline-flex items-center gap-1">Distance
                                    <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                </span>
                            </th>
                            <th class="{{ $sortClasses('status') }}" onclick="window.location='{{ $sortUrl('status') }}'">
                                <span class="inline-flex items-center gap-1">Status
                                    <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                </span>
                            </th>
                            <th class="{{ $sortClasses('created') }}" onclick="window.location='{{ $sortUrl('created') }}'">
                                <span class="inline-flex items-center gap-1">Created
                                    <svg class="sort-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                                </span>
                            </th>
                            <th class="font-medium py-3 pr-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($routes as $route)
                            <tr class="border-b border-slate-50 last:border-0 hover:bg-[#F8FAFD] transition">
                                <td class="py-3 pl-5 pr-2">
                                    <input type="checkbox" class="checkbox row-check w-4 h-4 rounded" name="ids[]" value="{{ $route->id }}" @checked(in_array($route->id, $selectedIds)) />
                                </td>
                                <td class="py-3 pr-4">
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-700 truncate">{{ $route->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $route->type }} route</p>
                                    </div>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $typeStyles[$route->type] ?? 'bg-slate-100 text-slate-600' }}">{{ $route->origin }}</span>
                                </td>
                                <td class="py-3 pr-4">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $typeStyles[$route->type] ?? 'bg-slate-100 text-slate-600' }}">{{ $route->destination }}</span>
                                </td>
                                <td class="py-3 pr-4 text-slate-500">{{ $route->distance }} km</td>
                                <td class="py-3 pr-4">
                                    <form method="POST" action="{{ route('admin.route-management.status', $route) }}" class="inline" onsubmit="return confirm('Change status for this route?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $route->status === 'Active' ? 'Inactive' : 'Active' }}" />
                                        <button type="submit" class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusStyles[$route->status] ?? 'bg-slate-100 text-slate-600' }} hover:opacity-80 transition" title="Click to toggle status">
                                            {{ $route->status }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3 pr-4 text-slate-500">{{ optional($route->created_at)->format('M j, Y') }}</td>
                                <td class="py-3 pr-5 text-right">
                                    <div class="inline-flex items-center gap-1">
                                    <button type="button"
                                            onclick="editRoute({{ htmlspecialchars(json_encode([
                                                'id' => $route->id,
                                                'name' => $route->name,
                                                'origin' => $route->origin,
                                                'destination' => $route->destination,
                                                'distance' => $route->distance,
                                                'type' => $route->type,
                                                'status' => $route->status,
                                                'created' => optional($route->created_at)->format('Y-m-d'),
                                            ])) }})"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-[var(--navy)] hover:bg-slate-100" title="Edit">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                                    </button>
                                        <form method="POST" action="{{ route('admin.route-management.destroy', $route) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this route?');">
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

        <div class="flex flex-col sm:flex-row items-center gap-3 justify-between px-5 py-4 border-t border-slate-100">
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span>
                    @if ($routes->total() > 0)
                        Showing {{ $routes->firstItem() }}&#8211;{{ $routes->lastItem() }} of {{ $routes->total() }}
                    @else
                        No results
                    @endif
                </span>
                <form method="GET" action="{{ route('admin.route-management.index') }}" id="pageSizeForm">
                    @foreach (request()->except(['per_page', 'page']) as $key => $value)
                        @if (is_array($value))
                            @foreach ($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <select name="per_page" class="ml-2 border border-slate-200 rounded-lg px-2 py-1 text-sm outline-none bg-white" onchange="this.form.submit()">
                        <option value="8" {{ $perPage === 8 ? 'selected' : '' }}>8 / page</option>
                        <option value="10" {{ $perPage === 10 ? 'selected' : '' }}>10 / page</option>
                        <option value="20" {{ $perPage === 20 ? 'selected' : '' }}>20 / page</option>
                        <option value="50" {{ $perPage === 50 ? 'selected' : '' }}>50 / page</option>
                    </select>
                </form>
            </div>
            <div class="flex items-center gap-1 flex-wrap justify-center">
                @php
                    $paginator = $routes;
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $pagesToShow = array_unique([1, $lastPage, $currentPage, $currentPage - 1, $currentPage + 1]);
                    sort($pagesToShow);
                    $lastPrinted = 0;
                @endphp
                @if ($lastPage > 0)
                    <button onclick="window.location='{{ $paginator->appends($queryParameters)->previousPageUrl() }}'" {{ $currentPage === 1 ? 'disabled' : '' }} class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium border border-slate-200 text-slate-500 disabled:opacity-40 hover:bg-slate-50">&#8249;</button>
                    @foreach ($pagesToShow as $p)
                        @if ($p < 1 || $p > $lastPage)
                            @continue
                        @endif
                        @if ($p - $lastPrinted > 1)
                            <span class="px-1 text-slate-300">&#8230;</span>
                        @endif
                        <button onclick="window.location='{{ $paginator->appends($queryParameters)->url($p) }}'" class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium {{ $p === $currentPage ? 'bg-[var(--navy)] text-white' : 'border border-slate-200 text-slate-500 hover:bg-slate-50' }}">{{ $p }}</button>
                        @php $lastPrinted = $p; @endphp
                    @endforeach
                    <button onclick="window.location='{{ $paginator->appends($queryParameters)->nextPageUrl() }}'" {{ $currentPage === $lastPage ? 'disabled' : '' }} class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium border border-slate-200 text-slate-500 disabled:opacity-40 hover:bg-slate-50">&#8250;</button>
                @endif
            </div>
        </div>
    </div>

    <div id="modalOverlay" class="hidden fixed inset-0 z-50 items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div id="modalPanel" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl transform transition-all duration-200 scale-95 opacity-0">
            <div class="flex items-start justify-between px-6 pt-6 pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl grad-a flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M4 12h16"/><path d="M5 7l-2 2 2 2"/><path d="M19 13l2 2-2 2"/></svg>
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

            <form id="routeForm" method="POST" action="{{ route('admin.route-management.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST" />

                <div class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto scrollbar-thin">
                    <div>
                        <label for="routeName" class="text-sm font-medium text-slate-600">Route name</label>
                        <input id="routeName" name="name" type="text" placeholder="Airport express"
                               class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('name') border-rose-400 @enderror"
                               value="{{ old('name', $selectedRoute->name ?? '') }}" />
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="routeOrigin" class="text-sm font-medium text-slate-600">Origin</label>
                            <input id="routeOrigin" name="origin" type="text" placeholder="Downtown"
                                   class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('origin') border-rose-400 @enderror"
                                   value="{{ old('origin', $selectedRoute->origin ?? '') }}" />
                            @error('origin')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="routeDestination" class="text-sm font-medium text-slate-600">Destination</label>
                            <input id="routeDestination" name="destination" type="text" placeholder="Airport"
                                   class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('destination') border-rose-400 @enderror"
                                   value="{{ old('destination', $selectedRoute->destination ?? '') }}" />
                            @error('destination')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="routeDistance" class="text-sm font-medium text-slate-600">Distance (km)</label>
                            <input id="routeDistance" name="distance" type="number" min="1" step="0.01" placeholder="18"
                                   class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('distance') border-rose-400 @enderror"
                                   value="{{ old('distance', $selectedRoute->distance ?? '') }}" />
                            @error('distance')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="routeType" class="text-sm font-medium text-slate-600">Route type</label>
                            <select id="routeType" name="type" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white @error('type') border-rose-400 @enderror">
                                <option value="City" {{ (old('type', $selectedRoute->type ?? 'City') === 'City') ? 'selected' : '' }}>City</option>
                                <option value="Regional" {{ (old('type', $selectedRoute->type ?? '') === 'Regional') ? 'selected' : '' }}>Regional</option>
                                <option value="Express" {{ (old('type', $selectedRoute->type ?? '') === 'Express') ? 'selected' : '' }}>Express</option>
                            </select>
                            @error('type')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="routeStatus" class="text-sm font-medium text-slate-600">Status</label>
                            <select id="routeStatus" name="status" class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white @error('status') border-rose-400 @enderror">
                                <option value="Active" {{ (old('status', $selectedRoute->status ?? 'Active') === 'Active') ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ (old('status', $selectedRoute->status ?? '') === 'Inactive') ? 'selected' : '' }}>Inactive</option>
                                <option value="Pending" {{ (old('status', $selectedRoute->status ?? '') === 'Pending') ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('status')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="routeCreated" class="text-sm font-medium text-slate-600">Created date</label>
                            <input id="routeCreated" name="created_display" type="date"
                                   class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none bg-white"
                                   value="{{ old('created_display', optional($selectedRoute->created_at ?? null)->format('Y-m-d') ?? '') }}" />
                        </div>
                    </div>
                    <div>
                        <label for="routeDescription" class="text-sm font-medium text-slate-600">Description (optional)</label>
                        <textarea id="routeDescription" name="description" rows="2" placeholder="Additional route details..."
                                  class="input-field mt-1.5 w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm outline-none @error('description') border-rose-400 @enderror">{{ old('description', $selectedRoute->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 px-6 py-4 border-t border-slate-100 bg-[#FBFCFD] rounded-b-2xl">
                    <button type="button" onclick="closeModal()" class="flex-1 border border-slate-200 text-slate-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" id="routeSubmitBtn" class="flex-1 grad-a text-white text-sm font-semibold py-2.5 rounded-xl glow hover:opacity-90 transition flex items-center justify-center gap-2">
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
    const routeForm = document.getElementById('routeForm');
    const formMethod = document.getElementById('formMethod');
    const modalTitle = document.getElementById('modalTitle');
    const routeSubmitText = document.getElementById('routeSubmitText');
    const bulkBar = document.getElementById('bulkBar');
    const selectedCount = document.getElementById('selectedCount');
    const selectAll = document.getElementById('selectAll');
    const rowChecks = document.querySelectorAll('.row-check');
    const bulkForm = document.getElementById('bulkForm');
    const bulkActionInput = document.getElementById('bulkActionInput');

    const storeUrl = "{{ route('admin.route-management.store') }}";
    const editBaseUrl = "{{ url('admin/route-management') }}";

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
        document.getElementById('routeName').value = '';
        document.getElementById('routeOrigin').value = '';
        document.getElementById('routeDestination').value = '';
        document.getElementById('routeDistance').value = '';
        document.getElementById('routeType').value = 'City';
        document.getElementById('routeStatus').value = 'Active';
        document.getElementById('routeCreated').value = '';
        document.getElementById('routeDescription').value = '';
        formMethod.value = 'POST';
        routeForm.action = storeUrl;
        modalTitle.textContent = 'Add Route';
        routeSubmitText.textContent = 'Add Route';
    }

    function resetToAdd() {
        formMethod.value = 'POST';
        routeForm.action = storeUrl;
        modalTitle.textContent = 'Add Route';
        routeSubmitText.textContent = 'Add Route';
    }

    function editRoute(route) {
        document.getElementById('routeName').value = route.name;
        document.getElementById('routeOrigin').value = route.origin;
        document.getElementById('routeDestination').value = route.destination;
        document.getElementById('routeDistance').value = route.distance;
        document.getElementById('routeType').value = route.type;
        document.getElementById('routeStatus').value = route.status;
        document.getElementById('routeCreated').value = route.created || '';

        routeForm.action = `${editBaseUrl}/${route.id}`;
        formMethod.value = 'PUT';
        modalTitle.textContent = 'Edit Route';
        routeSubmitText.textContent = 'Save changes';

        openModal();
    }

    modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) closeModal(); });

    function updateSelectedState() {
        const checked = Array.from(rowChecks).filter(cb => cb.checked);
        selectedCount.textContent = checked.length;
        if (checked.length > 0) {
            bulkBar.classList.remove('hidden');
            bulkBar.classList.add('flex');
        } else {
            bulkBar.classList.add('hidden');
            bulkBar.classList.remove('flex');
        }
        const allVisible = Array.from(rowChecks);
        selectAll.checked = allVisible.length > 0 && allVisible.every(cb => cb.checked);
        selectAll.indeterminate = !selectAll.checked && checked.length > 0;
    }

    function clearSelection() {
        rowChecks.forEach(cb => { cb.checked = false; });
        updateSelectedState();
    }

    rowChecks.forEach(cb => cb.addEventListener('change', updateSelectedState));

    selectAll.addEventListener('change', () => {
        rowChecks.forEach(cb => { cb.checked = selectAll.checked; });
        updateSelectedState();
    });

    function submitBulk(action) {
        const checked = Array.from(rowChecks).filter(cb => cb.checked);
        if (checked.length === 0) {
            showToast('Please select at least one route.');
            return;
        }
        let confirmMsg = 'Are you sure you want to perform this action on ' + checked.length + ' route(s)?';
        if (action === 'delete') {
            confirmMsg = 'Are you sure you want to DELETE ' + checked.length + ' route(s)? This cannot be undone.';
        }
        if (!confirm(confirmMsg)) return;
        bulkActionInput.value = action;
        bulkForm.submit();
    }

    updateSelectedState();

            @if (isset($selectedRoute))
                editRoute({!! json_encode([
                    'id' => $selectedRoute->id,
                    'name' => old('name', $selectedRoute->name),
                    'origin' => old('origin', $selectedRoute->origin),
                    'destination' => old('destination', $selectedRoute->destination),
                    'distance' => old('distance', $selectedRoute->distance),
                    'type' => old('type', $selectedRoute->type),
                    'status' => old('status', $selectedRoute->status),
                    'created' => old('created_display', optional($selectedRoute->created_at)->format('Y-m-d')),
                ]) !!});
            @else
                resetToAdd();
            @endif
 

    @if (session('success'))
        showToast(@json(session('success')));
    @endif
    @if (session('error'))
        showToast(@json(session('error')));
    @endif
</script>
@endpush
