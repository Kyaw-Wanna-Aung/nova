<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroBannersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('promo_code')->nullable();
            $table->string('badge_1_title')->nullable();
            $table->string('badge_1_sub')->nullable();
            $table->string('badge_2_title')->nullable();
            $table->string('badge_2_sub')->nullable();
            $table->string('image')->nullable();
            $table->string('card_title')->nullable();
            $table->text('card_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
}