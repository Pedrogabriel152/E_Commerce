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
        Schema::table('shopping_carts', function (Blueprint $table) {
            $table->integer('quantity_products')->nullable(false);
        });

        Schema::table('order_histories', function (Blueprint $table) {
            $table->integer('quantity_products')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shopping_carts', function (Blueprint $table) {
            $table->integer('quantity_products')->nullable(false);
        });

        Schema::table('order_histories', function (Blueprint $table) {
            $table->dropColumn('quantity_products');
        });
    }
};
