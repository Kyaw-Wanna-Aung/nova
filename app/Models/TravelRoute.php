<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelRoute extends Model
{
    use HasFactory;

    protected $table = 'travel_routes';

    protected $fillable = [
        'route_name',
        'departure_id',
        'arrival_id',
        'distance',
        'estimated_time',
        'route_time',
        'discount',
    ];

    protected function casts(): array
    {
        return [
            'distance' => 'float',
            'estimated_time' => 'integer',
            'discount' => 'integer',
        ];
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(
            Township::class,
            'departure_id'
        );
    }

    public function arrival(): BelongsTo
    {
        return $this->belongsTo(
            Township::class,
            'arrival_id'
        );
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(
            RouteSchedule::class,
            'route_id'
        );
    }
}