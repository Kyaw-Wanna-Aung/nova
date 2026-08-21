<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('novapi_driverprofile', function (Blueprint $table) {
            $table->id();
            $table->string('license_no', 50);
            $table->string('license_type', 20);
            $table->string('license_photo', 100);
            $table->date('license_expiry_date');
            $table->integer('driving_experience');
            $table->string('phone_number', 15);
            $table->unsignedBigInteger('user_id');
            $table->string('current_location', 100);
            $table->decimal('driver_latitude', 10, 7);
            $table->decimal('driver_longitude', 10, 7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('novapi_driverprofile');
    }
};
