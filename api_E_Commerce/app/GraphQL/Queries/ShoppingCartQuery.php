<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Services\ShoppingCartService;

class ShoppingCartQuery
{
    private ShoppingCartService $shoppingCartService_;

    public function __construct()
    {
        $this->shoppingCartService_ = new ShoppingCartService();
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
    }

    public function getShoppingaCart($_, array $args) 
    {
        $response = $this->shoppingCartService_->getShoppingaCartByID(intval($args['id']));
        return $response;
    }
}
