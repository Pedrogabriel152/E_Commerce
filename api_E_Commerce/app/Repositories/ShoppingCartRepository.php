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

    public function addToCart(int $amount, User $user, Product $product, ShoppingCart $shoppingCartExist = null){
        return DB::transaction(function () use ($amount, $product, $user, $shoppingCartExist) {
            $shoppingCart = null;
            if(!$shoppingCartExist) {
                $shoppingCart = ShoppingCart::create([
                    'buyer_id' => $user->id,
                    'total' => $product->price * $amount,
                    'quantity_products' => $amount
                ]);
            } else {
                $shoppingCartExist->total += $product->price * $amount;
                $shoppingCartExist->quantity_products += $amount;
                $shoppingCartExist->save();
            }           

            ShoppingCartProducts::create([
                'product_id' => $product->id,
                'shopping_cart' => $shoppingCart? $shoppingCart->id : $shoppingCartExist->id,
                'amount' => $amount
            ]);


            $product->amount -= $amount;
            $product->save();

            return $shoppingCart? $shoppingCart : $shoppingCartExist;
        });
    }

    public function completePurchase(ShoppingCart &$shoppingCart) {
        return DB::transaction(function () use ($shoppingCart) {
            $shoppingCart->paid_out = true;
            $shoppingCart->save();
        });
    }
}