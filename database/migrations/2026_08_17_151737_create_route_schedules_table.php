<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('novapi_routescheds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->date('route_date');
            $table->tinyInteger('complete')->default(0);
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->timestamps();

            // travel_routes ဇယားသို့ မှန်ကန်စွာ ချိတ်ဆက်ခြင်း
            $table->foreign('route_id')->references('id')->on('travel_routes')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('novapi_driverprofile')->onDelete('set null');
            $table->foreign('vehicle_id')->references('id')->on('novapi_vehicles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('novapi_routescheds');
    }
};