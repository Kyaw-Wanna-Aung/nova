<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleModelRequest;
use App\Http\Requests\UpdateVehicleModelRequest;
use App\Models\VehicleModel;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));
        $brandId = $request->query('vehicle_brand_id');

        $models = VehicleModel::query()
            ->with('brand')
            ->when(
                $brandId,
                fn ($query) =>
                    $query->where('vehicle_brand_id', $brandId)
            )
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return ApiResponse::success(
            $models->items(),
            'Vehicle models retrieved successfully.',
            additional: [
                'meta' => [
                    'current_page' => $models->currentPage(),
                    'last_page' => $models->lastPage(),
                    'per_page' => $models->perPage(),
                    'total' => $models->total(),
                ],
            ],
        );
    }

    public function store(
        StoreVehicleModelRequest $request
    ): JsonResponse {
        $vehicleModel = VehicleModel::create(
            $request->validated()
        );

        $vehicleModel->load('brand');

        return ApiResponse::success(
            $vehicleModel,
            'Vehicle model created successfully.',
            201,
        );
    }

    public function update(
        UpdateVehicleModelRequest $request,
        VehicleModel $vehicleModel
    ): JsonResponse {
        $vehicleModel->update(
            $request->validated()
        );

        $vehicleModel->load('brand');

        return ApiResponse::success(
            $vehicleModel,
            'Vehicle model updated successfully.',
        );
    }

    public function destroy(
        VehicleModel $vehicleModel
    ): JsonResponse {
        $vehicleModel->delete();

        return ApiResponse::success(
            null,
            'Vehicle model deleted successfully.',
        );
    }
}