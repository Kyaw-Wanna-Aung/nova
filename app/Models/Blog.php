<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'short_description', 'content', 'featured_image', 'banner_image', 'gallery_images', 'category', 'author', 'reading_time', 'tags', 'show_as_hero', 'status', 'published_at'];

    protected $casts = [
        'gallery_images' => 'array',
        'show_as_hero' => 'boolean',
        'published_at' => 'datetime',
    ];
}
