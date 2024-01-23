<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;
use App\Models\ShoppingCartProducts;

class ShoppingCartRepository 
{
    public function __construct()
    {
        
    }

    public function addToCart(int $amount, User $user, Product $product){
        return DB::transaction(function () use ($amount, $product, $user) {
            $shoppingCart = ShoppingCart::create([
                'buyer_id' => $user->id,
                'amount' => $amount
            ]);

            ShoppingCartProducts::create([
                'product_id' => $product->id,
                'shopping_cart' => $shoppingCart->id
            ]);

            return $shoppingCart;
        });
    }
}