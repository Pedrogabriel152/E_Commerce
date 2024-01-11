<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserRepository
{
    public function create(Request $request) {
        return DB::transaction(function () use ($request) {
            $hash = password_hash($request->password, PASSWORD_BCRYPT);
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hash,
                'phone' => $request->phone,
                'cpf' => $request->cpf,
                'address' => $request->address,
                'permission_id' => $request->permission_id,
            ]);

            return $newUser;
        });
    }

    public function getUserByEmail(string $email){
        $user = User::whereEmail($email)->first();
        return $user;
    }
}