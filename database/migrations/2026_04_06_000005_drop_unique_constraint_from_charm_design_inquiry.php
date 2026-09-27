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
        Schema::table('charm_design_inquiry', function (Blueprint $table) {
            if (Schema::hasColumn('charm_design_inquiry', 'design_inquiry_id') && Schema::hasColumn('charm_design_inquiry', 'charm_id')) {
                $table->dropForeign(['design_inquiry_id']);
                $table->dropForeign(['charm_id']);
                $table->dropUnique(['design_inquiry_id', 'charm_id']);
                $table->foreign('design_inquiry_id')
                    ->references('id')
                    ->on('design_inquiries')
                    ->onDelete('cascade');
                $table->foreign('charm_id')
                    ->references('id')
                    ->on('charms')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('charm_design_inquiry', function (Blueprint $table) {
            if (Schema::hasColumn('charm_design_inquiry', 'design_inquiry_id') && Schema::hasColumn('charm_design_inquiry', 'charm_id')) {
                $table->dropForeign(['design_inquiry_id']);
                $table->dropForeign(['charm_id']);
                $table->unique(['design_inquiry_id', 'charm_id']);
                $table->foreign('design_inquiry_id')
                    ->references('id')
                    ->on('design_inquiries')
                    ->onDelete('cascade');
                $table->foreign('charm_id')
                    ->references('id')
                    ->on('charms')
                    ->onDelete('cascade');
            }
        });
    }
};
