<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
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
            'name' => $this->name,
            'from' => $this->from_location,
            'to' => $this->to_location,
            'distance' => $this->distance,
            'category' => $this->category,
            'available_seats' => (int) $this->available_seats,
            'departure_date' => $this->departure_date,
            'departure_time' => $this->departure_time,
            'fare' => (float) $this->fare,
            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,
            'description' => $this->description,
        ];
    }
}