<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    // 1. ခရီးစဉ်များစာရင်း Blade View ပြသရန်
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $routes = Route::latest()->paginate($perPage);

        return view('admin.routes.index', compact('routes'));
    }

    // 2. ခရီးစဉ်အသစ် ထည့်သွင်းသည့် Form Blade View ပြသရန်
    public function create()
    {
        return view('admin.routes.create');
    }

    // 3. ခရီးစဉ်အသစ် သိမ်းဆည်းရန်
    public function store(Request $request)
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
                         ->with('success', 'ခရီးစဉ်အသစ် အောင်မြင်စွာ ဖန်တီးပြီးပါပြီ။');
    }

    // 4. ခရီးစဉ် အသေးစိတ် Blade View ပြသရန်
    public function show(Route $route)
    {
        return view('admin.routes.show', compact('route'));
    }

    // 5. ခရီးစဉ် ပြင်ဆင်သည့် Form Blade View ပြသရန်
    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    // 6. ခရီးစဉ် ပြင်ဆင်ချက်များကို Update လုပ်ရန်
    public function update(Request $request, Route $route)
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
                         ->with('success', 'ခရီးစဉ် အချက်အလက်များ ပြင်ဆင်ပြီးပါပြီ။');
    }

    // 7. ခရီးစဉ်ကို ဖျက်ရန်
    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('admin.routes.index')
                         ->with('success', 'ခရီးစဉ်ကို ဖျက်ပြီးပါပြီ။');
    }
}