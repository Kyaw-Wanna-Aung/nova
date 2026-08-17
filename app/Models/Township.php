<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Township extends Model
{
    use HasFactory;

protected $fillable = [
    'name',
    'mm_name',
    'region_name',
    'region_mm_name',
    'region_type',
];
    public function departingRoutes(): HasMany
    {
        return $this->hasMany(
            TravelRoute::class,
            'departure_id'
        );
    }

    public function arrivingRoutes(): HasMany
    {
        return $this->hasMany(
            TravelRoute::class,
            'arrival_id'
        );
    }
}