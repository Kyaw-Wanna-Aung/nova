<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_subscribe_to_newsletter(): void
    {
        $response = $this->postJson('/api/newsletter/subscribe', [
            'email' => 'customer@example.com',
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'data.email',
                'customer@example.com'
            );

        $this->assertDatabaseHas('subscriptions', [
            'email' => 'customer@example.com',
        ]);
    }

    public function test_duplicate_newsletter_subscription_is_rejected(): void
    {
        $this->postJson('/api/newsletter/subscribe', [
            'email' => 'customer@example.com',
        ])->assertCreated();

        $response = $this->postJson('/api/newsletter/subscribe', [
            'email' => 'customer@example.com',
        ]);

        $response
            ->assertStatus(409)
            ->assertJsonPath('success', false);
    }

    public function test_newsletter_subscription_requires_valid_email(): void
    {
        $response = $this->postJson('/api/newsletter/subscribe', [
            'email' => 'not-an-email',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonPath('success', false);
    }
}