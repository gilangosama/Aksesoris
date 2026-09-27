<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->nullable()->after('order_id');
            }
            
            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->integer('total_price')->nullable()->after('amount');
            }
            
            if (!Schema::hasColumn('orders', 'is_gift')) {
                $table->boolean('is_gift')->default(false)->after('status');
            }
            
            if (!Schema::hasColumn('orders', 'gift_message')) {
                $table->text('gift_message')->nullable()->after('is_gift');
            }
            
            if (!Schema::hasColumn('orders', 'snap_token')) {
                $table->text('snap_token')->nullable()->after('transaction_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_number')) {
                $table->dropColumn('order_number');
            }
            if (Schema::hasColumn('orders', 'total_price')) {
                $table->dropColumn('total_price');
            }
            if (Schema::hasColumn('orders', 'is_gift')) {
                $table->dropColumn('is_gift');
            }
            if (Schema::hasColumn('orders', 'gift_message')) {
                $table->dropColumn('gift_message');
            }
            if (Schema::hasColumn('orders', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
        });
    }
};
