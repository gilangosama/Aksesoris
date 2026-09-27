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
        Schema::table('charms', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['customizable_jewelry_id']);
            $table->dropColumn('customizable_jewelry_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('charms', function (Blueprint $table) {
            // Add column back
            $table->unsignedBigInteger('customizable_jewelry_id')->after('id');
            // Add foreign key back
            $table->foreign('customizable_jewelry_id')
                ->references('id')
                ->on('customizable_jewelry')
                ->onDelete('cascade');
        });
    }
};
