<?php

namespace Tests\Feature\Api;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_api_only_returns_active_testimonials(): void
    {
        Testimonial::create([
            'name' => 'Active Customer',
            'role' => 'Passenger',
            'message' => 'Excellent service.',
            'rating' => 5,
            'status' => 'Active',
            'display_order' => 1,
        ]);

        Testimonial::create([
            'name' => 'Inactive Customer',
            'role' => 'Passenger',
            'message' => 'This should not appear.',
            'rating' => 4,
            'status' => 'Inactive',
            'display_order' => 2,
        ]);

        $response = $this->getJson('/api/testimonials');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Active Customer')
            ->assertJsonPath('data.0.rating', 5);
    }

    public function test_testimonials_are_ordered_by_display_order(): void
    {
        Testimonial::create([
            'name' => 'Second',
            'role' => 'Passenger',
            'message' => 'Second testimonial.',
            'rating' => 5,
            'status' => 'Active',
            'display_order' => 2,
        ]);

        Testimonial::create([
            'name' => 'First',
            'role' => 'Passenger',
            'message' => 'First testimonial.',
            'rating' => 5,
            'status' => 'Active',
            'display_order' => 1,
        ]);

        $response = $this->getJson('/api/testimonials');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.name', 'First')
            ->assertJsonPath('data.1.name', 'Second');
    }

    public function test_testimonial_response_has_expected_structure(): void
    {
        Testimonial::create([
            'name' => 'Nova Customer',
            'role' => 'Passenger',
            'message' => 'Very comfortable trip.',
            'rating' => 5,
            'status' => 'Active',
            'display_order' => 1,
        ]);

        $this->getJson('/api/testimonials')
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'role',
                        'message',
                        'rating',
                        'image',
                        'display_order',
                    ],
                ],
            ]);
    }
}