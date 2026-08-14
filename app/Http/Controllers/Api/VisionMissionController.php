<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisionMissionResource;
use App\Models\VisionMission;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class VisionMissionController extends Controller
{
    public function show(): JsonResponse
    {
        $visionMission = VisionMission::query()->first();

        if (! $visionMission) {
            return ApiResponse::error(
                'Vision and mission content not found.',
                404
            );
        }

        return ApiResponse::success(
            new VisionMissionResource($visionMission),
            'Vision and mission retrieved successfully.'
        );
    }
}