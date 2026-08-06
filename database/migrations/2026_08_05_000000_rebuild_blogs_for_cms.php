<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'banner_image', 'gallery_images', 'author', 'reading_time', 'tags', 'show_as_hero', 'status']);
            $table->text('summary')->after('category');
            $table->string('author_name')->after('featured_image');
            $table->string('author_role')->after('author_name');
            $table->string('author_profile_image')->after('author_role');
            $table->unsignedInteger('read_time')->after('author_profile_image');
            $table->boolean('is_featured')->default(false)->after('read_time');
        });

        Schema::create('blog_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_sections');
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['summary', 'author_name', 'author_role', 'author_profile_image', 'read_time', 'is_featured']);
            $table->text('short_description');
            $table->string('banner_image');
            $table->json('gallery_images')->nullable();
            $table->string('author');
            $table->unsignedInteger('reading_time');
            $table->string('tags')->nullable();
            $table->boolean('show_as_hero')->default(false);
            $table->enum('status', ['Published', 'Draft', 'Archived'])->default('Draft');
        });
    }
};
