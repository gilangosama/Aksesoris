<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('design_inquiries', 'chain_size')) {
                $table->string('chain_size')->nullable()->after('chain_style_id')->comment('Selected chain size option');
            }
        });
    }

    public function down(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('design_inquiries', 'chain_size')) {
                $table->dropColumn('chain_size');
            }
        });
    }
};
