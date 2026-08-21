<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $vehicleModel = $this->route('vehicleModel');

        $brandId = $this->input(
            'vehicle_brand_id',
            $vehicleModel?->vehicle_brand_id
        );

        return [
            'vehicle_brand_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicle_brands,id',
            ],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('vehicle_models', 'name')
                    ->where(
                        fn ($query) =>
                        $query->where(
                            'vehicle_brand_id',
                            $brandId
                        )
                    )
                    ->ignore($vehicleModel?->id),
            ],
            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}