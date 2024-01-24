<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Services\ShoppingCartService;

final readonly class ShoppingCartMutation
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

    public function completePurchase($_, array $args) 
    {
        $response = $this->shoppingCartService_->completePurchase(intval($args['id']));
        return $response;
    }
}
