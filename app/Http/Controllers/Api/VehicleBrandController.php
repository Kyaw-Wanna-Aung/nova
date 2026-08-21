<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleBrandRequest;
use App\Http\Requests\UpdateVehicleBrandRequest;
use App\Models\VehicleBrand;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $brands = VehicleBrand::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return ApiResponse::success(
            $brands->items(),
            'Vehicle brands retrieved successfully.',
            additional: [
                'meta' => [
                    'current_page' => $brands->currentPage(),
                    'last_page' => $brands->lastPage(),
                    'per_page' => $brands->perPage(),
                    'total' => $brands->total(),
                ],
            ],
        );
    }

    public function store(StoreVehicleBrandRequest $request): JsonResponse
    {
        $brand = VehicleBrand::create($request->validated());

        return ApiResponse::success(
            $brand,
            'Vehicle brand created successfully.',
            201,
        );
    }

    public function update(
        UpdateVehicleBrandRequest $request,
        VehicleBrand $vehicleBrand
    ): JsonResponse {
        $vehicleBrand->update($request->validated());

        return ApiResponse::success(
            $vehicleBrand->fresh(),
            'Vehicle brand updated successfully.',
        );
    }

    public function destroy(VehicleBrand $vehicleBrand): JsonResponse
    {
        $vehicleBrand->delete();

        return ApiResponse::success(
            null,
            'Vehicle brand deleted successfully.',
        );
    }
}