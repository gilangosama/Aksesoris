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
            // Drop the old charm_position column
            $table->dropColumn('charm_position');
        });

        Schema::table('design_inquiries', function (Blueprint $table) {
            // Add new coordinate columns (in pixels, relative to 500x500 preview)
            $table->integer('charm_position_x')->default(225)->after('charm_id')->comment('Charm X position in pixels (default center: 225)');
            $table->integer('charm_position_y')->default(225)->after('charm_position_x')->comment('Charm Y position in pixels (default center: 225)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('design_inquiries', function (Blueprint $table) {
            $table->dropColumn(['charm_position_x', 'charm_position_y']);
        });

        Schema::table('design_inquiries', function (Blueprint $table) {
            $table->string('charm_position')->default('center')->after('charm_id')->comment('Position of charm: top, center, bottom, left, right');
        });
    }
};
