<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email:rfc,dns', 'max:255']]);

        if (Subscription::query()->where('email', $data['email'])->exists()) {
            return back()->withInput()->with('error', 'This email is already subscribed to our newsletter.');
        }

        Subscription::create(['email' => $data['email'], 'subscribed_at' => now()]);

        return back()->with('success', 'Thank you for subscribing to our newsletter.');
    }
}
