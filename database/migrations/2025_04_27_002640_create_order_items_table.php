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
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Link to orders table
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null'); // Link to product, set null if product deleted
            $table->string('product_name'); // Store name at time of order
            $table->integer('quantity');
            $table->decimal('price', 8, 2); // Store price at time of order
            $table->timestamps();
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
