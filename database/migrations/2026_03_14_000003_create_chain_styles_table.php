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
        Schema::create('chain_styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customizable_jewelry_id')
                ->constrained('customizable_jewelry')
                ->onDelete('cascade');
            $table->string('name'); // e.g., "Gold Link Chain", "Silver Rope Chain"
            $table->enum('finish', ['silver', 'gold']); // Chain metal finish
            $table->string('image')->nullable(); // Image of the chain style
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Index for faster filtering
            $table->index('customizable_jewelry_id');
            $table->index('finish');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chain_styles');
    }
};
