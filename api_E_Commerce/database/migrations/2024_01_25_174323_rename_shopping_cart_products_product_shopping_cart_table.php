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
        Schema::rename('shopping_cart_products', 'product_shopping_cart');

        Schema::table('product_shopping_cart', function (Blueprint $table) {
            $table->renameColumn('shopping_cart', 'shopping_cart_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('product_shopping_cart', 'shopping_cart_products');

        Schema::table('shopping_cart_products', function (Blueprint $table) {
            $table->renameColumn('shopping_cart_id', 'shopping_cart');
        });
    }
};
