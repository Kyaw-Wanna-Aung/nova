<?php

namespace App\Http\Requests;

use App\Models\VehicleModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vehicle = $this->route('vehicle');

        return [
            'vehicle_number' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('novapi_vehicle', 'vehicle_number')
                    ->ignore($vehicle?->id),
            ],

            'vehicle_brand_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicle_brands,id',
            ],

            'vehicle_model_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicle_models,id',
            ],

            'color' => [
                'sometimes',
                'required',
                'string',
                'max:30',
            ],

            'seat_capacity' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'status' => [
                'sometimes',
                'integer',
                'in:0,1',
            ],

            'owner_id' => [
                'sometimes',
                'required',
                'integer',
            ],

            'vehicle_photo' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'front_photo' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'interior_photo' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'side_photo' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'insurance_certificate' => [
                'sometimes',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],

            'owner_book' => [
                'sometimes',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],

            'vehicle_registration_certificate' => [
                'sometimes',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],

            'wheel_tax_receipt' => [
                'sometimes',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $vehicle = $this->route('vehicle');

                $brandId = $this->input(
                    'vehicle_brand_id',
                    $vehicle?->vehicle_brand_id
                );

                $modelId = $this->input(
                    'vehicle_model_id',
                    $vehicle?->vehicle_model_id
                );

                if (! $brandId || ! $modelId) {
                    return;
                }

                $valid = VehicleModel::query()
                    ->where('id', $modelId)
                    ->where('vehicle_brand_id', $brandId)
                    ->exists();

                if (! $valid) {
                    $validator->errors()->add(
                        'vehicle_model_id',
                        'The selected vehicle model does not belong to the selected brand.'
                    );
                }
            },
        ];
    }
}