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
            if (!Schema::hasColumn('charms', 'stock')) {
                $table->integer('stock')->default(999)->after('price_add')->comment('Available stock quantity');
            }
            if (!Schema::hasColumn('charms', 'category')) {
                $table->string('category')->nullable()->after('stock')->comment('Charm category for filtering');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('charms', function (Blueprint $table) {
            $table->dropColumn(['stock', 'category']);
        });
    }
};
