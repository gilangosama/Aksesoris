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
        // Update customizable_jewelry base_price to bigger decimal for Rupiah
        Schema::table('customizable_jewelry', function (Blueprint $table) {
            $table->decimal('base_price', 15, 0)->change();
        });

        // Update products price to bigger decimal for Rupiah
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 15, 0)->change();
            $table->decimal('original_price', 15, 0)->nullable()->change();
        });

        // Update order_items price to bigger decimal for Rupiah
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 15, 0)->change();
        });

        // Update orders amounts to bigger decimal for Rupiah
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('amount', 15, 0)->nullable()->change();
            $table->decimal('total_price', 15, 0)->nullable()->change();
        });

        // Update charms price_add to bigger decimal for Rupiah
        Schema::table('charms', function (Blueprint $table) {
            $table->decimal('price_add', 15, 0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original decimal for USD
        Schema::table('customizable_jewelry', function (Blueprint $table) {
            $table->decimal('base_price', 8, 2)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
            $table->decimal('original_price', 10, 2)->nullable()->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable()->change();
            $table->decimal('total_price', 10, 2)->nullable()->change();
        });

        Schema::table('charms', function (Blueprint $table) {
            $table->decimal('price_add', 8, 2)->change();
        });
    }
};
