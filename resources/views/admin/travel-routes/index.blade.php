@extends('layouts.admin')

@section('title', 'Route Management')
@section('page_title', 'Route Management')
@section(
    'page_subtitle',
    'Manage routes shared by the website and mobile application.'
)

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

    {{-- Filters --}}
    <div class="card p-5">
        <form
            method="GET"
            action="{{ route('admin.route-management.index') }}"
            class="grid gap-3 md:grid-cols-4"
        >
            <div>
                <label class="text-xs font-semibold text-slate-500">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Route or township..."
                    class="mt-1.5 w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none"
                >
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-500">
                    Departure
                </label>

                <select
                    name="departure_id"
                    class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm"
                >
                    <option value="">All departures</option>

                    @foreach ($townships as $township)
                        <option
                            value="{{ $township->id }}"
                            @selected(
                                (string) request('departure_id')
                                === (string) $township->id
                            )
                        >
                           {{ $township->name }}
({{ $township->mm_name }})
— {{ $township->region_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-500">
                    Arrival
                </label>

                <select
                    name="arrival_id"
                    class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm"
                >
                    <option value="">All arrivals</option>

                    @foreach ($townships as $township)
                        <option
                            value="{{ $township->id }}"
                            @selected(
                                (string) request('arrival_id')
                                === (string) $township->id
                            )
                        >
                            {{ $township->name }}
                            ({{ $township->mm_name }})
                        </option>
                    @endforeach
                </select>
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

                        @php
    $routeEditData = [
        'id' => $route->id,
        'route_name' => $route->route_name,
        'departure_id' => $route->departure_id,
        'arrival_id' => $route->arrival_id,
        'distance' => $route->distance,
        'estimated_time' => $route->estimated_time,
        'route_time' => $route->route_time,
        'discount' => $route->discount,
    ];
@endphp
<button
    type="button"
    class="edit-route-btn rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-[var(--navy)]"
    data-update-url="{{ route('admin.route-management.update', $route) }}"
    data-id="{{ $route->id }}"
    data-route-name="{{ $route->route_name }}"
    data-departure-id="{{ $route->departure_id }}"
    data-arrival-id="{{ $route->arrival_id }}"
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

                    <div>
                        <label class="text-sm font-medium text-slate-600">
                            Departure Township
                        </label>

                        <select
                            id="departure_id"
                            name="departure_id"
                            class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm"
                            required
                        >
                            <option value="">
                                Select departure
                            </option>

                            @foreach ($townships as $township)
                                <option value="{{ $township->id }}">
                                  {{ $township->name }}
({{ $township->mm_name }})
— {{ $township->region_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-600">
                            Arrival Township
                        </label>

                        <select
                            id="arrival_id"
                            name="arrival_id"
                            class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm"
                            required
                        >
                            <option value="">
                                Select arrival
                            </option>

                            @foreach ($townships as $township)
                                <option value="{{ $township->id }}">
                                 {{ $township->name }}
({{ $township->mm_name }})
— {{ $township->region_name }}
                                </option>
                            @endforeach
                        </select>
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
document.addEventListener('DOMContentLoaded', () => {
    const routeModal = document.getElementById('routeModal');
    const routeForm = document.getElementById('travelRouteForm');
    const routeFormMethod = document.getElementById('routeFormMethod');
    const routeModalTitle = document.getElementById('routeModalTitle');
    const routeSubmitButton = document.getElementById('routeSubmitButton');

    const routeStoreUrl = @json(
        route('admin.route-management.store')
    );

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

        routeForm.action = routeStoreUrl;
        routeFormMethod.value = 'POST';

        routeModalTitle.textContent = 'Add Route';
        routeSubmitButton.textContent = 'Add Route';

        document.getElementById('discount').value = '0';

        showRouteModal();
    };

    function openEditModal(button) {
        document.getElementById('route_name').value =
            button.dataset.routeName ?? '';

        document.getElementById('departure_id').value =
            button.dataset.departureId ?? '';

        document.getElementById('arrival_id').value =
            button.dataset.arrivalId ?? '';

        document.getElementById('distance').value =
            button.dataset.distance ?? '';

        document.getElementById('estimated_time').value =
            button.dataset.estimatedTime ?? '';

        const routeTime = button.dataset.routeTime ?? '';

        document.getElementById('route_time').value =
            routeTime.substring(0, 5);

        document.getElementById('discount').value =
            button.dataset.discount ?? '0';

        // IMPORTANT:
        // Use the Laravel-generated update URL directly.
        routeForm.action = button.dataset.updateUrl;

        // Laravel method spoofing:
        // browser sends POST + _method=PUT
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

    routeModal.addEventListener('click', (event) => {
        if (event.target === routeModal) {
            closeRouteModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape' &&
            !routeModal.classList.contains('hidden')
        ) {
            closeRouteModal();
        }
    });
});
</script>
@endpush