<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RouteManagement;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request): View
    {
        $active = RouteManagement::query()->where('status', 'Active');

        $routes = $this->matchingRoutes($request)
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->paginate(12);

        $testimonials = Testimonial::query()
            ->where('status', 'Active')
            ->orderBy('display_order')
            ->latest('id')
            ->get();

        return view('user.our-routes', [
            'routes' => $routes,
            'origins' => (clone $active)->whereNotNull('from_location')->distinct()->orderBy('from_location')->pluck('from_location'),
            'destinations' => (clone $active)->whereNotNull('to_location')->distinct()->orderBy('to_location')->pluck('to_location'),
            'testimonials' => $testimonials,
        ]);
    }

    private function matchingRoutes(Request $request)
    {
        return RouteManagement::query()->where('status', 'Active')
            ->when($request->filled('from'), fn ($q) => $q->where('from_location', 'like', '%'.$request->string('from').'%'))
            ->when($request->filled('to'), fn ($q) => $q->where('to_location', 'like', '%'.$request->string('to').'%'))
            ->when($request->filled('date'), fn ($q) => $q->whereDate('departure_date', $request->date('date')))
            ->when($request->filled('passengers'), fn ($q) => $q->where('available_seats', '>=', (int) $request->input('passengers')))
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($sub) => $sub->where('name', 'like', '%'.$request->string('search').'%')->orWhere('from_location', 'like', '%'.$request->string('search').'%')->orWhere('to_location', 'like', '%'.$request->string('search').'%')));
    }
}