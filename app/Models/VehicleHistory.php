<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleHistory extends Model
{
    protected $fillable = [
        'vehicle_id',
        'action',
        'old_values',
        'new_values',
        'performed_by',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
}