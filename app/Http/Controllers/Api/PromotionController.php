<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;

class PromotionController extends Controller
{
    public function index(): JsonResponse
    {
        $promotions = Promotion::query()
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Promotions retrieved successfully.',
            'data' => PromotionResource::collection($promotions),
        ]);
    }
}