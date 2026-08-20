@extends('layouts.admin')

@section('title', 'Route Schedule Management')
@section('page_title', 'Route Schedule Management')
@section('page_subtitle', 'Manage schedules and departure times for travel routes.')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-[var(--navy)]">
                Route Schedules
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Create and manage schedules for Nova travel routes.
            </p>
        </div>

        <button
            type="button"
            onclick="openCreateModal()"
            class="grad-a rounded-xl px-5 py-3 text-sm font-semibold text-white glow transition hover:opacity-90"
        >
            + Add Schedule
        </button>
    </div>

    {{-- Filters (Updated with Searchable Route & Driver) --}}
    <div class="card p-5">
        <form
            method="GET"
            action="{{ route('admin.route-schedules.index') }}"
            class="grid gap-3 md:grid-cols-5"
        >
            {{-- Route Searchable Filter --}}
            <div class="relative filter-search-container" id="routeFilterContainer">
                <label class="text-xs font-semibold text-slate-500 block mb-1">
                    Route Name
                </label>
                <input
                    type="text"
                    id="filterRouteInput"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none"
                    placeholder="Search route..."
                    value="{{ request('route_name_display') }}"
                    autocomplete="off"
                >
                <input type="hidden" name="route_id" id="filterRouteId" value="{{ request('route_id') }}">

                <div id="filterRouteDropdown" class="hidden absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-lg">
                    <div class="filter-route-option cursor-pointer px-4 py-2 text-sm hover:bg-slate-50" data-id="" data-name="">All routes</div>
                    @foreach ($routes as $route)
                        <div
                            class="filter-route-option cursor-pointer px-4 py-2 text-sm hover:bg-slate-50"
                            data-id="{{ $route->id }}"
                            data-name="{{ $route->route_name }}"
                        >
                            {{ $route->route_name }} ({{ $route->departure?->name }} → {{ $route->arrival?->name }})
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Driver Searchable Filter --}}
            <div class="relative filter-search-container" id="driverFilterContainer">
                <label class="text-xs font-semibold text-slate-500 block mb-1">
                    Driver Name
                </label>
                <input
                    type="text"
                    id="filterDriverInput"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none"
                    placeholder="Search driver..."
                    value="{{ request('driver_name') }}"
                    autocomplete="off"
                >
                <input type="hidden" name="driver_name" id="filterDriverNameHidden" value="{{ request('driver_name') }}">

                <div id="filterDriverDropdown" class="hidden absolute z-50 mt-1 max-h-48 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-lg">
                    <div class="filter-driver-option cursor-pointer px-4 py-2 text-sm hover:bg-slate-50" data-name="">All drivers</div>
                    @foreach ($drivers as $driver)
                        <div
                            class="filter-driver-option cursor-pointer px-4 py-2 text-sm hover:bg-slate-50"
                            data-name="{{ $driver->username }}"
                        >
                            {{ $driver->username }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-500 block mb-1">
                    From Date
                </label>
                <input
                    type="date"
                    name="from"
                    value="{{ request('from') }}"
                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none"
                >
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-500 block mb-1">
                    To Date
                </label>
                <input
                    type="date"
                    name="to"
                    value="{{ request('to') }}"
                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none"
                >
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-[var(--navy)] px-4 py-2.5 text-sm font-semibold text-white"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.route-schedules.index') }}"
                    class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-500 flex items-center justify-center"
                >
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1000px] text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#FBFCFD] text-left text-xs uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-4">ID</th>
                        <th class="px-5 py-4">Route Name</th>
                        <th class="px-5 py-4">Driver (Search & Choose)</th>
                        <th class="px-5 py-4">Vehicle (Search & Choose)</th>
                        <th class="px-5 py-4">Route Date</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($schedules as $schedule)
                        <form method="POST" action="{{ route('admin.route-schedules.update', $schedule->id) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="route_id" value="{{ $schedule->route_id }}">
                            <input type="hidden" name="route_date" value="{{ $schedule->route_date }}">
                            <input type="hidden" name="complete" value="{{ $schedule->complete }}">

                            <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    {{ $schedule->id }}
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-700">
                                        {{ $schedule->route?->route_name }}
                                    </p>
                                    <p class="text-xs text-slate-400">
                                        {{ $schedule->route?->departure?->name }} → {{ $schedule->route?->arrival?->name }}
                                    </p>
                                </td>

                                {{-- Driver Searchable Select inside Table --}}
                                <td class="px-5 py-4 relative">
                                    <div class="driver-inline-container relative">
                                        <input
                                            type="text"
                                            class="driver-search-input w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none"
                                            placeholder="Search driver..."
                                            value="{{ $schedule->driver->username ?? '' }}"
                                            autocomplete="off"
                                        >
                                        <input type="hidden" name="driver_id" class="driver-id-input" value="{{ $schedule->driver_id }}">

                                        <div class="driver-dropdown-list hidden absolute z-30 mt-1 max-h-40 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-lg">
                                            @foreach ($drivers as $driver)
                                                <div
                                                    class="driver-option cursor-pointer px-3 py-2 text-sm hover:bg-slate-50"
                                                    data-id="{{ $driver->id }}"
                                                    data-name="{{ $driver->username }}"
                                                >
                                                    {{ $driver->username }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>

                                {{-- Vehicle Searchable Select inside Table --}}
                                <td class="px-5 py-4 relative">
                                    <div class="vehicle-inline-container relative">
                                        <input
                                            type="text"
                                            class="vehicle-search-input w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none"
                                            placeholder="Search vehicle..."
                                            value="{{ $schedule->vehicle->vehicle_number ?? '' }}"
                                            autocomplete="off"
                                        >
                                        <input type="hidden" name="vehicle_id" class="vehicle-id-input" value="{{ $schedule->vehicle_id }}">

                                        <div class="vehicle-dropdown-list hidden absolute z-30 mt-1 max-h-40 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white shadow-lg">
                                            @foreach ($vehicles as $vehicle)
                                                <div
                                                    class="vehicle-option cursor-pointer px-3 py-2 text-sm hover:bg-slate-50"
                                                    data-id="{{ $vehicle->id }}"
                                                    data-name="{{ $vehicle->vehicle_number }}"
                                                >
                                                    {{ $vehicle->vehicle_number }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 font-medium text-slate-700">
                                    {{ $schedule->route_date }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($schedule->complete == 1)
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            Completed
                                        </span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <button
                                            type="submit"
                                            class="rounded-lg bg-[var(--navy)] px-3 py-2 text-xs font-semibold text-white hover:opacity-90"
                                        >
                                            Assign
                                        </button>

                                        <button
                                            type="button"
                                            onclick='openEditModal(@json($schedule))'
                                            class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-[var(--navy)] text-xs font-medium"
                                        >
                                            Edit Date
                                        </button>

                                        <button
                                            type="submit"
                                            form="delete-form-{{ $schedule->id }}"
                                            class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-500 text-xs font-medium"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </form>

                        <form id="delete-form-{{ $schedule->id }}" method="POST" action="{{ route('admin.route-schedules.destroy', $schedule->id) }}" onsubmit="return confirm('Delete this schedule?');">
                            @csrf
                            @method('DELETE')
                        </form>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center text-slate-500">
                                <p class="font-semibold">No route schedules found</p>
                                <p class="mt-1 text-sm text-slate-400">Create your first schedule or change the filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-5 py-4">
            {{ $schedules->links() }}
        </div>
    </div>
</div>

{{-- Modal --}}
<div
    id="scheduleModal"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm"
>
    <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 id="scheduleModalTitle" class="text-lg font-bold text-[var(--navy)]">Add New Schedule</h3>
                <p class="text-sm text-slate-500">Configure the route schedule information.</p>
            </div>
            <button type="button" onclick="closeScheduleModal()" class="text-slate-400">✕</button>
        </div>

        <form id="routeScheduleForm" method="POST" action="{{ route('admin.route-schedules.store') }}">
            @csrf
            <div id="methodField"></div>

            <div class="max-h-[70vh] space-y-4 overflow-y-auto px-6 py-5">
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Route Name</label>
                    <select id="route_id" name="route_id" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm" required>
                        <option value="">-- Choose Route --</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}">
                                {{ $route->route_name }} ({{ $route->departure?->name }} → {{ $route->arrival?->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="dateRangeContainer" class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-600 block mb-1.5">From Date</label>
                        <input id="from_date" name="from_date" type="date" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600 block mb-1.5">To Date</label>
                        <input id="to_date" name="to_date" type="date" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm">
                    </div>
                </div>

                <div id="singleDateContainer" class="hidden">
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Route Date</label>
                    <input id="route_date" name="route_date" type="date" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm">
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Complete Status</label>
                    <select id="complete" name="complete" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm" required>
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" onclick="closeScheduleModal()" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600">Cancel</button>
                <button id="scheduleSubmitButton" type="submit" class="grad-a flex-1 rounded-xl py-2.5 text-sm font-semibold text-white">Save Schedule</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- Modal Management Scripts ---
    const scheduleModal = document.getElementById('scheduleModal');
    const scheduleForm = document.getElementById('routeScheduleForm');
    const methodField = document.getElementById('methodField');
    const scheduleModalTitle = document.getElementById('scheduleModalTitle');
    const scheduleSubmitButton = document.getElementById('scheduleSubmitButton');
    const dateRangeContainer = document.getElementById('dateRangeContainer');
    const singleDateContainer = document.getElementById('singleDateContainer');

    function showScheduleModal() {
        scheduleModal.classList.remove('hidden');
        scheduleModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    window.closeScheduleModal = function () {
        scheduleModal.classList.add('hidden');
        scheduleModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    };

    window.openCreateModal = function () {
        scheduleForm.reset();
        scheduleForm.action = "{{ route('admin.route-schedules.store') }}";
        methodField.innerHTML = '';
        dateRangeContainer.classList.remove('hidden');
        singleDateContainer.classList.add('hidden');
        scheduleModalTitle.textContent = 'Add New Schedule';
        scheduleSubmitButton.textContent = 'Add Schedule';
        showScheduleModal();
    };

    window.openEditModal = function (schedule) {
        scheduleForm.reset();
        scheduleForm.action = "/admin/route-schedules/" + schedule.id;
        methodField.innerHTML = '@method("PUT")';
        document.getElementById('route_id').value = schedule.route_id;
        document.getElementById('route_date').value = schedule.route_date || '';
        document.getElementById('complete').value = schedule.complete ?? 0;
        dateRangeContainer.classList.add('hidden');
        singleDateContainer.classList.remove('hidden');
        scheduleModalTitle.textContent = 'Edit Route Date';
        scheduleSubmitButton.textContent = 'Save Changes';
        showScheduleModal();
    };

    // --- Filter Section Searchable: Route Name ---
    const filterRouteContainer = document.getElementById('routeFilterContainer');
    if (filterRouteContainer) {
        const input = filterRouteContainer.querySelector('#filterRouteInput');
        const hiddenId = filterRouteContainer.querySelector('#filterRouteId');
        const dropdown = filterRouteContainer.querySelector('#filterRouteDropdown');
        const options = filterRouteContainer.querySelectorAll('.filter-route-option');

        input.addEventListener('focus', () => dropdown.classList.remove('hidden'));
        input.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            dropdown.classList.remove('hidden');
            hiddenId.value = ''; // clear ID if typing freely
            options.forEach(opt => {
                const name = opt.getAttribute('data-name').toLowerCase();
                opt.style.display = name.includes(term) ? 'block' : 'none';
            });
        });

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                input.value = opt.getAttribute('data-name');
                hiddenId.value = opt.getAttribute('data-id');
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', (e) => {
            if (!filterRouteContainer.contains(e.target)) dropdown.classList.add('hidden');
        });
    }

    // --- Filter Section Searchable: Driver Name ---
    const filterDriverContainer = document.getElementById('driverFilterContainer');
    if (filterDriverContainer) {
        const input = filterDriverContainer.querySelector('#filterDriverInput');
        const hiddenName = filterDriverContainer.querySelector('#filterDriverNameHidden');
        const dropdown = filterDriverContainer.querySelector('#filterDriverDropdown');
        const options = filterDriverContainer.querySelectorAll('.filter-driver-option');

        input.addEventListener('focus', () => dropdown.classList.remove('hidden'));
        input.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            dropdown.classList.remove('hidden');
            hiddenName.value = e.target.value;
            options.forEach(opt => {
                const name = opt.getAttribute('data-name').toLowerCase();
                opt.style.display = name.includes(term) ? 'block' : 'none';
            });
        });

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                const val = opt.getAttribute('data-name');
                input.value = val;
                hiddenName.value = val;
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', (e) => {
            if (!filterDriverContainer.contains(e.target)) dropdown.classList.add('hidden');
        });
    }

    // --- Table Rows Inline Searchable: Driver ---
    document.querySelectorAll('.driver-inline-container').forEach(container => {
        const input = container.querySelector('.driver-search-input');
        const hiddenId = container.querySelector('.driver-id-input');
        const dropdown = container.querySelector('.driver-dropdown-list');
        const options = container.querySelectorAll('.driver-option');

        input.addEventListener('focus', () => dropdown.classList.remove('hidden'));
        input.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            dropdown.classList.remove('hidden');
            hiddenId.value = '';
            options.forEach(opt => {
                const name = opt.getAttribute('data-name').toLowerCase();
                opt.style.display = name.includes(term) ? 'block' : 'none';
            });
        });

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                input.value = opt.getAttribute('data-name');
                hiddenId.value = opt.getAttribute('data-id');
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) dropdown.classList.add('hidden');
        });
    });

    // --- Table Rows Inline Searchable: Vehicle ---
    document.querySelectorAll('.vehicle-inline-container').forEach(container => {
        const input = container.querySelector('.vehicle-search-input');
        const hiddenId = container.querySelector('.vehicle-id-input');
        const dropdown = container.querySelector('.vehicle-dropdown-list');
        const options = container.querySelectorAll('.vehicle-option');

        input.addEventListener('focus', () => dropdown.classList.remove('hidden'));
        input.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            dropdown.classList.remove('hidden');
            hiddenId.value = '';
            options.forEach(opt => {
                const name = opt.getAttribute('data-name').toLowerCase();
                opt.style.display = name.includes(term) ? 'block' : 'none';
            });
        });

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                input.value = opt.getAttribute('data-name');
                hiddenId.value = opt.getAttribute('data-id');
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) dropdown.classList.add('hidden');
        });
    });

    // Close Modal on backdrop click or Escape key
    scheduleModal.addEventListener('click', (event) => {
        if (event.target === scheduleModal) closeScheduleModal();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !scheduleModal.classList.contains('hidden')) {
            closeScheduleModal();
        }
    });
});
</script>
@endpush