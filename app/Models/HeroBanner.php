<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'description',
        'promo_code',
        'badge_1_title',
        'badge_1_sub',
        'badge_2_title',
        'badge_2_sub',
        'image',
        'card_title',       // Right Card Title
        'card_description', // Right Card Description
    ];
}