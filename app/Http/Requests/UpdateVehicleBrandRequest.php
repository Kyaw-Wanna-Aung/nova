<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('vehicle_brands', 'name')
                    ->ignore($this->route('vehicleBrand')),
            ],
            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}