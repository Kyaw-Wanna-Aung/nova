<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('novapi_vehicle')
            ->where('approval_status', 'pending')
            ->update(['approval_status' => '0']);

        DB::table('novapi_vehicle')
            ->where('approval_status', 'approved')
            ->update(['approval_status' => '1']);

        DB::table('novapi_vehicle')
            ->where('approval_status', 'rejected')
            ->update(['approval_status' => '2']);

        DB::statement(
            'ALTER TABLE novapi_vehicle
             MODIFY approval_status TINYINT UNSIGNED NOT NULL DEFAULT 0'
        );

        DB::statement(
            'ALTER TABLE novapi_vehicle
             MODIFY status TINYINT UNSIGNED NOT NULL DEFAULT 0'
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE novapi_vehicle
             MODIFY approval_status VARCHAR(20) NOT NULL DEFAULT 'pending'"
        );

        DB::statement(
            'ALTER TABLE novapi_vehicle
             MODIFY status INT NOT NULL DEFAULT 1'
        );
    }
};