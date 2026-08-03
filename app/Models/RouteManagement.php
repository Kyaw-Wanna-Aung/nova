<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteManagement extends Model
{
    use HasFactory;

    protected $table = 'route_managements';

    protected $fillable = [
        'name',
        'origin',
        'destination',
        'distance',
        'type',
        'status',
        'description',
    ];
}
