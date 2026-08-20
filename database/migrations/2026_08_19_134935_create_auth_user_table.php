<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auth_user', function (Blueprint $table) {
            $table->id();
            $table->string('password', 128);
            $table->dateTime('last_login')->nullable();
            $table->string('username', 150)->unique();
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->string('email', 254)->nullable();
            $table->boolean('is_active')->default(1);
            $table->dateTime('date_joined')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth_user');
    }
};
