<?php

namespace Tests\Feature\Api;

use App\Models\HeroBanner;
use App\Models\Promotion;
use App\Models\RouteManagement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_promotions_endpoint_returns_json(): void
    {
        Promotion::create([
            'title' => 'Summer Deal',
            'description' => 'Test promotion',
            'original_price' => 50000,
            'discounted_price' => 40000,
            'duration' => '8 Hours',
            'daily_departures' => '4 / Day',
        ]);

        $response = $this->getJson('/api/promotions');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.0.title', 'Summer Deal');
    }

    public function test_routes_endpoint_only_returns_active_routes(): void
    {
        RouteManagement::create([
            'name' => 'Yangon to Mandalay',
            'from_location' => 'Yangon',
            'to_location' => 'Mandalay',
            'origin' => 'Yangon',
            'destination' => 'Mandalay',
            'distance' => 620,
            'category' => 'Nova Executive',
            'type' => 'Nova Executive',
            'available_seats' => 10,
            'departure_date' => now()->addDay()->toDateString(),
            'departure_time' => '08:00',
            'fare' => 50000,
            'status' => 'Active',
            'description' => 'Test route',
        ]);

        RouteManagement::create([
            'name' => 'Inactive Route',
            'from_location' => 'Yangon',
            'to_location' => 'Naypyidaw',
            'origin' => 'Yangon',
            'destination' => 'Naypyidaw',
            'distance' => 320,
            'category' => 'Nova Executive',
            'type' => 'Nova Executive',
            'available_seats' => 10,
            'departure_date' => now()->addDay()->toDateString(),
            'departure_time' => '10:00',
            'fare' => 30000,
            'status' => 'Inactive',
            'description' => 'Should not appear',
        ]);

        $response = $this->getJson('/api/routes');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Yangon to Mandalay');
    }

    public function test_routes_endpoint_can_filter_by_origin(): void
    {
        RouteManagement::create([
            'name' => 'Yangon to Mandalay',
            'from_location' => 'Yangon',
            'to_location' => 'Mandalay',
            'origin' => 'Yangon',
            'destination' => 'Mandalay',
            'distance' => 620,
            'category' => 'Nova Executive',
            'type' => 'Nova Executive',
            'available_seats' => 10,
            'departure_date' => now()->addDay()->toDateString(),
            'departure_time' => '08:00',
            'fare' => 50000,
            'status' => 'Active',
        ]);

        $response = $this->getJson('/api/routes?from=Yangon');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.from', 'Yangon');
    }

    public function test_hero_banner_endpoint_returns_banner(): void
    {
        HeroBanner::create([
            'title' => '20% OFF YOUR FIRST RIDE',
            'description' => 'Welcome promotion',
        ]);

        $response = $this->getJson('/api/hero-banner');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'data.title',
                '20% OFF YOUR FIRST RIDE'
            );
    }

    public function test_hero_banner_endpoint_returns_404_when_missing(): void
    {
        $this->getJson('/api/hero-banner')
            ->assertNotFound()
            ->assertJsonPath('success', false)
            ->assertJsonPath('data', null);
    }
}