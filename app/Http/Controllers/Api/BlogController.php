<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private const CATEGORIES = [
        'Sustainable Travel',
        'Tech & Innovation',
        'Travel Guides',
        'Corporate Updates',
    ];

    public function index(Request $request): JsonResponse
    {
        $category = trim((string) $request->query('category', ''));
        $search = trim((string) $request->query('search', ''));

        $blogs = Blog::query()
            ->whereNotNull('published_at')

            ->when(
                in_array($category, self::CATEGORIES, true),
                fn ($query) => $query->where('category', $category)
            )

            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
                });
            })

            ->latest('published_at')
            ->paginate(9);

        return response()->json([
            'success' => true,
            'message' => 'Blogs retrieved successfully.',

            'data' => BlogResource::collection(
                $blogs->getCollection()
            ),

            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }

    public function show(Blog $blog): JsonResponse
    {
        if (!$blog->published_at) {
            return response()->json([
                'success' => false,
                'message' => 'Blog not found.',
                'data' => null,
            ], 404);
        }

        $blog->load('sections');

        return response()->json([
            'success' => true,
            'message' => 'Blog retrieved successfully.',
            'data' => new BlogDetailResource($blog),
        ]);
    }
}