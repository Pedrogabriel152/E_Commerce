<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;

class VerificationService
{
    public static function verifyFields(array $fields, Request $request = null, array $data = null) {
        foreach ($fields as $key => $field) {
            if(!$request && !$data[$field]) throw new ErrorException('The '.$field.' field is required', 402); 
            if($request && !$request->$field) throw new ErrorException('The '.$field.' field is required', 402);
        }
    }

    public static function verifyEmailPasswordCorrect(Request $request, $user){
        if(!$user) throw new ErrorException('Incorrect email or password', 403);
        if(!password_verify($request->password, $user->password)) throw new ErrorException('Incorrect email or password', 403);
    }

    public static function verifyPermission(string $permission_accepted) {
        $permission = Permission::find(auth()->user()->permission_id);

        if($permission->description !== 'Admin' || $permission->description !== $permission_accepted) throw new ErrorException('permission denied', 403);
    }
}