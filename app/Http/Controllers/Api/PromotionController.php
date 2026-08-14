<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller
{
    public function index(): JsonResponse
    {
        $promotions = Promotion::query()
            ->latest()
            ->get();

        return ApiResponse::success(
            PromotionResource::collection($promotions),
            'Promotions retrieved successfully.'
        );
    }
}
