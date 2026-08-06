<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category')->toString();
        $base = Blog::query()->whereNotNull('published_at');
        $featured = (clone $base)->where('is_featured', true)->latest('published_at')->first();
        $blogs = $this->categoryFilter((clone $base)->when($featured, fn ($q) => $q->whereKeyNot($featured->id)), $category)->latest('published_at')->paginate(9)->withQueryString();
        return view('user.blog', compact('featured', 'blogs', 'category'));
    }

    public function all(Request $request): View
    {
        $category = $request->string('category')->toString();
        $blogs = $this->categoryFilter(Blog::query()->whereNotNull('published_at'), $category)->latest('published_at')->paginate(9)->withQueryString();
        return view('user.blog', ['featured' => null, 'blogs' => $blogs, 'category' => $category]);
    }

    public function show(Blog $blog): View
    {
        abort_unless($blog->published_at, 404);
        $blog->load('sections');
        $relatedBlogs = Blog::query()->whereNotNull('published_at')->whereKeyNot($blog->id)->latest('published_at')->take(3)->get();
        $moreBlogs = Blog::query()->whereNotNull('published_at')->whereKeyNot($blog->id)->latest('published_at')->take(3)->get();
        return view('user.blog-detail', compact('blog', 'relatedBlogs', 'moreBlogs'));
    }

    private function categoryFilter($query, string $category)
    {
        return in_array($category, ['Sustainable Travel', 'Tech & Innovation', 'Travel Guides', 'Corporate Updates'], true)
            ? $query->where('category', $category) : $query;
    }
}
