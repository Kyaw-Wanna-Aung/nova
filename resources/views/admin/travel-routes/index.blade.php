@extends('layouts.admin')

@section('title', 'Route Management')
@section('page_title', 'Route Management')
@section('page_subtitle', 'Manage routes shared by the website and mobile application.')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-[var(--navy)]">
                Routes
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Create and manage Nova travel routes.
            </p>
        </div>

        <button
            type="button"
            onclick="openCreateModal()"
            class="grad-a rounded-xl px-5 py-3 text-sm font-semibold text-white glow transition hover:opacity-90"
        >
            + Add Route
        </button>
    </div>

    {{-- Filters with Searchable Dropdowns --}}
    <div class="card p-5">
        <form
            method="GET"
            action="{{ route('admin.route-management.index') }}"
            class="grid gap-3 md:grid-cols-4"
        >
            {{-- Filter Route Searchable --}}
            <div class="relative">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">
                    Search Route
                </label>
                <div class="flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm items-center px-3 py-2">
                    <input
                        type="text"
                        id="filter_route_search"
                        placeholder="All routes..."
                        value="{{ request('search') }}"
                        class="w-full text-sm outline-none bg-transparent"
                        autocomplete="off"
                    >
                </div>
                <input type="hidden" name="search" id="filter_route_hidden" value="{{ request('search') }}">
                <div
                    id="filter_route_dropdown_list"
                    class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl hidden"
                ></div>
            </div>

            {{-- Filter Departure Township Searchable --}}
            <div class="relative">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">
                    Departure
                </label>
                <div class="flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm items-center px-3 py-2">
                    <input
                        type="text"
                        id="filter_departure_search"
                        placeholder="All departures..."
                        value="{{ request('departure_id') ? optional($townships->firstWhere('id', request('departure_id')))->name : '' }}"
                        class="w-full text-sm outline-none bg-transparent"
                        autocomplete="off"
                    >
                </div>
                <input type="hidden" name="departure_id" id="filter_departure_id" value="{{ request('departure_id') }}">
                <div
                    id="filter_departure_dropdown_list"
                    class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl hidden"
                ></div>
            </div>

            {{-- Filter Arrival Township Searchable --}}
            <div class="relative">
                <label class="text-xs font-semibold text-slate-500 block mb-1.5">
                    Arrival
                </label>
                <div class="flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm items-center px-3 py-2">
                    <input
                        type="text"
                        id="filter_arrival_search"
                        placeholder="All arrivals..."
                        value="{{ request('arrival_id') ? optional($townships->firstWhere('id', request('arrival_id')))->name : '' }}"
                        class="w-full text-sm outline-none bg-transparent"
                        autocomplete="off"
                    >
                </div>
                <input type="hidden" name="arrival_id" id="filter_arrival_id" value="{{ request('arrival_id') }}">
                <div
                    id="filter_arrival_dropdown_list"
                    class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl hidden"
                ></div>
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-[var(--navy)] px-4 py-2.5 text-sm font-semibold text-white"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.route-management.index') }}"
                    class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-500"
                >
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">

                <thead>
                    <tr class="border-b border-slate-100 bg-[#FBFCFD] text-left text-xs uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-4">Route</th>
                        <th class="px-5 py-4">Departure</th>
                        <th class="px-5 py-4">Arrival</th>
                        <th class="px-5 py-4">Distance</th>
                        <th class="px-5 py-4">Estimated Time</th>
                        <th class="px-5 py-4">Route Time</th>
                        <th class="px-5 py-4">Discount</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($routes as $route)

                        @php
                            $hours = intdiv(
                                $route->estimated_time,
                                60
                            );

                            $minutes =
                                $route->estimated_time % 60;
                        @endphp

                        <tr class="border-b border-slate-50 hover:bg-slate-50/50">

                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-700">
                                    {{ $route->route_name }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-700">
                                    {{ $route->departure?->name }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    {{ $route->departure?->mm_name }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-700">
                                    {{ $route->arrival?->name }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    {{ $route->arrival?->mm_name }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ number_format($route->distance, 1) }}
                                km
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                @if ($hours > 0)
                                    {{ $hours }} hr
                                @endif

                                @if ($minutes > 0)
                                    {{ $minutes }} min
                                @endif
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse(
                                    $route->route_time
                                )->format('h:i A') }}
                            </td>

                            <td class="px-5 py-4">
                                @if ($route->discount > 0)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                        {{ $route->discount }}%
                                    </span>
                                @else
                                    <span class="text-slate-400">
                                        —
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex gap-2">

                                    <button
                                        type="button"
                                        class="edit-route-btn rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-[var(--navy)]"
                                        data-update-url="{{ route('admin.route-management.update', $route) }}"
                                        data-id="{{ $route->id }}"
                                        data-route-name="{{ $route->route_name }}"
                                        data-departure-id="{{ $route->departure_id }}"
                                        data-departure-text="{{ $route->departure ? $route->departure->name . ' (' . $route->departure->mm_name . ')' : '' }}"
                                        data-arrival-id="{{ $route->arrival_id }}"
                                        data-arrival-text="{{ $route->arrival ? $route->arrival->name . ' (' . $route->arrival->mm_name . ')' : '' }}"
                                        data-distance="{{ $route->distance }}"
                                        data-estimated-time="{{ $route->estimated_time }}"
                                        data-route-time="{{ $route->route_time }}"
                                        data-discount="{{ $route->discount }}"
                                    >
                                        Edit
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.route-management.destroy',
                                            $route
                                        ) }}"
                                        onsubmit="return confirm(
                                            'Delete this route?'
                                        );"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-500"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="8"
                                class="px-5 py-16 text-center"
                            >
                                <p class="font-semibold text-slate-500">
                                    No routes found
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Create your first route or change the filters.
                                </p>
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-5 py-4">
            {{ $routes->links() }}
        </div>
    </div>
