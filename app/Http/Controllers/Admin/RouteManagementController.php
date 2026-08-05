<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteManagement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RouteManagementController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.route-management.index', $this->indexData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        RouteManagement::create($this->routeData($request));

        return redirect()->route('admin.route-management.index')->with('success', 'Route created successfully.');
    }

    public function edit(Request $request, RouteManagement $routeManagement): View
    {
        return view('admin.route-management.index', $this->indexData($request, $routeManagement));
    }

    public function update(Request $request, RouteManagement $routeManagement): RedirectResponse
    {
        $routeManagement->update($this->routeData($request, $routeManagement));

        return redirect()->route('admin.route-management.index')->with('success', 'Route updated successfully.');
    }

    public function destroy(RouteManagement $routeManagement): RedirectResponse
    {
        $routeManagement->delete();

        return redirect()->route('admin.route-management.index')->with('success', 'Route deleted successfully.');
    }

    public function changeStatus(Request $request, RouteManagement $routeManagement): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:Active,Inactive,Pending']]);
        $routeManagement->update($data);

        return back()->with('success', 'Route status updated successfully.');
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:route_managements,id'],
            'action' => ['required', 'in:delete,active,inactive'],
        ]);

        $routes = RouteManagement::query()->whereIn('id', $data['ids']);
        match ($data['action']) {
            'delete' => $routes->delete(),
            'active' => $routes->update(['status' => 'Active']),
            default => $routes->update(['status' => 'Inactive']),
        };

        return back()->with('success', 'Bulk action completed successfully.');
    }

    public function export(Request $request): StreamedResponse
    {
        return response()->streamDownload(function () use ($request): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['Route', 'From', 'To', 'Category', 'Seats', 'Departure date', 'Departure time', 'Fare', 'Status']);
            $this->filteredQuery($request)->orderBy('departure_date')->chunkById(200, function ($routes) use ($stream): void {
                foreach ($routes as $route) {
                    fputcsv($stream, [$route->name, $route->from_location, $route->to_location, $route->category, $route->available_seats, $route->departure_date?->format('Y-m-d'), $route->departure_time, $route->fare, $route->status]);
                }
            });
            fclose($stream);
        }, 'route-management-'.now()->format('Y-m-d-His').'.csv', ['Content-Type' => 'text/csv']);
    }

    private function indexData(Request $request, ?RouteManagement $selectedRoute = null): array
    {
        $sort = $request->query('sort', 'name');
        $sortColumn = [
            'name' => 'name', 'origin' => 'from_location', 'destination' => 'to_location',
            'distance' => 'distance', 'status' => 'status', 'created' => 'created_at',
        ][$sort] ?? 'name';
        $direction = $request->query('direction') === 'desc' ? 'desc' : 'asc';
        $perPage = in_array((int) $request->query('per_page', 10), [8, 10, 20, 50], true) ? (int) $request->query('per_page', 10) : 10;

        return [
            'routes' => $this->filteredQuery($request)->orderBy($sortColumn, $direction)->orderBy('id')->paginate($perPage)->withQueryString(),
            'selectedRoute' => $selectedRoute,
            'stats' => [
                'total' => RouteManagement::count(),
                'active' => RouteManagement::where('status', 'Active')->count(),
                'inactive' => RouteManagement::where('status', 'Inactive')->count(),
                'pending' => RouteManagement::where('status', 'Pending')->count(),
            ],
            'sort' => $sort, 'direction' => $direction, 'perPage' => $perPage,
        ];
    }

    private function filteredQuery(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        return RouteManagement::query()
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('from_location', 'like', "%{$search}%")->orWhere('to_location', 'like', "%{$search}%")->orWhere('origin', 'like', "%{$search}%")->orWhere('destination', 'like', "%{$search}%")))
            ->when(in_array($request->query('status'), ['Active', 'Inactive', 'Pending'], true), fn ($query) => $query->where('status', $request->query('status')))
            ->when(in_array($request->query('category'), ['Nova Executive', 'Nova Space+', 'Nova Signature'], true), fn ($query) => $query->where('category', $request->query('category')));
    }

    private function routeData(Request $request, ?RouteManagement $routeManagement = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'from_location' => ['required', 'string', 'min:2', 'max:255'],
            'to_location' => ['required', 'string', 'min:2', 'max:255'],
            'distance' => ['nullable', 'numeric', 'min:0'],
            'category' => ['required', 'in:Nova Executive,Nova Space+,Nova Signature'],
            'available_seats' => ['required', 'integer', 'min:0'],
            'departure_date' => ['required', 'date'],
            'departure_time' => ['required', 'date_format:H:i'],
            'fare' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:5120'],
            'status' => ['required', 'in:Active,Inactive,Pending'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('routes', 'public');
        } elseif ($routeManagement !== null) {
            $data['image'] = $routeManagement->image;
        }

        // Retain legacy columns only to keep records created before this migration readable.
        $data['origin'] = $data['from_location'];
        $data['destination'] = $data['to_location'];
        $data['type'] = $data['category'];
        $data['distance'] = $data['distance'] ?? 0;

        return $data;
    }
}
