<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionRepository
{
    public function __construct() {

    }

    public function save(string $description) {
        return DB::transaction(function () use ($description) {
            $permission = Permission::create([
                'description' => $description
            ]);
            return $permission;
        });
    }
}