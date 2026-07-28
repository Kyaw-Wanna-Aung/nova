<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;

class HeroBannerController extends Controller
{
    // Banner အချက်အလက်ယူရန်
    public function show()
    {
        $banner = HeroBanner::first();
        return response()->json(['status' => 'success', 'data' => $banner], 200);
    }

    // Update Button နှိပ်လိုက်ပါက ပြင်ဆင်ရန်
public function update(Request $request)
{
    $banner = HeroBanner::firstOrCreate(['id' => 1]);

    $validated = $request->validate([
        'category' => 'nullable|string',
        'title' => 'required|string',
        'description' => 'nullable|string',
        'promo_code' => 'nullable|string',
        'badge_1_title' => 'nullable|string',
        'badge_1_sub' => 'nullable|string',
        'badge_2_title' => 'nullable|string',
        'badge_2_sub' => 'nullable|string',
        'image' => 'nullable|string',
        'card_title' => 'nullable|string',
        'card_description' => 'nullable|string',
    ]);

    $banner->update($validated);

    return response()->json([
        'status' => 'success',
        'message' => 'Hero Banner updated successfully.',
        'data' => $banner
    ], 200);
}
}