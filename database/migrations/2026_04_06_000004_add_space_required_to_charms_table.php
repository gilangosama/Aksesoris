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
            if (!Schema::hasColumn('charms', 'space_required')) {
                $table->integer('space_required')->default(1)->after('stock')->comment('Space units required for this charm (1-5)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('charms', function (Blueprint $table) {
            if (Schema::hasColumn('charms', 'space_required')) {
                $table->dropColumn('space_required');
            }
        });
    }
};
