<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisionMissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'vision' => $this->vision,
            'mission' => $this->mission,
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}