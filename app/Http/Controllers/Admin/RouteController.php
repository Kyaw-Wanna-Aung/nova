<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        if (! in_array($perPage, [8, 10, 20, 50], true)) {
            $perPage = 10;
        }

        $search = trim((string) $request->query('search', ''));
        $sort = $request->query('sort', 'date');
        $direction = $request->query('direction', 'desc');
        $sortColumns = [
            'category' => 'category',
            'origin' => 'origin',
            'destination' => 'destination',
            'seats' => 'available_seats',
            'date' => 'date',
            'time' => 'time',
            'price' => 'price',
            'created' => 'created_at',
        ];
        $sortColumn = $sortColumns[$sort] ?? 'date';
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $category = $request->query('category', 'all');

        $routes = Route::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('category', 'like', "%{$search}%")
                        ->orWhere('origin', 'like', "%{$search}%")
                        ->orWhere('destination', 'like', "%{$search}%");
                });
            })
            ->when($category !== 'all', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->orderBy($sortColumn, $direction)
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'origin'          => 'required|string|max:255',
            'destination'     => 'required|string|max:255',
            'available_seats' => 'required|integer|min:1',
            'date'            => 'required|date',
            'time'            => 'required',
            'price'           => 'required|numeric|min:0',
        ]);

        Route::create($validated);

        return redirect()->route('admin.routes.index')
                         ->with('success', 'Route created successfully.');
    }

    public function show(Route $route)
    {
        return view('admin.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route): RedirectResponse
    {
        $validated = $request->validate([
            'category'        => 'required|string|max:255',
            'origin'          => 'required|string|max:255',
            'destination'     => 'required|string|max:255',
            'available_seats' => 'required|integer|min:0',
            'date'            => 'required|date',
            'time'            => 'required',
            'price'           => 'required|numeric|min:0',
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')
                         ->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route): RedirectResponse
    {
        $route->delete();

        return redirect()->route('admin.routes.index')
                         ->with('success', 'Route deleted successfully.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:routes,id',
            'action' => 'required|string|in:Active,Inactive,Deleted',
        ]);

        $ids = $validated['ids'];
        $action = $validated['action'];
        $count = count($ids);

        if ($action === 'Deleted') {
            Route::query()->whereIn('id', $ids)->delete();
            return back()->with('success', "{$count} route(s) deleted successfully.");
        }

        return back()->with('info', "Status action ({$action}) is not applicable to travel routes.");
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'routes-'.now()->format('Y-m-d-His').'.csv';
        $search = trim((string) $request->query('search', ''));

        $query = Route::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('category', 'like', "%{$search}%")
                        ->orWhere('origin', 'like', "%{$search}%")
                        ->orWhere('destination', 'like', "%{$search}%");
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('time');

        return response()->streamDownload(function () use ($query): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['ID', 'Category', 'Origin', 'Destination', 'Seats', 'Date', 'Time', 'Price', 'Created']);

            $query->chunkById(200, function ($routes) use ($stream): void {
                foreach ($routes as $route) {
                    fputcsv($stream, [
                        $route->id,
                        $route->category,
                        $route->origin,
                        $route->destination,
                        $route->available_seats,
                        optional($route->date)->format('Y-m-d'),
                        $route->time,
                        number_format((float) $route->price, 2),
                        optional($route->created_at)->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($stream);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
