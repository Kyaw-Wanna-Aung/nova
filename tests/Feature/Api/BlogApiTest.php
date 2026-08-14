<?php

namespace Tests\Feature\Api;

use App\Models\Blog;
use App\Models\BlogSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    private function createBlog(array $overrides = []): Blog
    {
        return Blog::create(array_merge([
            'title' => 'Nova Travel Guide',
            'slug' => 'nova-travel-guide',
            'content' => 'Full blog content.',
            'featured_image' => 'blogs/test.jpg',
            'author_name' => 'Nova Team',
            'author_role' => 'Editorial',
            'author_profile_image' => 'blogs/authors/test.jpg',
            'read_time' => 5,
            'is_featured' => false,
            'category' => 'Travel Guides',
            'summary' => 'A useful travel guide.',
            'published_at' => now(),
        ], $overrides));
    }

    public function test_blog_list_only_returns_published_blogs(): void
    {
        $this->createBlog([
            'title' => 'Published Blog',
            'slug' => 'published-blog',
        ]);

        $this->createBlog([
            'title' => 'Draft Blog',
            'slug' => 'draft-blog',
            'published_at' => null,
        ]);

        $response = $this->getJson('/api/blogs');

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Published Blog');
    }

    public function test_blog_list_can_filter_by_category(): void
    {
        $this->createBlog([
            'title' => 'Travel Blog',
            'slug' => 'travel-blog',
            'category' => 'Travel Guides',
        ]);

        $this->createBlog([
            'title' => 'Tech Blog',
            'slug' => 'tech-blog',
            'category' => 'Tech & Innovation',
        ]);

        $response = $this->getJson(
            '/api/blogs?category=' . urlencode('Travel Guides')
        );

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Travel Blog');
    }

    public function test_blog_list_can_be_searched(): void
    {
        $this->createBlog([
            'title' => 'Myanmar Travel Guide',
            'slug' => 'myanmar-travel-guide',
            'summary' => 'Explore destinations around Myanmar.',
        ]);

        $this->createBlog([
            'title' => 'Nova Technology',
            'slug' => 'nova-technology',
            'summary' => 'Technology updates from Nova.',
        ]);

        $response = $this->getJson('/api/blogs?search=Myanmar');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath(
                'data.0.slug',
                'myanmar-travel-guide'
            );
    }

    public function test_blog_can_be_retrieved_by_slug(): void
    {
        $blog = $this->createBlog([
            'title' => 'Nova Travel Guide',
            'slug' => 'nova-travel-guide',
        ]);

        BlogSection::create([
            'blog_id' => $blog->id,
            'title' => 'Getting Started',
            'message' => 'First section.',
            'sort_order' => 1,
        ]);

        $response = $this->getJson(
            '/api/blogs/nova-travel-guide'
        );

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath(
                'data.title',
                'Nova Travel Guide'
            )
            ->assertJsonPath(
                'data.sections.0.title',
                'Getting Started'
            );
    }

    public function test_unpublished_blog_is_not_publicly_accessible(): void
    {
        $this->createBlog([
            'slug' => 'draft-blog',
            'published_at' => null,
        ]);

        $this->getJson('/api/blogs/draft-blog')
            ->assertNotFound();
    }

    public function test_blog_sections_are_returned_in_sort_order(): void
    {
        $blog = $this->createBlog([
            'slug' => 'section-order-test',
        ]);

        BlogSection::create([
            'blog_id' => $blog->id,
            'title' => 'Second Section',
            'message' => 'Second',
            'sort_order' => 2,
        ]);

        BlogSection::create([
            'blog_id' => $blog->id,
            'title' => 'First Section',
            'message' => 'First',
            'sort_order' => 1,
        ]);

        $response = $this->getJson(
            '/api/blogs/section-order-test'
        );

        $response
            ->assertOk()
            ->assertJsonPath(
                'data.sections.0.title',
                'First Section'
            )
            ->assertJsonPath(
                'data.sections.1.title',
                'Second Section'
            );
    }
}