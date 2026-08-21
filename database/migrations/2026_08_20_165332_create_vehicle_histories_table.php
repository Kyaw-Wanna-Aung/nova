<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
            Schema::create('vehicle_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vehicle_id');

            $table->string('action', 20);

            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            $table->unsignedBigInteger('performed_by')->nullable();

            $table->timestamps();

            $table->index('vehicle_id');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('vehicle_histories');
    }
};
