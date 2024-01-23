<?php

namespace App\Services;

use ErrorException;
use App\Models\Product;
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

            $shoppingCart = $this->shoppingCartRepository_->addToCart($data['amount'], $user, $product);

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
}