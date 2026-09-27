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
        // Create pivot table for many-to-many relationship between design_inquiries and charms
        Schema::create('charm_design_inquiry', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_inquiry_id');
            $table->unsignedBigInteger('charm_id');
            $table->integer('charm_position_x')->default(225)->comment('Charm X position in pixels');
            $table->integer('charm_position_y')->default(225)->comment('Charm Y position in pixels');
            $table->timestamps();

            // Foreign keys
            $table->foreign('design_inquiry_id')
                ->references('id')
                ->on('design_inquiries')
                ->onDelete('cascade');

            $table->foreign('charm_id')
                ->references('id')
                ->on('charms')
                ->onDelete('cascade');

            // Unique constraint to prevent duplicate charm selections
            $table->unique(['design_inquiry_id', 'charm_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charm_design_inquiry');
    }
};
