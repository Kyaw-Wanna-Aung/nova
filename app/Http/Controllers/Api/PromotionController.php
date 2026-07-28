<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    // Helper Method to Format Promotion Data with Full Image URL
    private function formatPromotion($promotion)
    {
        return [
            'id' => $promotion->id,
            'title' => $promotion->title,
            'description' => $promotion->description,
            'image' => $promotion->image ? asset('storage/' . $promotion->image) : null,
            'original_price' => $promotion->original_price,
            'discounted_price' => $promotion->discounted_price,
            'duration' => $promotion->duration,
            'daily_departures' => $promotion->daily_departures,
            'created_at' => $promotion->created_at,
            'updated_at' => $promotion->updated_at,
        ];
    }

    // 1. Get Promotions with Pagination
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $promotions = Promotion::latest()->paginate($perPage);

        // Transform collection to convert image path to Full URL
        $promotions->getCollection()->transform(function ($promotion) {
            return $this->formatPromotion($promotion);
        });

        return response()->json([
            'status' => 'success',
            'data' => $promotions
        ], 200);
    }

    // 2. Add Promotion Form (With File Upload)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'original_price' => 'required|numeric',
            'discounted_price' => 'required|numeric',
            'duration' => 'nullable|string',
            'daily_departures' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('promotions', 'public');
            $validated['image'] = $path;
        }

        $promotion = Promotion::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion created successfully.',
            'data' => $this->formatPromotion($promotion)
        ], 201);
    }

    // 3. Update Promotion (With File Upload & Old File Delete)
    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'original_price' => 'sometimes|numeric',
            'discounted_price' => 'sometimes|numeric',
            'duration' => 'nullable|string',
            'daily_departures' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
                Storage::disk('public')->delete($promotion->image);
            }

            // Store new image
            $path = $request->file('image')->store('promotions', 'public');
            $validated['image'] = $path;
        }

        $promotion->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion updated successfully.',
            'data' => $this->formatPromotion($promotion)
        ], 200);
    }

    // 4. Delete Promotion (Delete Image File too)
    public function destroy(Promotion $promotion)
    {
        if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
            Storage::disk('public')->delete($promotion->image);
        }

        $promotion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Promotion deleted successfully.'
        ], 200);
    }
}