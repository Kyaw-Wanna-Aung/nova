<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_number' => [
                'required',
                'string',
                'max:20',
                'unique:novapi_vehicle,vehicle_number',
            ],

            'vehicle_brand_id' => [
                'required',
                'integer',
                'exists:vehicle_brands,id',
            ],

            'vehicle_model_id' => [
                'required',
                'integer',
                'exists:vehicle_models,id',
            ],

            'color' => [
                'required',
                'string',
                'max:30',
            ],

            'seat_capacity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
            'status' => [
                'sometimes',
                'integer',
                'in:0,1,2,3',
            ],

            'owner_id' => [
                'required',
                'integer',
            ],

            'vehicle_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'front_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'interior_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'side_photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'insurance_certificate' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],

            'owner_book' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],

            'vehicle_registration_certificate' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:10240',
            ],

            'wheel_tax_receipt' => [
                'required',
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
                if (
                    ! $this->filled('vehicle_brand_id') ||
                    ! $this->filled('vehicle_model_id')
                ) {
                    return;
                }

                $modelBelongsToBrand = \App\Models\VehicleModel::query()
                    ->where('id', $this->vehicle_model_id)
                    ->where('vehicle_brand_id', $this->vehicle_brand_id)
                    ->exists();

                if (! $modelBelongsToBrand) {
                    $validator->errors()->add(
                        'vehicle_model_id',
                        'The selected vehicle model does not belong to the selected brand.'
                    );
                }
            },
        ];
    }
}