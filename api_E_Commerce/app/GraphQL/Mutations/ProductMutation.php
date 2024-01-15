<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Services\ProductService;

class ProductMutation
{

    private $productService_;

    public function __construct()
    {
        $this->productService_ = new ProductService();
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
        $response = $this->productService_->update($args['product']);
        return $response;
    }
}
