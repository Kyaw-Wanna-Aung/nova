<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'message',
        'rating',
        'status',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'display_order' => 'integer',
        ];
    }
}
