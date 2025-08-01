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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id');
        
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->longText('options')->nullable(); // to store size, color, etc.
            $table->boolean('rstatus')->default(false); // e.g., return status
        
            $table->timestamps();
        
            // Foreign Key Constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
