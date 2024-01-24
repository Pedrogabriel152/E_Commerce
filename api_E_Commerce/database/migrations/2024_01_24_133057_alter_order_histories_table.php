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
        Schema::dropIfExists('order_history_products');
        Schema::dropIfExists('order_history');
        Schema::dropIfExists('order_histories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->float('amount', 10, 2);
            $table->boolean('paid_out')->default(false)->nullable(false);
            $table->timestamps();
        });
        Schema::create('order_history_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('order_history_id')->constrained('order_history')->onDelete('cascade');
            $table->timestamps();
        });

       
    }
};
