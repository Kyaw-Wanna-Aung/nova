<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('novapi_vehicle', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number', 20);
            $table->string('brand', 50);
            $table->string('model', 50);
            $table->string('color', 30);
            $table->integer('seat_capacity');
            $table->string('vehicle_photo', 100);
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('owner_id');
            $table->string('front_photo', 100);
            $table->string('insurance_certificate', 100);
            $table->string('interior_photo', 100);
            $table->string('owner_book', 100);
            $table->string('side_photo', 100);
            $table->string('vehicle_registration_certificate', 100);
            $table->string('wheel_tax_receipt', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novapi_vehicle');
    }
};
