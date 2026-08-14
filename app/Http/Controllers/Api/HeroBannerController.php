<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HeroBannerResource;
use App\Models\HeroBanner;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class HeroBannerController extends Controller
{
    public function show(): JsonResponse
    {
        $heroBanner = HeroBanner::query()->latest()->first();

        if (! $heroBanner) {
            return ApiResponse::error('Hero banner not found.', 404);
        }

        return ApiResponse::success(
            new HeroBannerResource($heroBanner),
            'Hero banner retrieved successfully.',
        );
    }
}
