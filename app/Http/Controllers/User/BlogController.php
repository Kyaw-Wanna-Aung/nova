<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $hero = Blog::query()->where('status', 'Published')->where('show_as_hero', true)->latest('published_at')->first() ?? Blog::query()->where('status', 'Published')->latest('published_at')->first();
        $blogs = Blog::query()->where('status', 'Published')->when($hero, fn ($q) => $q->whereKeyNot($hero->id))->latest('published_at')->paginate(9);
        return view('user.blog', compact('hero', 'blogs'));
    }
    public function show(Blog $blog): View
    {
        abort_unless($blog->status === 'Published', 404);
        $relatedBlogs = Blog::query()->where('status', 'Published')->whereKeyNot($blog->id)->latest('published_at')->limit(3)->get();
        return view('user.blog-detail', compact('blog', 'relatedBlogs'));
    }
}
