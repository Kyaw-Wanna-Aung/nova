<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::query()
            ->where('status', 'Active')
            ->orderByRaw('display_order IS NULL')
            ->orderBy('display_order')
            ->latest('id')
            ->get();

        return ApiResponse::success(
            TestimonialResource::collection($testimonials),
            'Testimonials retrieved successfully.',
        );
    }
}
