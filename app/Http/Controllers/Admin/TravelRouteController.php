<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Township;
use App\Models\TravelRoute;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TravelRouteController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $routes = TravelRoute::query()
            ->with(['departure', 'arrival'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('route_name', 'like', "%{$search}%")
                        ->orWhereHas('departure', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('mm_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('arrival', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('mm_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(
                $request->filled('departure_id'),
                fn ($query) => $query->where(
                    'departure_id',
                    $request->integer('departure_id')
                )
            )
            ->when(
                $request->filled('arrival_id'),
                fn ($query) => $query->where(
                    'arrival_id',
                    $request->integer('arrival_id')
                )
            )
            ->orderBy('route_name')
            ->paginate(10)
            ->withQueryString();

        $townships = Township::query()
            ->orderBy('name')
            ->get();

        return view('admin.travel-routes.index', [
            'routes' => $routes,
            'townships' => $townships,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        TravelRoute::create($data);

        return redirect()
            ->route('admin.route-management.index')
            ->with('success', 'Route created successfully.');
    }

    public function update(
        Request $request,
        TravelRoute $travelRoute
    ): RedirectResponse {
        $data = $this->validatedData($request, $travelRoute);

        $travelRoute->update($data);

        return redirect()
            ->route('admin.route-management.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(
        TravelRoute $travelRoute
    ): RedirectResponse {
        $travelRoute->delete();

        return redirect()
            ->route('admin.route-management.index')
            ->with('success', 'Route deleted successfully.');
    }

    private function validatedData(
        Request $request,
        ?TravelRoute $travelRoute = null
    ): array {
        return $request->validate([
            'route_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],

            'departure_id' => [
                'required',
                'integer',
                'exists:townships,id',
                'different:arrival_id',
            ],

            'arrival_id' => [
                'required',
                'integer',
                'exists:townships,id',
                'different:departure_id',
            ],

            'distance' => [
                'required',
                'numeric',
                'min:0',
            ],

            // Stored as minutes.
            'estimated_time' => [
                'required',
                'integer',
                'min:1',
                'max:10080',
            ],

            'route_time' => [
                'required',
                'date_format:H:i',
            ],

            'discount' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ], [
            'departure_id.different' =>
                'Departure and arrival townships must be different.',

            'arrival_id.different' =>
                'Arrival and departure townships must be different.',

            'estimated_time.max' =>
                'Estimated travel time may not exceed 7 days.',
        ]);
    }
}