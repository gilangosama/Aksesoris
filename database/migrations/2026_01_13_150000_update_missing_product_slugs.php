<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update products dengan slug null atau empty
        \DB::statement("
            UPDATE products 
            SET slug = LOWER(CONCAT(
                REPLACE(name, ' ', '-'),
                '-',
                id
            ))
            WHERE slug IS NULL OR slug = ''
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak bisa direverse dengan sempurna
    }
};
