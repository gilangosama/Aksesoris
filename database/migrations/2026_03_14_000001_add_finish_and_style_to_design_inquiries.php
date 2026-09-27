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
            // Add finish and style columns if they don't exist
            if (!Schema::hasColumn('design_inquiries', 'finish')) {
                $table->string('finish')->nullable()->after('type');
            }
            if (!Schema::hasColumn('design_inquiries', 'style')) {
                $table->string('style')->nullable()->after('finish');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            $table->dropColumn(['finish', 'style']);
        });
    }
};
