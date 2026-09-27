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
        // Set default empty string for existing NULL values first
        DB::statement("UPDATE addresses SET address = '' WHERE address IS NULL");
        
        // Then modify the column to be nullable with default empty string
        DB::statement('ALTER TABLE addresses MODIFY address TEXT DEFAULT "" NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE addresses MODIFY address TEXT NOT NULL');
    }
};
