<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chain_styles', function (Blueprint $table) {
            if (!Schema::hasColumn('chain_styles', 'sizes')) {
                $table->json('sizes')->nullable()->after('description')->comment('Available chain size options');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chain_styles', function (Blueprint $table) {
            if (Schema::hasColumn('chain_styles', 'sizes')) {
                $table->dropColumn('sizes');
            }
        });
    }
};
