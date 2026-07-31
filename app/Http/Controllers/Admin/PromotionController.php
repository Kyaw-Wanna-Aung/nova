<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use App\Models\Promotion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.promotions.index', $this->buildIndexData($request));
    }

    public function create(Request $request): View
    {
        return view('admin.promotions.index', $this->buildIndexData($request, new Promotion(), 'create'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($data);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promotion created successfully.');
    }

    public function show(Promotion $promotion): RedirectResponse
    {
        return redirect()->route('admin.promotions.edit', $promotion);
    }

    public function edit(Request $request, Promotion $promotion): View
    {
        return view('admin.promotions.index', $this->buildIndexData($request, $promotion, 'edit'));
    }

    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $this->deleteImage($promotion);
            $data['image'] = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update($data);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        $this->deleteImage($promotion);
        $promotion->delete();

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Promotion deleted successfully.');
    }

    private function buildIndexData(Request $request, ?Promotion $selectedPromotion = null, string $pageMode = 'index'): array
    {
        $search = trim((string) $request->get('search', ''));
        $perPage = (int) $request->get('per_page', 9);

        if (! in_array($perPage, [6, 9, 12, 18], true)) {
            $perPage = 9;
        }

        $promotions = Promotion::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('duration', 'like', "%{$search}%")
                        ->orWhere('daily_departures', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $stats = [
            'total' => Promotion::count(),
            'with_images' => Promotion::query()->whereNotNull('image')->count(),
            'max_saving' => (float) (Promotion::query()->selectRaw('MAX(original_price - discounted_price) as saving')->value('saving') ?? 0),
            'average_discount_percent' => (float) (Promotion::query()->where('original_price', '>', 0)->selectRaw('AVG(((original_price - discounted_price) / original_price) * 100) as percent')->value('percent') ?? 0),
        ];

        return [
            'heroBanner' => HeroBanner::query()->first(),
            'promotions' => $promotions,
            'selectedPromotion' => $selectedPromotion,
            'pageMode' => $pageMode,
            'stats' => $stats,
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'original_price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['required', 'numeric', 'min:0', 'lte:original_price'],
            'duration' => ['nullable', 'string', 'max:255'],
            'daily_departures' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function deleteImage(Promotion $promotion): void
    {
        if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
            Storage::disk('public')->delete($promotion->image);
        }
    }
}



