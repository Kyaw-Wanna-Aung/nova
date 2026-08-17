<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('townships', function (Blueprint $table) {
            $table->dropUnique(['name']);

            $table->string('region_name', 100)
                ->nullable()
                ->after('mm_name');

            $table->string('region_mm_name', 100)
                ->nullable()
                ->after('region_name');

            $table->enum('region_type', [
                'Region',
                'State',
                'Union Territory',
            ])
                ->nullable()
                ->after('region_mm_name');

            $table->unique(
                ['region_name', 'name'],
                'townships_region_name_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('townships', function (Blueprint $table) {
            $table->dropUnique(
                'townships_region_name_unique'
            );

            $table->dropColumn([
                'region_name',
                'region_mm_name',
                'region_type',
            ]);

            $table->unique('name');
        });
    }
};