</div>

{{-- Modal --}}
<div
    id="routeModal"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm"
>
    <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">

        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3
                    id="routeModalTitle"
                    class="text-lg font-bold text-[var(--navy)]"
                >
                    Add Route
                </h3>

                <p class="text-sm text-slate-500">
                    Configure the route information.
                </p>
            </div>

            <button
                type="button"
                onclick="closeRouteModal()"
                class="text-slate-400"
            >
                ✕
            </button>
        </div>

        <form
            id="travelRouteForm"
            method="POST"
            action="{{ route('admin.route-management.store') }}"
        >
            @csrf

            <input
                type="hidden"
                name="_method"
                id="routeFormMethod"
                value="POST"
            >

            <div class="max-h-[70vh] space-y-4 overflow-y-auto px-6 py-5">

                <div>
                    <label class="text-sm font-medium text-slate-600">
                        Route Name
                    </label>

                    <input
                        id="route_name"
                        name="route_name"
                        type="text"
                        class="mt-1.5 w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm"
                        required
                    >
                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    <!-- Departure Township -->
                    <div>
                        <label class="text-sm font-medium text-slate-600 block mb-1.5">
                            Departure Township
                        </label>
                        <div class="relative">
                            <div class="flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm items-center px-3 py-2">
                                <input
                                    type="text"
                                    id="departure_search"
                                    placeholder="Search township..."
                                    class="w-full text-sm outline-none bg-transparent"
                                    autocomplete="off"
                                >
                                <select
                                    id="departure_category"
                                    class="border-l border-slate-200 bg-slate-50 px-2 py-1.5 text-xs font-semibold text-slate-600 outline-none cursor-pointer rounded-lg ml-1"
                                >
                                    <option value="">All</option>
                                </select>
                            </div>
                            <input type="hidden" name="departure_id" id="departure_id" required>

                            <div
                                id="departure_dropdown_list"
                                class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl hidden"
                            ></div>
                        </div>
                    </div>

                    <!-- Arrival Township -->
                    <div>
                        <label class="text-sm font-medium text-slate-600 block mb-1.5">
                            Arrival Township
                        </label>
                        <div class="relative">
                            <div class="flex rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm items-center px-3 py-2">
                                <input
                                    type="text"
                                    id="arrival_search"
                                    placeholder="Search township..."
                                    class="w-full text-sm outline-none bg-transparent"
                                    autocomplete="off"
                                >
                                <select
                                    id="arrival_category"
                                    class="border-l border-slate-200 bg-slate-50 px-2 py-1.5 text-xs font-semibold text-slate-600 outline-none cursor-pointer rounded-lg ml-1"
                                >
                                    <option value="">All</option>
                                </select>
                            </div>
                            <input type="hidden" name="arrival_id" id="arrival_id" required>

                            <div
                                id="arrival_dropdown_list"
                                class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-xl hidden"
                            ></div>
                        </div>
                    </div>

                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    <div>
                        <label class="text-sm font-medium text-slate-600">
                            Distance (km)
                        </label>

                        <input
                            id="distance"
                            name="distance"
                            type="number"
                            min="0"
                            step="0.01"
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm"
                            required
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">
                            Estimated Time (minutes)
                        </label>

                        <input
                            id="estimated_time"
                            name="estimated_time"
                            type="number"
                            min="1"
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm"
                            required
                        >
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    <div>
                        <label class="text-sm font-medium text-slate-600">
                            Default Route Time
                        </label>

                        <input
                            id="route_time"
                            name="route_time"
                            type="time"
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm"
                            required
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">
                            Discount (%)
                        </label>

                        <input
                            id="discount"
                            name="discount"
                            type="number"
                            min="0"
                            max="100"
                            value="0"
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm"
                            required
                        >
                    </div>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">

                <button
                    type="button"
                    onclick="closeRouteModal()"
                    class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600"
                >
                    Cancel
                </button>

                <button
                    id="routeSubmitButton"
                    type="submit"
                    class="grad-a flex-1 rounded-xl py-2.5 text-sm font-semibold text-white"
                >
                    Add Route
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const townshipsData = @json($townships);
const routesData = @json($routes->pluck('route_name')->unique()->values());

