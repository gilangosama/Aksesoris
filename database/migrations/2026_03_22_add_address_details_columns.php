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
        Schema::table('addresses', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('addresses', 'recipient_name')) {
                $table->string('recipient_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('addresses', 'street')) {
                $table->text('street')->nullable()->after('recipient_name');
            }
            if (!Schema::hasColumn('addresses', 'city')) {
                $table->string('city')->nullable()->after('street');
            }
            if (!Schema::hasColumn('addresses', 'province')) {
                $table->string('province')->nullable()->after('city');
            }
            if (!Schema::hasColumn('addresses', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('province');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'recipient_name')) {
                $table->dropColumn('recipient_name');
            }
            if (Schema::hasColumn('addresses', 'street')) {
                $table->dropColumn('street');
            }
            if (Schema::hasColumn('addresses', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('addresses', 'province')) {
                $table->dropColumn('province');
            }
            if (Schema::hasColumn('addresses', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
        });
    }
};
