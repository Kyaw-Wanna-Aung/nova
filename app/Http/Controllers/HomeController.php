<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;
use App\Models\Promotion;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('user.home', [
            'visionMission' => Schema::hasTable('vision_missions')
                ? VisionMission::query()->first()
                : null,
        ]);
    }

    public function downloadApp(): View
    {
        return view('user.download-app', [
            'androidAppUrl' => config('services.nova.google_play_url', '#'),
            'iosAppUrl' => config('services.nova.app_store_url', '#'),
        ]);
    }

    public function promotions(): View
    {
        $promotions = Promotion::query()->latest()->get();

        return view('user.promotions', [
            'featuredPromotion' => $promotions->first(),
            'promotions' => $promotions,
        ]);
    }

    public function support(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $faqs = Schema::hasTable('faqs')
            ? Faq::query()->where('status', 'Published')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('question', 'like', "%{$search}%")
                            ->orWhere('answer', 'like', "%{$search}%");
                    });
                })
                ->orderBy('display_order')->latest('id')->get()
            : collect();

        return view('user.support', compact('faqs', 'search'));
    }
}
