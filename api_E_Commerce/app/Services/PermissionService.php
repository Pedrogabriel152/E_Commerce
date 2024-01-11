<?php

namespace App\Services;

use ErrorException;
use App\Repositories\PermissionRepository;

class PermissionService 
{
    private $permissionRepository;

    public function __construct() {
        $this->permissionRepository = new PermissionRepository();
    }

    public function create(string $description){
        try {
            if(!$description) throw new ErrorException('A descrição da permição é obrigatória', 402);

            $permission = $this->permissionRepository->save($description);

            if(!$permission) throw new ErrorException('Ocorreu um erro, tente novamente', 500);

            return [
                'message' => 'Permissão criado com sucesso',
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