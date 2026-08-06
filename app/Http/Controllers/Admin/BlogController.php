<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogSection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $blogs = Blog::query()->withCount('sections')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($q) => $q->where('title', 'like', '%'.$request->string('search').'%')->orWhere('author_name', 'like', '%'.$request->string('search').'%')))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->string('category')))
            ->when($request->filled('featured'), fn ($q) => $q->where('is_featured', $request->boolean('featured')))
            ->latest('published_at')->paginate(10)->withQueryString();

        return view('admin.blog.index', compact('blogs') + [
            'categories' => Blog::query()->distinct()->orderBy('category')->pluck('category'),
            'selectedBlog' => $request->filled('edit') ? Blog::with('sections')->findOrFail($request->integer('edit')) : null,
        ]);
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            $data = $request->safe()->except(['sections']);
            $data['slug'] = $this->uniqueSlug($data['title']);
            $data['is_featured'] = $request->boolean('is_featured');
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
            $data['author_profile_image'] = $request->file('author_profile_image')->store('blogs/authors', 'public');
            $this->syncSections(Blog::create($data), $request->input('sections', []), $request->file('sections', []));
        });

        return redirect()->route('admin.blog.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog): RedirectResponse
    {
        return redirect()->route('admin.blog.index', ['edit' => $blog->id]);
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        DB::transaction(function () use ($request, $blog): void {
            $data = $request->safe()->except(['sections', 'existing_sections']);
            $data['slug'] = $this->uniqueSlug($data['title'], $blog->id);
            $data['is_featured'] = $request->boolean('is_featured');
            foreach (['featured_image' => 'blogs', 'author_profile_image' => 'blogs/authors'] as $field => $directory) {
                if ($request->hasFile($field)) {
                    Storage::disk('public')->delete($blog->{$field});
                    $data[$field] = $request->file($field)->store($directory, 'public');
                }
            }
            $blog->update($data);
            $this->updateExistingSections($blog, $request->input('existing_sections', []), $request->file('existing_sections', []));
            $this->syncSections($blog, $request->input('sections', []), $request->file('sections', []));
        });

        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        DB::transaction(function () use ($blog): void {
            Storage::disk('public')->delete([$blog->featured_image, $blog->author_profile_image]);
            $blog->sections()->each(fn (BlogSection $section) => Storage::disk('public')->delete($section->image));
            $blog->delete();
        });
        return back()->with('success', 'Blog deleted successfully.');
    }

    private function syncSections(Blog $blog, array $sections, array $images): void
    {
        foreach (array_slice($sections, 0, 5) as $position => $section) {
            $image = $images[$position]['image'] ?? null;
            if (! $image && blank($section['title'] ?? null) && blank($section['message'] ?? null)) continue;
            $blog->sections()->create([
                'image' => $image?->store('blogs/sections', 'public'),
                'title' => $section['title'] ?? null, 'message' => $section['message'] ?? null,
                'sort_order' => $section['sort_order'] ?? $position,
            ]);
        }
    }

    private function updateExistingSections(Blog $blog, array $sections, array $images): void
    {
        foreach ($sections as $position => $data) {
            $section = $blog->sections()->find($data['id']);
            if (! $section) continue;
            if (! empty($data['delete'])) {
                Storage::disk('public')->delete($section->image);
                $section->delete();
                continue;
            }
            $image = $images[$position]['image'] ?? null;
            if ($image) {
                Storage::disk('public')->delete($section->image);
                $data['image'] = $image->store('blogs/sections', 'public');
            }
            $section->update(['image' => $data['image'] ?? $section->image, 'title' => $data['title'] ?? null, 'message' => $data['message'] ?? null, 'sort_order' => $data['sort_order'] ?? $position]);
        }
    }

    private function uniqueSlug(string $title, ?int $except = null): string
    {
        $base = Str::slug($title) ?: 'blog'; $slug = $base; $suffix = 2;
        while (Blog::where('slug', $slug)->when($except, fn ($q) => $q->whereKeyNot($except))->exists()) $slug = $base.'-'.$suffix++;
        return $slug;
    }
}
