<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('design_inquiries', 'chain_style_id')) {
                $table->foreignId('chain_style_id')->nullable()->after('finish')->constrained('chain_styles')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('design_inquiries', 'chain_style_id')) {
                $table->dropForeign(['chain_style_id']);
                $table->dropColumn('chain_style_id');
            }
        });
    }
};
