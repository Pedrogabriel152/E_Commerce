<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductShoppingCart;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;

class ShoppingCartRepository 
{
    public function __construct()
    {
        
    }

    public function addToCart(int $amount, User &$user, Product &$product, ShoppingCart &$shoppingCartExist = null, ProductShoppingCart &$productShoppingCart = null){
        return DB::transaction(function () use ($amount, $product, $user, $shoppingCartExist, $productShoppingCart) {
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

            if(!$productShoppingCart){
                ProductShoppingCart::create([
                    'product_id' => $product->id,
                    'shopping_cart_id' => $shoppingCart? $shoppingCart->id : $shoppingCartExist->id,
                    'amount' => $amount
                ]);
            }else{
                $productShoppingCart->amount += $amount;
                $productShoppingCart->save();
            }

            $product->amount -= $amount;
            $product->save();

            return $shoppingCart? $shoppingCart : $shoppingCartExist;
        });
    }

    public function removeToCart(ShoppingCart &$shoppingCart, Product &$product, ProductShoppingCart &$productShoppingCart){
        return DB::transaction(function () use ($shoppingCart, $product, $productShoppingCart) {
            $product->amount += 1;

            $shoppingCart->total -= $product->price;
            $shoppingCart->quantity_products -= 1;
            $shoppingCart->save();

            if($productShoppingCart->amount > 1){
                $productShoppingCart->amount -= 1;
                $productShoppingCart->save();
            } else {
                $productShoppingCart->delete();
            }

            $product->save();
        });
    }

    public function completePurchase(ShoppingCart &$shoppingCart) {
        return DB::transaction(function () use ($shoppingCart) {
            $shoppingCart->paid_out = true;
            $shoppingCart->save();
        });
    }
}