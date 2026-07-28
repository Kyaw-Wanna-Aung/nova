<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::create('promotions', function (Blueprint $table) {
        $table->id();
        $table->string('title');                   // Route Name or Promotion Title
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->decimal('original_price', 12, 2); // e.g. 50000.00
        $table->decimal('discounted_price', 12, 2); // e.g. 40000.00
        $table->string('duration')->nullable();    // e.g. 8 Hours
        $table->string('daily_departures')->nullable(); // e.g. 4 Departures / Day
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
