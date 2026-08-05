<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'image',
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

    protected function photoUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (!$this->image) {
                return null;
            }

            return Storage::disk('public')->exists($this->image)
                ? Storage::disk('public')->url($this->image)
                : null;
        });
    }
}