<?php

namespace App\Services;

use ErrorException;
use App\Repositories\PermissionRepository;

class PermissionService 
{
    private PermissionRepository $permissionRepository_;
    private array $requiredFileds_ = [
        'description',
    ];

    public function __construct() {
        $this->permissionRepository_ = new PermissionRepository();
    }

    public function create(string $description){
        try {
            VerificationService::verifyFields($this->requiredFileds_, null, ['description' => $description]);

            VerificationService::verifyPermission('Admin');

            $permission = $this->permissionRepository_->save($description);

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