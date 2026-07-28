<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // 1. Get All Routes with Pagination
    public function index(Request $request)
    {
        // Query Parameter ကနေ per_page ကို ယူမယ် (မပါရင် Default 10 ခုပြမယ်)
        $perPage = $request->get('per_page', 10);

        // get() အစား paginate() သို့ ပြောင်းလဲထားပါသည်
        $routes = Route::latest()->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $routes
        ], 200);
    }

    // 2. Create New Route
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'available_seats' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $route = Route::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'ခရီးစဉ်အသစ် အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။',
            'data' => $route
        ], 201);
    }

    // 3. Get Single Route
    public function show(Route $route)
    {
        return response()->json([
            'status' => 'success',
            'data' => $route
        ], 200);
    }

    // 4. Update Route
    public function update(Request $request, Route $route)
    {
        $validated = $request->validate([
            'category' => 'sometimes|string|max:255',
            'origin' => 'sometimes|string|max:255',
            'destination' => 'sometimes|string|max:255',
            'available_seats' => 'sometimes|integer|min:0',
            'date' => 'sometimes|date',
            'time' => 'sometimes',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $route->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'ခရီးစဉ် အချက်အလက်များ ပြင်ဆင်ပြီးပါပြီ။',
            'data' => $route
        ], 200);
    }

    // 5. Delete Route
    public function destroy(Route $route)
    {
        $route->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'ခရီးစဉ်ကို ဖျက်ပြီးပါပြီ။'
        ], 200);
    }
}