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
            if (!Schema::hasColumn('design_inquiries', 'charm_id')) {
                $table->foreignId('charm_id')->nullable()->after('chain_style_id')->constrained('charms')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            if (Schema::hasColumn('design_inquiries', 'charm_id')) {
                $table->dropForeign(['charm_id']);
                $table->dropColumn('charm_id');
            }
        });
    }
};
