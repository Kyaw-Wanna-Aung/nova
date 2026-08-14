<?php

namespace Tests\Feature\Api;

use App\Models\VisionMission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisionMissionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_vision_mission_endpoint_returns_content(): void
    {
        VisionMission::create([
            'vision' => 'To become Myanmar’s most trusted mobility platform.',
            'mission' => 'To provide safe, reliable and accessible transportation.',
        ]);

        $response = $this->getJson('/api/vision-mission');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'data.vision',
                'To become Myanmar’s most trusted mobility platform.'
            )
            ->assertJsonPath(
                'data.mission',
                'To provide safe, reliable and accessible transportation.'
            );
    }

    public function test_vision_mission_endpoint_returns_404_when_missing(): void
    {
        $this->getJson('/api/vision-mission')
            ->assertNotFound()
            ->assertJsonPath('success', false)
            ->assertJsonPath('data', null);
    }
}