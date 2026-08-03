<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.testimonials.index', $this->indexData($request));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['status'] = $data['status'] ?? 'Active';
        $data['display_order'] = $data['display_order'] ?? $this->nextDisplayOrder();

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial added successfully.');
    }

    public function edit(Request $request, Testimonial $testimonial): View
    {
        return view('admin.testimonials.index', $this->indexData($request, $testimonial));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($this->validatedData($request));

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    public function changeStatus(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'status' => $testimonial->status === 'Active' ? 'Inactive' : 'Active',
        ]);

        return back()->with('success', 'Testimonial status updated successfully.');
    }

    private function indexData(Request $request, ?Testimonial $selectedTestimonial = null): array
    {
        $search = trim((string) $request->query('search', ''));

        $testimonials = Testimonial::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            })
            ->orderBy('display_order')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return compact('testimonials', 'selectedTestimonial', 'search');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'status' => ['nullable', 'in:Active,Inactive'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function nextDisplayOrder(): int
    {
        return (int) Testimonial::max('display_order') + 1;
    }
}
