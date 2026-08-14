<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category,
            'summary' => $this->summary,
            'content' => $this->content,

            'featured_image' => $this->featured_image
                ? asset('storage/' . $this->featured_image)
                : null,

            'author' => [
                'name' => $this->author_name,
                'role' => $this->author_role,

                'image' => $this->author_profile_image
                    ? asset('storage/' . $this->author_profile_image)
                    : null,
            ],

            'read_time' => (int) $this->read_time,
            'is_featured' => (bool) $this->is_featured,

            'published_at' => $this->published_at?->toISOString(),

            'sections' => BlogSectionResource::collection(
                $this->whenLoaded('sections')
            ),
        ];
    }
}