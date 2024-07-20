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
        Schema::create('product_side', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignId('side_id')
                ->constrained('sides')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->unique(['side_id', 'product_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_side');
    }
};
