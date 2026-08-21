<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('novapi_vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewed_by')
                ->nullable()
                ->after('rejection_reason');

            $table->timestamp('reviewed_at')
                ->nullable()
                ->after('reviewed_by');
        });
    }

    public function down(): void
    {
        Schema::table('novapi_vehicle', function (Blueprint $table) {
            $table->dropColumn([
                'reviewed_by',
                'reviewed_at',
            ]);
        });
    }
};