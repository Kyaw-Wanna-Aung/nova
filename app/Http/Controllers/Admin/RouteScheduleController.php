<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteSchedule;
use App\Models\TravelRoute;
use Illuminate\Http\Request;
use App\Models\NovapiDriverProfiles;
use App\Models\NovapiVehicle;
use Carbon\Carbon;

class RouteScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = RouteSchedule::with(['route', 'driver', 'vehicle'])->latest();

        // Route Name အလိုက် Filter စစ်ထုတ်ခြင်း
        if ($request->filled('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        // Driver Name အလိုက် Filter စစ်ထုတ်ခြင်း
        if ($request->filled('driver_name')) {
            $driverName = $request->driver_name;
            $query->whereHas('driver', function($q) use ($driverName) {
                $q->where('username', 'like', '%' . $driverName . '%');
            });
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('route_date', [$request->from, $request->to]);
        }

        $schedules = $query->paginate(10)->withQueryString();
        $routes = TravelRoute::all();
        $drivers = NovapiDriverProfiles::all();
        $vehicles = NovapiVehicle::all();

        return view('admin.route-schedules.index', compact('schedules', 'routes', 'drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:travel_routes,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'complete' => 'required|in:0,1',
        ]);

        $startDate = Carbon::parse($validated['from_date']);
        $endDate = Carbon::parse($validated['to_date']);

        while ($startDate <= $endDate) {
            RouteSchedule::create([
                'route_id' => $validated['route_id'],
                'driver_id' => null,   // Set null on creation; assigned via inline row
                'vehicle_id' => null,  // Set null on creation; assigned via inline row
                'route_date' => $startDate->toDateString(),
                'complete' => $validated['complete'],
            ]);
            $startDate->addDay();
        }

        return redirect()->route('admin.route-schedules.index')->with('success', 'Schedules created successfully.');
    }

    public function update(Request $request, RouteSchedule $routeSchedule)
    {
        // Validated fields for both inline assignment and modal date editing
        $validated = $request->validate([
            'route_id' => 'required|exists:travel_routes,id',
            'route_date' => 'required|date',
            'complete' => 'required|in:0,1',
            'driver_id' => 'nullable|exists:novapi_driverprofiles,id',
            'vehicle_id' => 'nullable|exists:novapi_vehicles,id',
        ]);

        $routeSchedule->update($validated);

        return redirect()->back()->with('success', 'Route schedule updated successfully.');
    }

    public function destroy(RouteSchedule $routeSchedule)
    {
        $routeSchedule->delete();

        return redirect()->route('admin.route-schedules.index')->with('success', 'Route schedule deleted successfully.');
    }
}