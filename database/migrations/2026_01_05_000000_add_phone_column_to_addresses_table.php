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
        if (Schema::hasTable('addresses') && !Schema::hasColumn('addresses', 'phone')) {
            Schema::table('addresses', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('address');
            });

            // Copy existing values from phone_number to phone if present
            try {
                DB::statement('UPDATE addresses SET phone = phone_number');
            } catch (\Exception $e) {
                // ignore if something goes wrong during copying
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('addresses') && Schema::hasColumn('addresses', 'phone')) {
            Schema::table('addresses', function (Blueprint $table) {
                // Dropping columns on sqlite may require doctrine/dbal; skip if not supported
                try {
                    $table->dropColumn('phone');
                } catch (\Exception $e) {
                    // ignore
                }
            });
        }
    }
};
