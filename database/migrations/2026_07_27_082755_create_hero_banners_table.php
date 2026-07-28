<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner; // သင့် HeroBanner Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    // Helper function to format response with full image URL
    private function formatBanner($banner)
    {
        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'subtitle' => $banner->subtitle,
            'image' => $banner->image ? asset('storage/' . $banner->image) : null,
            'button_text' => $banner->button_text,
            'button_link' => $banner->button_link,
            'status' => $banner->status,
            'updated_at' => $banner->updated_at,
        ];
    }

    // Get Active Hero Banner
    public function show()
    {
        $banner = HeroBanner::first();

        return response()->json([
            'status' => 'success',
            'data' => $banner ? $this->formatBanner($banner) : null
        ], 200);
    }

    // Update Hero Banner (With File Upload & Old File Delete)
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072', // Max 3MB
            'button_text' => 'nullable|string',
            'button_link' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Get existing banner or create new if empty
        $banner = HeroBanner::first();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner && $banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Store new image in storage/app/public/banners
            $path = $request->file('image')->store('banners', 'public');
            $validated['image'] = $path;
        }

        if ($banner) {
            $banner->update($validated);
        } else {
            $banner = HeroBanner::create($validated);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Hero Banner updated successfully.',
            'data' => $this->formatBanner($banner)
        ], 200);
    }
}