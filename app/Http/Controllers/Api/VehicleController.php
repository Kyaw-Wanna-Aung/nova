<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\NovapiVehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleHistory;
use App\Http\Requests\UpdateVehicleRequest;
use Illuminate\Support\Facades\Storage;
class VehicleController extends Controller
{
        public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));
        $approvalStatus = $request->query('approval_status');
        $status = $request->query('status');
        $brandId = $request->query('vehicle_brand_id');
        $modelId = $request->query('vehicle_model_id');

        $vehicles = NovapiVehicle::query()
            ->with([
                'brandInfo',
                'modelInfo',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('vehicle_number', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%");
                });
            })
            ->when(
                $approvalStatus,
                fn ($query) =>
                    $query->where('approval_status', $approvalStatus)
            )
            ->when(
                $status !== null,
                fn ($query) =>
                    $query->where('status', $status)
            )
            ->when(
                $brandId,
                fn ($query) =>
                    $query->where('vehicle_brand_id', $brandId)
            )
            ->when(
                $modelId,
                fn ($query) =>
                    $query->where('vehicle_model_id', $modelId)
            )
            ->latest()
            ->paginate(10);

        return ApiResponse::success(
            $vehicles->items(),
            'Vehicles retrieved successfully.',
            additional: [
                'meta' => [
                    'current_page' => $vehicles->currentPage(),
                    'last_page' => $vehicles->lastPage(),
                    'per_page' => $vehicles->perPage(),
                    'total' => $vehicles->total(),
                ],
            ],
        );
    }

    public function show(NovapiVehicle $vehicle): JsonResponse
    {
        $vehicle->load([
            'brandInfo',
            'modelInfo',
        ]);

        return ApiResponse::success(
            $vehicle,
            'Vehicle retrieved successfully.',
        );
    }
    public function store(StoreVehicleRequest $request): JsonResponse
    {
      
        $validated = $request->validated();

        $brand = VehicleBrand::findOrFail(
            $validated['vehicle_brand_id']
        );

        $model = VehicleModel::where(
            'vehicle_brand_id',
            $brand->id
        )->findOrFail(
            $validated['vehicle_model_id']
        );

        $vehicle = DB::transaction(function () use (
            $request,
            $validated,
            $brand,
            $model
        ) {
            $data = $validated;

            $data['brand'] = $brand->name;
            $data['model'] = $model->name;

            $fileFields = [
                'vehicle_photo',
                'front_photo',
                'insurance_certificate',
                'interior_photo',
                'owner_book',
                'side_photo',
                'vehicle_registration_certificate',
                'wheel_tax_receipt',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request
                        ->file($field)
                        ->store('vehicles/' . $field, 'public');
                }
            }

            return NovapiVehicle::create($data);
        });

        $vehicle->load([
            'brandInfo',
            'modelInfo',
        ]);
        VehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'action' => 'created',
            'old_values' => null,
            'new_values' => $vehicle->toArray(),
            'performed_by' => auth()->id(),
        ]);
        return ApiResponse::success(
            $vehicle,
            'Vehicle created successfully.',
            201,
        );
    }
        public function update(
        UpdateVehicleRequest $request,
        NovapiVehicle $vehicle
    ): JsonResponse {
        $validated = $request->validated();

        $oldValues = $vehicle->toArray();

        if (
            isset($validated['vehicle_brand_id']) ||
            isset($validated['vehicle_model_id'])
        ) {
            $brandId = $validated['vehicle_brand_id']
                ?? $vehicle->vehicle_brand_id;

            $modelId = $validated['vehicle_model_id']
                ?? $vehicle->vehicle_model_id;

            $brand = VehicleBrand::findOrFail($brandId);

            $model = VehicleModel::query()
                ->where('vehicle_brand_id', $brandId)
                ->findOrFail($modelId);

            // Keep the legacy string columns synchronized.
            $validated['brand'] = $brand->name;
            $validated['model'] = $model->name;
        }

        $fileFields = [
            'vehicle_photo',
            'front_photo',
            'insurance_certificate',
            'interior_photo',
            'owner_book',
            'side_photo',
            'vehicle_registration_certificate',
            'wheel_tax_receipt',
        ];

        foreach ($fileFields as $field) {
            if (! $request->hasFile($field)) {
                continue;
            }

            if (
                $vehicle->{$field} &&
                Storage::disk('public')->exists($vehicle->{$field})
            ) {
                Storage::disk('public')->delete($vehicle->{$field});
            }

            $validated[$field] = $request
                ->file($field)
                ->store('vehicles/' . $field, 'public');
        }

        $vehicle->update($validated);

        $vehicle->refresh();

        VehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'action' => 'updated',
            'old_values' => $oldValues,
            'new_values' => $vehicle->toArray(),
            'performed_by' => auth()->id(),
        ]);

        $vehicle->load([
            'brandInfo',
            'modelInfo',
        ]);

        return ApiResponse::success(
            $vehicle,
            'Vehicle updated successfully.',
        );
    }
    public function destroy(
        NovapiVehicle $vehicle
    ): JsonResponse {
        $fileFields = [
            'vehicle_photo',
            'front_photo',
            'insurance_certificate',
            'interior_photo',
            'owner_book',
            'side_photo',
            'vehicle_registration_certificate',
            'wheel_tax_receipt',
        ];

        $oldValues = $vehicle->toArray();
        $vehicleId = $vehicle->id;

        foreach ($fileFields as $field) {
            if (
                $vehicle->{$field} &&
                Storage::disk('public')->exists($vehicle->{$field})
            ) {
                Storage::disk('public')->delete($vehicle->{$field});
            }
        }

        VehicleHistory::create([
            'vehicle_id' => $vehicleId,
            'action' => 'deleted',
            'old_values' => $oldValues,
            'new_values' => null,
            'performed_by' => auth()->id(),
        ]);

        $vehicle->delete();

        return ApiResponse::success(
            null,
            'Vehicle deleted successfully.',
        );
    }
        public function history(int $vehicleId): JsonResponse
    {
        $history = VehicleHistory::query()
            ->where('vehicle_id', $vehicleId)
            ->latest()
            ->paginate(20);

        return ApiResponse::success(
            $history->items(),
            'Vehicle history retrieved successfully.',
            additional: [
                'meta' => [
                    'current_page' => $history->currentPage(),
                    'last_page' => $history->lastPage(),
                    'per_page' => $history->perPage(),
                    'total' => $history->total(),
                ],
            ],
        );
    }

    public function approve(NovapiVehicle $vehicle): JsonResponse
    {
        $oldValues = $vehicle->toArray();

        $vehicle->update([
            'approval_status' => 1,
            'status' => 1,
            'rejection_reason' => null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        VehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'action' => 'approved',
            'old_values' => $oldValues,
            'new_values' => $vehicle->fresh()->toArray(),
            'performed_by' => auth()->id(),
        ]);

        return ApiResponse::success(
            $vehicle->fresh(),
            'Vehicle approved successfully.',
        );
    }

    public function reject(Request $request, NovapiVehicle $vehicle): JsonResponse
    {
        $validated = $request->validate([
            'reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $oldValues = $vehicle->toArray();

        $vehicle->update([
            'approval_status' => 2, 
            'status' => 0,          
            'rejection_reason' => $validated['reason'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        VehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'action' => 'rejected',
            'old_values' => $oldValues,
            'new_values' => $vehicle->fresh()->toArray(),
            'performed_by' => auth()->id(),
        ]);

        return ApiResponse::success(
            $vehicle->fresh(),
            'Vehicle rejected successfully.',
        );
    }

        public function updateStatus(
        Request $request,
        NovapiVehicle $vehicle
    ): JsonResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'integer',
                'in:0,1,2,3',
            ],
        ]);

        if (
            $vehicle->approval_status !== 1 &&
            in_array($validated['status'], [1, 2, 3], true)
        ) {
            return ApiResponse::error(
                'Only approved vehicles can be assigned an operational status.',
                422,
            );
        }

        $oldValues = $vehicle->toArray();

        $vehicle->update([
            'status' => $validated['status'],
        ]);

        VehicleHistory::create([
            'vehicle_id' => $vehicle->id,
            'action' => 'status_changed',
            'old_values' => $oldValues,
            'new_values' => $vehicle->fresh()->toArray(),
            'performed_by' => auth()->id(),
        ]);

        return ApiResponse::success(
            $vehicle->fresh(),
            'Vehicle status updated successfully.',
        );
    }
}