function setupSearchableDropdown(prefix, hasCategory = false, dataList = townshipsData, isRouteFilter = false) {
    const searchInput = document.getElementById(prefix + '_search');
    const categorySelect = document.getElementById(prefix + '_category');
    const hiddenInput = document.getElementById(prefix + (isRouteFilter ? '_hidden' : '_id'));
    const dropdownList = document.getElementById(prefix + '_dropdown_list');

    if (hasCategory && categorySelect) {
        const regions = [...new Set(dataList.map(t => t.region_name).filter(Boolean))];
        categorySelect.innerHTML = '<option value="">All</option>';
        regions.forEach(reg => {
            const opt = document.createElement('option');
            opt.value = reg;
            opt.textContent = reg;
            categorySelect.appendChild(opt);
        });
    }

    function renderList(filterText = '', selectedCategory = '') {
        const query = filterText.toLowerCase();
        const filtered = dataList.filter(item => {
            if (isRouteFilter) {
                return query === '' || item.toLowerCase().includes(query);
            } else {
                const matchesCat = !hasCategory || selectedCategory === '' || item.region_name === selectedCategory;
                const matchesQuery = query === '' || 
                    (item.name && item.name.toLowerCase().includes(query)) || 
                    (item.mm_name && item.mm_name.includes(query));
                return matchesCat && matchesQuery;
            }
        });

        if (filtered.length === 0) {
            dropdownList.innerHTML = '<div class="px-3.5 py-2.5 text-sm text-slate-400">No results found</div>';
        } else {
            dropdownList.innerHTML = filtered.map(item => {
                if (isRouteFilter) {
                    return `
                        <div data-name="${item}" class="dropdown-item cursor-pointer px-3.5 py-2.5 text-sm text-slate-700 hover:bg-blue-50 border-b border-slate-50">
                            <span class="font-semibold text-slate-800">${item}</span>
                        </div>
                    `;
                } else {
                    return `
                        <div data-id="${item.id}" data-name="${item.name} (${item.mm_name})" class="dropdown-item cursor-pointer px-3.5 py-2.5 text-sm text-slate-700 hover:bg-blue-50 border-b border-slate-50 flex justify-between items-center">
                            <div>
                                <span class="font-semibold text-slate-800">${item.name}</span>
                                <span class="text-xs text-slate-400 ml-1">(${item.mm_name})</span>
                            </div>
                            <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">${item.region_name}</span>
                        </div>
                    `;
                }
            }).join('');
        }
        dropdownList.classList.remove('hidden');
    }

    searchInput.addEventListener('focus', () => {
        renderList(searchInput.value, hasCategory ? categorySelect.value : '');
    });

    searchInput.addEventListener('input', () => {
        hiddenInput.value = searchInput.value;
        renderList(searchInput.value, hasCategory ? categorySelect.value : '');
    });

    if (hasCategory && categorySelect) {
        categorySelect.addEventListener('change', () => {
            renderList(searchInput.value, categorySelect.value);
        });
    }

    dropdownList.addEventListener('click', (e) => {
        const itemEl = e.target.closest('.dropdown-item');
        if (itemEl) {
            if (isRouteFilter) {
                hiddenInput.value = itemEl.dataset.name;
                searchInput.value = itemEl.dataset.name;
            } else {
                hiddenInput.value = itemEl.dataset.id;
                searchInput.value = itemEl.dataset.name;
            }
            dropdownList.classList.add('hidden');
        }
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !dropdownList.contains(e.target) && (!hasCategory || !categorySelect.contains(e.target))) {
            dropdownList.classList.add('hidden');
        }
    });

    // Return helper methods so modal open/edit functions can control them properly
    return {
        reset: function() {
            searchInput.value = '';
            hiddenInput.value = '';
            if (hasCategory && categorySelect) categorySelect.value = '';
        },
        setValue: function(id, text) {
            hiddenInput.value = id ?? '';
            searchInput.value = text ?? '';
        }
    };
}

