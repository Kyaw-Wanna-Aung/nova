<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,
            'original_price' => (float) $this->original_price,
            'discounted_price' => (float) $this->discounted_price,
            'duration' => $this->duration,
            'daily_departures' => $this->daily_departures,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}