<?php

namespace App\GraphQL\Mutations;

use App\Services\ProductService;
use App\Services\ShoppingCartService;

class ProductMutation
{

    private ProductService $productService_;
    private ShoppingCartService $shoppingCartService_;

    public function __construct()
    {
        $this->productService_ = new ProductService();
        $this->shoppingCartService_ = new ShoppingCartService();
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
    }

    public function create($_, array $args) {
        $response = $this->productService_->create($args['product']);
        return $response;
    }

    public function update($_, array $args) {
        $response = $this->productService_->update(intval($args['id']), $args['product']);
        return $response;
    }

    public function delete($_, array $args) {
        $response = $this->productService_->delete(intval($args['id']));
        return $response;
    }

    public function addToCart($_, array $args) 
    {
        $response = $this->shoppingCartService_->addToCart($args);
        return $response;
    }

    public function removeToCart($_, array $args) 
    {
        $response = $this->shoppingCartService_->removeToCart($args);
        return $response;
    }
}
