<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteManagement extends Model
{
    use HasFactory;

    protected $table = 'route_managements';

    protected $fillable = [
        'name', 'origin', 'destination', 'distance', 'type', 'from_location',
        'to_location', 'category', 'available_seats', 'departure_date',
        'departure_time', 'fare', 'image', 'status', 'description',
    ];

    protected function casts(): array
    {
        return ['departure_date' => 'date', 'fare' => 'decimal:2'];
    }

    public function getFromLocationAttribute(?string $value): ?string
    {
        return $value ?: ($this->attributes['origin'] ?? null);
    }

    public function getToLocationAttribute(?string $value): ?string
    {
        return $value ?: ($this->attributes['destination'] ?? null);
    }

    public function getCategoryAttribute(?string $value): ?string
    {
        return $value ?: ($this->attributes['type'] ?? null);
    }
}
