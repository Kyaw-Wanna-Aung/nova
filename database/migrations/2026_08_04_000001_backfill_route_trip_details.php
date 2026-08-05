<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('route_managements')->whereNull('from_location')->update(['from_location' => DB::raw('origin')]);
        DB::table('route_managements')->whereNull('to_location')->update(['to_location' => DB::raw('destination')]);
        DB::table('route_managements')->whereNull('category')->update(['category' => DB::raw('type')]);
    }

    public function down(): void
    {
    }
};
