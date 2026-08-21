<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NovapiVehicle extends Model
{
    protected $table = 'novapi_vehicle';

    protected $fillable = [
        'vehicle_number',
        'vehicle_brand_id',
        'vehicle_model_id',
        'brand',
        'model',
        'color',
        'seat_capacity',
        'vehicle_photo',
        'status',
        'owner_id',
        'front_photo',
        'insurance_certificate',
        'interior_photo',
        'owner_book',
        'side_photo',
        'vehicle_registration_certificate',
        'wheel_tax_receipt',
        'approval_status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        
    ];

    protected $casts = [
        'seat_capacity' => 'integer',
        'status' => 'integer',
        'approval_status' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function brandInfo(): BelongsTo
    {
        return $this->belongsTo(
            VehicleBrand::class,
            'vehicle_brand_id'
        );
    }

    public function modelInfo(): BelongsTo
    {
        return $this->belongsTo(
            VehicleModel::class,
            'vehicle_model_id'
        );
    }
}