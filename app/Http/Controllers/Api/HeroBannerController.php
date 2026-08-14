<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HeroBannerResource;
use App\Models\HeroBanner;
use Illuminate\Http\JsonResponse;

class HeroBannerController extends Controller
{
    public function show(): JsonResponse
    {
        $heroBanner = HeroBanner::query()->latest()->first();

        if (!$heroBanner) {
            return response()->json([
                'success' => false,
                'message' => 'Hero banner not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Hero banner retrieved successfully.',
            'data' => new HeroBannerResource($heroBanner),
        ]);
    }
}