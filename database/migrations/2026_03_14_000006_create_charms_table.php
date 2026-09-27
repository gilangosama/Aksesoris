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
        Schema::create('charms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customizable_jewelry_id')
                ->constrained('customizable_jewelry')
                ->onDelete('cascade');
            $table->string('name'); // e.g., "Diamond Heart", "Pearl Accent"
            $table->string('image')->nullable(); // Image of the charm
            $table->text('description')->nullable();
            $table->decimal('price_add', 8, 2)->default(0); // Price to add for this charm
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Index for faster filtering
            $table->index('customizable_jewelry_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charms');
    }
};
