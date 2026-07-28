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
    Schema::create('routes', function (Blueprint $table) {
        $table->id();
        $table->string('category'); // ဥပမာ- VIP Express, Standard, Charter
        $table->string('origin'); // ဥပမာ- Yangon
        $table->string('destination'); // ဥပမာ- Mandalay
        $table->integer('available_seats'); // ဥပမာ- 15
        $table->date('date'); // ဥပမာ- 2026-08-01
        $table->time('time'); // ဥပမာ- 20:00:00
        $table->decimal('price', 10, 2); // ဥပမာ- 35000.00
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
