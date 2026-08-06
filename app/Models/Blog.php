<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'category', 'summary', 'content', 'featured_image', 'author_name', 'author_role', 'author_profile_image', 'read_time', 'is_featured', 'published_at'];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(BlogSection::class)->orderBy('sort_order');
    }
}
