<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('route_managements', function (Blueprint $table) {
            $table->string('from_location')->nullable()->after('origin');
            $table->string('to_location')->nullable()->after('destination');
            $table->string('category')->nullable()->after('type');
            $table->unsignedInteger('available_seats')->nullable()->after('category');
            $table->date('departure_date')->nullable()->after('available_seats');
            $table->time('departure_time')->nullable()->after('departure_date');
            $table->decimal('fare', 12, 2)->nullable()->after('departure_time');
            $table->string('image')->nullable()->after('fare');
        });
    }

    public function down(): void
    {
        Schema::table('route_managements', function (Blueprint $table) {
            $table->dropColumn(['from_location', 'to_location', 'category', 'available_seats', 'departure_date', 'departure_time', 'fare', 'image']);
        });
    }
};
