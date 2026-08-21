<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_brand_id' => [
                'required',
                'integer',
                'exists:vehicle_brands,id',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicle_models', 'name')
                    ->where(
                        fn ($query) =>
                        $query->where(
                            'vehicle_brand_id',
                            $this->input('vehicle_brand_id')
                        )
                    ),
            ],
            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}