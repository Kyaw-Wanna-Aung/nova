<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('novapi_vehicle', function (Blueprint $table) {
            $table->foreignId('vehicle_brand_id')
                ->nullable()
                ->after('vehicle_number')
                ->constrained('vehicle_brands')
                ->nullOnDelete();

            $table->foreignId('vehicle_model_id')
                ->nullable()
                ->after('vehicle_brand_id')
                ->constrained('vehicle_models')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('novapi_vehicle', function (Blueprint $table) {
            $table->dropForeign(['vehicle_model_id']);
            $table->dropForeign(['vehicle_brand_id']);

            $table->dropColumn([
                'vehicle_model_id',
                'vehicle_brand_id',
            ]);
        });
    }
};