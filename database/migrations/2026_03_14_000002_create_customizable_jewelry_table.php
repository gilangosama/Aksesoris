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
        Schema::create('customizable_jewelry', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // necklace, bracelet, hand_chain, earring, keychain
            $table->string('label'); // Display name
            $table->string('icon'); // Emoji icon
            $table->text('description')->nullable();
            $table->decimal('base_price', 8, 2)->default(250); // Starting price
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customizable_jewelry');
    }
};
