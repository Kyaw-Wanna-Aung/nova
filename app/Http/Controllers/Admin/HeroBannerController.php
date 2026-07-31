<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function show(): RedirectResponse
    {
        return redirect()->route('promotions.index');
    }

    public function edit(): RedirectResponse
    {
        return redirect()->route('admin.promotions.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $banner = HeroBanner::query()->firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'hero_category' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'hero_promo_code' => ['nullable', 'string', 'max:255'],
            'hero_badge_1_title' => ['nullable', 'string', 'max:255'],
            'hero_badge_1_sub' => ['nullable', 'string', 'max:255'],
            'hero_badge_2_title' => ['nullable', 'string', 'max:255'],
            'hero_badge_2_sub' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'hero_card_title' => ['nullable', 'string', 'max:255'],
            'hero_card_description' => ['nullable', 'string'],
        ]);

        $data = [
            'category' => $validated['hero_category'] ?? null,
            'title' => $validated['hero_title'],
            'description' => $validated['hero_description'] ?? null,
            'promo_code' => $validated['hero_promo_code'] ?? null,
            'badge_1_title' => $validated['hero_badge_1_title'] ?? null,
            'badge_1_sub' => $validated['hero_badge_1_sub'] ?? null,
            'badge_2_title' => $validated['hero_badge_2_title'] ?? null,
            'badge_2_sub' => $validated['hero_badge_2_sub'] ?? null,
            'card_title' => $validated['hero_card_title'] ?? null,
            'card_description' => $validated['hero_card_description'] ?? null,
        ];

        if ($request->hasFile('hero_image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $data['image'] = $request->file('hero_image')->store('hero-banners', 'public');
        }

        $banner->update($data);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Hero banner updated successfully.');
    }
}


