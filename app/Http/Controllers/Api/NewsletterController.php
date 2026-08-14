<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email:rfc',
                'max:255',
            ],
        ]);

        $existing = Subscription::query()
            ->where('email', $validated['email'])
            ->exists();

        if ($existing) {
            return ApiResponse::error(
                'This email is already subscribed to our newsletter.',
                409
            );
        }

        $subscription = Subscription::create([
            'email' => $validated['email'],
            'subscribed_at' => now(),
        ]);

        return ApiResponse::success(
            [
                'id' => $subscription->id,
                'email' => $subscription->email,
                'subscribed_at' => $subscription->subscribed_at?->toISOString(),
            ],
            'Thank you for subscribing to our newsletter.',
            201
        );
    }
}