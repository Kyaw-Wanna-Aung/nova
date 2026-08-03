<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('content');
            $table->string('featured_image');
            $table->string('banner_image');
            $table->json('gallery_images')->nullable();
            $table->string('category');
            $table->string('author');
            $table->unsignedInteger('reading_time');
            $table->string('tags')->nullable();
            $table->boolean('show_as_hero')->default(false);
            $table->enum('status', ['Published', 'Draft', 'Archived'])->default('Draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
