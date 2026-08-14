<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroBannerResource extends JsonResource
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
            'category' => $this->category,
            'title' => $this->title,
            'description' => $this->description,
            'promo_code' => $this->promo_code,

            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'badges' => [
                [
                    'title' => $this->badge_1_title,
                    'subtitle' => $this->badge_1_sub,
                ],
                [
                    'title' => $this->badge_2_title,
                    'subtitle' => $this->badge_2_sub,
                ],
            ],

            'card' => [
                'title' => $this->card_title,
                'description' => $this->card_description,
            ],
        ];
    }
}