document.addEventListener('DOMContentLoaded', () => {
    const routeModal = document.getElementById('routeModal');
    const routeForm = document.getElementById('travelRouteForm');
    const routeFormMethod = document.getElementById('routeFormMethod');
    const routeModalTitle = document.getElementById('routeModalTitle');
    const routeSubmitButton = document.getElementById('routeSubmitButton');

    setupSearchableDropdown('filter_route', false, routesData, true);
    setupSearchableDropdown('filter_departure', false, townshipsData, false);
    setupSearchableDropdown('filter_arrival', false, townshipsData, false);

    const departureDropdown = setupSearchableDropdown('departure', true, townshipsData, false);
    const arrivalDropdown = setupSearchableDropdown('arrival', true, townshipsData, false);

    const routeStoreUrl = @json(route('admin.route-management.store'));

    function showRouteModal() {
        routeModal.classList.remove('hidden');
        routeModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    window.closeRouteModal = function () {
        routeModal.classList.add('hidden');
        routeModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    window.openCreateModal = function () {
        routeForm.reset();
        departureDropdown.reset();
        arrivalDropdown.reset();

        routeForm.action = routeStoreUrl;
        routeFormMethod.value = 'POST';

        routeModalTitle.textContent = 'Add Route';
        routeSubmitButton.textContent = 'Add Route';

        document.getElementById('discount').value = '0';

        showRouteModal();
    };

    function openEditModal(button) {
        document.getElementById('route_name').value = button.dataset.routeName ?? '';

        departureDropdown.setValue(button.dataset.departureId, button.dataset.departureText);
        arrivalDropdown.setValue(button.dataset.arrivalId, button.dataset.arrivalText);

        document.getElementById('distance').value = button.dataset.distance ?? '';
        document.getElementById('estimated_time').value = button.dataset.estimatedTime ?? '';

        const routeTime = button.dataset.routeTime ?? '';
        document.getElementById('route_time').value = routeTime.substring(0, 5);

        document.getElementById('discount').value = button.dataset.discount ?? '0';

        routeForm.action = button.dataset.updateUrl;
        routeFormMethod.value = 'PUT';

        routeModalTitle.textContent = 'Edit Route';
        routeSubmitButton.textContent = 'Save Changes';

        showRouteModal();
    }

    document.querySelectorAll('.edit-route-btn').forEach((button) => {
        button.addEventListener('click', () => {
            openEditModal(button);
        });
    });

    routeForm.addEventListener('submit', (e) => {
        const depId = document.getElementById('departure_id').value;
        const arrId = document.getElementById('arrival_id').value;
        
        if (!depId || !arrId) {
            e.preventDefault();
            alert('Please select a valid Departure and Arrival township from the dropdown list.');
        }
    });

    routeModal.addEventListener('click', (event) => {
        if (event.target === routeModal) {
            closeRouteModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !routeModal.classList.contains('hidden')) {
            closeRouteModal();
        }
    });
});
</script>
@endpush