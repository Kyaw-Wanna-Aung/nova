<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_routes', function (Blueprint $table) {
            $table->id();

            $table->string('route_name', 100);

            $table->foreignId('departure_id')
                ->constrained('townships')
                ->cascadeOnDelete();

            $table->foreignId('arrival_id')
                ->constrained('townships')
                ->cascadeOnDelete();

            $table->double('distance');

            $table->unsignedInteger('estimated_time');

            $table->time('route_time');

            $table->unsignedInteger('discount')
                ->default(0);

            $table->timestamps();

            $table->index('departure_id');
            $table->index('arrival_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_routes');
    }
};