<?php

namespace Tests\Feature\Api;

use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_api_only_returns_published_faqs(): void
    {
        Faq::create([
            'question' => 'How do I book?',
            'answer' => 'Choose your route and continue.',
            'category' => 'Booking',
            'status' => 'Published',
            'display_order' => 1,
        ]);

        Faq::create([
            'question' => 'Draft question',
            'answer' => 'This should not be public.',
            'category' => 'General',
            'status' => 'Draft',
            'display_order' => 2,
        ]);

        $response = $this->getJson('/api/faqs');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath(
                'data.0.question',
                'How do I book?'
            );
    }

    public function test_faqs_can_be_searched(): void
    {
        Faq::create([
            'question' => 'How can I pay?',
            'answer' => 'You can pay using the supported payment methods.',
            'category' => 'Payment',
            'status' => 'Published',
            'display_order' => 1,
        ]);

        Faq::create([
            'question' => 'How do I change my route?',
            'answer' => 'Contact support.',
            'category' => 'Booking',
            'status' => 'Published',
            'display_order' => 2,
        ]);

        $response = $this->getJson('/api/faqs?search=pay');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath(
                'data.0.category',
                'Payment'
            );
    }

    public function test_faqs_can_be_filtered_by_category(): void
    {
        Faq::create([
            'question' => 'Payment FAQ',
            'answer' => 'Payment answer',
            'category' => 'Payment',
            'status' => 'Published',
            'display_order' => 1,
        ]);

        Faq::create([
            'question' => 'Booking FAQ',
            'answer' => 'Booking answer',
            'category' => 'Booking',
            'status' => 'Published',
            'display_order' => 2,
        ]);

        $response = $this->getJson('/api/faqs?category=Booking');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath(
                'data.0.question',
                'Booking FAQ'
            );
    }
}