<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'design_inquiry_id')) {
                $table->unsignedBigInteger('design_inquiry_id')->nullable()->after('user_id');
                $table->foreign('design_inquiry_id')->references('id')->on('design_inquiries')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'design_inquiry_id')) {
                $table->dropForeign(['design_inquiry_id']);
                $table->dropColumn('design_inquiry_id');
            }
        });
    }
};
