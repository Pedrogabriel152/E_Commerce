<?php 

namespace App\GraphQL\Mutations;

use App\Services\PermissionService;

class PermissionMutation
{
    private $permissionService;

    public function __construct()
    {
        $this->permissionService = new PermissionService();
    }

    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
    }

    public function create($_, array $args)
    {
        $response = $this->permissionService->create($args['permission']['description']);
        return $response;
    }
}
