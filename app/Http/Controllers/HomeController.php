<?php

namespace App\Http\Controllers;

use App\Models\VisionMission;
use App\Models\Promotion;
use App\Models\Faq;
use App\Models\RouteManagement;
use App\Models\Testimonial;
use App\Models\HeroBanner;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $routes = Schema::hasTable('route_managements')
            ? RouteManagement::query()->where('status', 'Active')
                ->when($request->filled('from'), fn ($query) => $query->where('from_location', 'like', '%'.$request->input('from').'%'))
                ->when($request->filled('to'), fn ($query) => $query->where('to_location', 'like', '%'.$request->input('to').'%'))
                ->when($request->filled('date'), fn ($query) => $query->whereDate('departure_date', $request->input('date')))
                ->when($request->filled('passengers'), fn ($query) => $query->where('available_seats', '>=', (int) $request->input('passengers')))
                ->orderBy('departure_date')->orderBy('departure_time')->latest('id')->take(6)->get()
            : collect();

        return view('user.home', [
            'visionMission' => Schema::hasTable('vision_missions') ? VisionMission::query()->first() : null,
            'routes' => $routes,
            'testimonials' => Schema::hasTable('testimonials') ? Testimonial::query()->where('status', 'Active')->orderBy('display_order')->latest('id')->get() : collect(),
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
        // Deals section အတွက် promotions table မှ data များကို ခေါ်ယူခြင်း
        $promotions = Promotion::query()->latest()->get();
        
        // Hero section အတွက် hero_banners table မှ data ကို သီးသန့်ခေါ်ယူခြင်း
        $heroBanner = Schema::hasTable('hero_banners') ? HeroBanner::query()->first() : null;

        return view('user.promotions', [
            'heroBanner' => $heroBanner,
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