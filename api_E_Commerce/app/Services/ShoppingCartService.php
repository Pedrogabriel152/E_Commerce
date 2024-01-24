<?php

namespace App\Services;

use ErrorException;
use App\Models\Product;
use App\Models\OrderHistory;
use App\Models\ShoppingCart;
use App\Repositories\ShoppingCartRepository;

class ShoppingCartService
{
    private ShoppingCartRepository $shoppingCartRepository_;

    public function __construct()
    {
        $this->shoppingCartRepository_ = new ShoppingCartRepository();
    }

    public function addToCart(array $data) {
        try {
            $product = Product::whereActive(true)->find($data['id']);
            
            if(!$product) throw new ErrorException('product not found', 404);

            if($product->amount < $data['amount']) throw new ErrorException('Quantity not available', 402);

            $user = auth()->user();

            $shoppingCartExist = ShoppingCart::where([
                ['paid_out', '=', false],
                ['buyer_id', '=', $user->id]
            ])->first();

            $shoppingCart = $this->shoppingCartRepository_->addToCart($data['amount'], $user, $product, $shoppingCartExist);

            if(!$shoppingCart) throw new ErrorException('Internal server error', 500);

            return [
                'message' => 'Product added to cart',
                'code' => 200
            ];

        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ];
        }
    }

    public function getShoppingaCartByID(int $id) {
        $shoppingCart = ShoppingCart::where([
            'paid_out' => false,
            'buyer_id' => auth()->user()->id
        ])->find($id);

        if(!$shoppingCart) return null;

        return $shoppingCart;
    }

    public function completePurchase(int $id) {
        try {
            $shoppingCart = ShoppingCart::where([
                'paid_out' => false,
                'buyer_id' => auth()->user()->id
            ])->find($id);
    
            if(!$shoppingCart) throw new ErrorException('shopping cart not found', 404);

            $this->shoppingCartRepository_->completePurchase($shoppingCart);
    
            return [
                'message' => 'purchase completed',
                'code' => 200,
                'shoppingChart' => $shoppingCart
            ];

        } catch (\Throwable $th) {
            return [
                'message' => $th->getMessage(),
                'code' => $th->getCode()
            ];
        }
    }
}