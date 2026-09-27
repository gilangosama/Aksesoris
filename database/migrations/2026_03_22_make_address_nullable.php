<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make the old 'address' column nullable using raw SQL
        if (Schema::hasColumn('addresses', 'address')) {
            DB::statement('ALTER TABLE addresses MODIFY address TEXT NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('addresses', 'address')) {
            DB::statement('ALTER TABLE addresses MODIFY address TEXT NOT NULL');
        }
    }
};
