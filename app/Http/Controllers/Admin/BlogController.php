<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
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
        $sort = in_array($request->query('sort'), ['title', 'category', 'status', 'published_at'], true) ? $request->query('sort') : 'published_at';
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';
        $search = trim((string) $request->query('search', ''));
        $blogs = Blog::query()->when($search !== '', fn ($q) => $q->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%")->orWhere('author', 'like', "%{$search}%")))->when($request->filled('category'), fn ($q) => $q->where('category', $request->query('category')))->when(in_array($request->query('status'), ['Published', 'Draft', 'Archived'], true), fn ($q) => $q->where('status', $request->query('status')))->orderBy($sort, $direction)->paginate(10)->withQueryString();

        return view('admin.blog.index', ['blogs' => $blogs, 'selectedBlog' => $request->filled('edit') ? Blog::findOrFail($request->integer('edit')) : null, 'categories' => Blog::query()->distinct()->orderBy('category')->pluck('category'), 'stats' => ['total' => Blog::count(), 'published' => Blog::where('status', 'Published')->count(), 'draft' => Blog::where('status', 'Draft')->count(), 'archived' => Blog::where('status', 'Archived')->count()]]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $data = $this->storeFiles($request, $data);
        $data['slug'] = $this->uniqueSlug($data['title']);
        Blog::create($data);
        return redirect()->route('admin.blog.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog): View
    {
        return redirect()->route('admin.blog.index', ['edit' => $blog->id]);
    }

    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $data = $this->validated($request, false);
        $data = $this->storeFiles($request, $data, $blog);
        $data['slug'] = $this->uniqueSlug($data['title'], $blog->id);
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        foreach (array_filter([$blog->featured_image, $blog->banner_image, ...($blog->gallery_images ?? [])]) as $image) { Storage::disk('public')->delete($image); }
        $blog->delete();
        return back()->with('success', 'Blog deleted successfully.');
    }

    public function changeStatus(Request $request, Blog $blog): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:Published,Draft,Archived']]);
        $blog->update(['status' => $data['status'], 'published_at' => $data['status'] === 'Published' ? ($blog->published_at ?? now()) : $blog->published_at]);
        return back()->with('success', 'Blog status updated successfully.');
    }

    public function toggleHero(Blog $blog): RedirectResponse
    {
        DB::transaction(function () use ($blog) { Blog::where('id', '!=', $blog->id)->update(['show_as_hero' => false]); $blog->update(['show_as_hero' => ! $blog->show_as_hero]); });
        return back()->with('success', 'Hero blog selection updated successfully.');
    }

    private function validated(Request $request, bool $creating): array
    {
        return $request->validate(['title' => ['required', 'string', 'max:255'], 'short_description' => ['required', 'string', 'max:1000'], 'content' => ['required', 'string'], 'category' => ['required', 'string', 'max:100'], 'author' => ['required', 'string', 'max:255'], 'reading_time' => ['required', 'integer', 'min:1', 'max:999'], 'tags' => ['nullable', 'string', 'max:1000'], 'status' => ['required', 'in:Published,Draft,Archived'], 'published_at' => ['nullable', 'date'], 'featured_image' => [$creating ? 'required' : 'nullable', 'image', 'max:5120'], 'banner_image' => [$creating ? 'required' : 'nullable', 'image', 'max:5120'], 'gallery_images.*' => ['nullable', 'image', 'max:5120'], 'remove_gallery' => ['nullable', 'array']]);
    }

    private function storeFiles(Request $request, array $data, ?Blog $blog = null): array
    {
        foreach (['featured_image', 'banner_image'] as $field) { if ($request->hasFile($field)) { if ($blog?->$field) Storage::disk('public')->delete($blog->$field); $data[$field] = $request->file($field)->store('blogs', 'public'); } elseif ($blog) { $data[$field] = $blog->$field; } }
        $gallery = $blog?->gallery_images ?? [];
        foreach ($request->input('remove_gallery', []) as $image) { $gallery = array_values(array_diff($gallery, [$image])); Storage::disk('public')->delete($image); }
        foreach ($request->file('gallery_images', []) as $image) { if ($image) $gallery[] = $image->store('blogs/gallery', 'public'); }
        $data['gallery_images'] = $gallery ?: null;
        unset($data['remove_gallery']);
        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'blog'; $slug = $base; $number = 2;
        while (Blog::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) $slug = $base.'-'.$number++;
        return $slug;
    }
}
