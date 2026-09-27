<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (!Schema::hasColumn('design_inquiries', 'design_snapshot')) {
                $table->longText('design_snapshot')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('design_inquiries', 'design_snapshot')) {
                $table->dropColumn('design_snapshot');
            }
        });
    }
};
