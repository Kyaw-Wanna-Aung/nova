<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RouteManagement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request): View
    {
        $sort = in_array($request->query('sort'), ['name', 'distance', 'type'], true) ? $request->query('sort') : 'name';
        $direction = $request->query('direction') === 'desc' ? 'desc' : 'asc';
        $routes = RouteManagement::query()
            ->where('status', 'Active')
            ->when($request->filled('from'), fn ($query) => $query->where('origin', 'like', '%'.$request->query('from').'%'))
            ->when($request->filled('to'), fn ($query) => $query->where('destination', 'like', '%'.$request->query('to').'%'))
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->query('type')))
            ->when($request->filled('search'), fn ($query) => $query->where(fn ($query) => $query->where('name', 'like', '%'.$request->query('search').'%')->orWhere('origin', 'like', '%'.$request->query('search').'%')->orWhere('destination', 'like', '%'.$request->query('search').'%')))
            ->orderBy($sort, $direction)
            ->get();

        return view('user.our-routes', [
            'routes' => $routes,
            'origins' => RouteManagement::query()->where('status', 'Active')->distinct()->orderBy('origin')->pluck('origin'),
            'destinations' => RouteManagement::query()->where('status', 'Active')->distinct()->orderBy('destination')->pluck('destination'),
            'types' => RouteManagement::query()->where('status', 'Active')->distinct()->orderBy('type')->pluck('type'),
        ]);
    }
}
