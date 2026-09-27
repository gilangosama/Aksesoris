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
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['engagement_ring', 'necklace', 'bracelet', 'earring'])->default('engagement_ring');
            $table->enum('style', ['modern', 'vintage', 'classic', 'bohemian'])->default('modern');
            $table->enum('material', ['18k_gold', 'platinum', 'rose_gold', 'white_gold', 'silver'])->default('18k_gold');
            $table->boolean('featured')->default(false);
            $table->boolean('client_pick')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('limited')->default(false);
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
