<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteManagement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RouteManagementController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.route-management.index', $this->indexData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        RouteManagement::create($this->validatedData($request));

        return redirect()->route('admin.route-management.index')
            ->with('success', 'Route created successfully.');
    }

    public function edit(Request $request, RouteManagement $routeManagement): View
    {
        return view('admin.route-management.index', $this->indexData($request, $routeManagement));
    }

    public function update(Request $request, RouteManagement $routeManagement): RedirectResponse
    {
        $routeManagement->update($this->validatedData($request));

        return redirect()->route('admin.route-management.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(RouteManagement $routeManagement): RedirectResponse
    {
        $routeManagement->delete();

        return redirect()->route('admin.route-management.index')
            ->with('success', 'Route deleted successfully.');
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

        if ($data['action'] === 'delete') {
            $routes->delete();
        } elseif ($data['action'] === 'active') {
            $routes->update(['status' => 'Active']);
        } else {
            $routes->update(['status' => 'Inactive']);
        }

        return back()->with('success', 'Bulk action completed successfully.');
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'route-management-'.now()->format('Y-m-d-His').'.csv';
        $query = $this->filteredQuery($request)->orderBy('name');

        return response()->streamDownload(function () use ($query): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['Route', 'Origin', 'Destination', 'Distance (km)', 'Type', 'Status', 'Created']);

            $query->chunkById(200, function ($routes) use ($stream): void {
                foreach ($routes as $route) {
                    fputcsv($stream, [
                        $route->name,
                        $route->origin,
                        $route->destination,
                        $route->distance,
                        $route->type,
                        $route->status,
                        $route->created_at?->format('Y-m-d'),
                    ]);
                }
            });

            fclose($stream);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function indexData(Request $request, ?RouteManagement $selectedRoute = null): array
    {
        $sort = $request->query('sort', 'name');
        $direction = $request->query('direction', 'asc');
        $sortColumns = [
            'name' => 'name',
            'origin' => 'origin',
            'destination' => 'destination',
            'distance' => 'distance',
            'status' => 'status',
            'created' => 'created_at',
        ];
        $sortColumn = $sortColumns[$sort] ?? 'name';
        $direction = $direction === 'desc' ? 'desc' : 'asc';
        $perPage = (int) $request->query('per_page', 10);
        if (! in_array($perPage, [8, 10, 20, 50], true)) {
            $perPage = 10;
        }

        $routes = $this->filteredQuery($request)
            ->orderBy($sortColumn, $direction)
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();

        return [
            'routes' => $routes,
            'selectedRoute' => $selectedRoute,
            'stats' => [
                'total' => RouteManagement::count(),
                'active' => RouteManagement::query()->where('status', 'Active')->count(),
                'inactive' => RouteManagement::query()->where('status', 'Inactive')->count(),
                'pending' => RouteManagement::query()->where('status', 'Pending')->count(),
            ],
            'sort' => $sort,
            'direction' => $direction,
            'perPage' => $perPage,
        ];
    }

    private function filteredQuery(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');
        $type = $request->query('type');

        return RouteManagement::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('origin', 'like', "%{$search}%")
                        ->orWhere('destination', 'like', "%{$search}%");
                });
            })
            ->when(in_array($status, ['Active', 'Inactive', 'Pending'], true), fn ($query) => $query->where('status', $status))
            ->when(in_array($type, ['City', 'Regional', 'Express'], true), fn ($query) => $query->where('type', $type));
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'origin' => ['required', 'string', 'max:255', 'min:2'],
            'destination' => ['required', 'string', 'max:255', 'min:2'],
            'distance' => ['required', 'numeric', 'min:1'],
            'type' => ['required', 'in:City,Regional,Express'],
            'status' => ['required', 'in:Active,Inactive,Pending'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}