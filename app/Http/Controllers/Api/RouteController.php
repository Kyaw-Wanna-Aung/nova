<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Models\RouteManagement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $routes = RouteManagement::query()
            ->where('status', 'Active')
            ->when($request->filled('from'), function ($query) use ($request) {
                $query->where(
                    'from_location',
                    'like',
                    '%' . $request->string('from') . '%'
                );
            })
            ->when($request->filled('to'), function ($query) use ($request) {
                $query->where(
                    'to_location',
                    'like',
                    '%' . $request->string('to') . '%'
                );
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate(
                    'departure_date',
                    $request->input('date')
                );
            })
            ->when($request->filled('passengers'), function ($query) use ($request) {
                $query->where(
                    'available_seats',
                    '>=',
                    (int) $request->input('passengers')
                );
            })
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Routes retrieved successfully.',
            'data' => RouteResource::collection($routes),
        ]);
    }
}