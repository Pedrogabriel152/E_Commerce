<?php

namespace App\Http\Controllers;

use ErrorException;
use App\Mail\OrderShipped;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use App\Services\TokenService;
use App\Repositories\UserRepository;
use App\Services\VerificationService;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    private UserRepository $userRepository_;
    private PermissionRepository $permissionRepository_;
    private $jwt;
    private array $requiredFileds_ = ['name', 'email', 'cpf', 'phone', 'address', 'permission_id', 'password'];

    public function __construct()
    {
        $this->userRepository_ = new UserRepository();
        $this->permissionRepository_ = new PermissionRepository();
    }

    public function register(Request $request) {
        try {
            VerificationService::verifyFields($request, $this->requiredFileds_);

            $permission = $this->permissionRepository_->getPermission($request->permission_id);

            if(!$permission) throw new ErrorException('Permission not exists', 500);

            $userExist = $this->userRepository_->getUserByEmail($request->email);

            if($userExist) throw new ErrorException('User already exists', 500);

            $newUser = $this->userRepository_->create($request);

            if(!$newUser) throw new ErrorException('An error has occurred', 500);

            $token = TokenService::createToken($newUser, 8);

            return response()->json([
                'message' => 'User created successfully',
                'token' => $token,
                'user_id' => $newUser->id,
                'permission' => $permission->id
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function login(Request $request){
        try {
            VerificationService::verifyFields($request, ['email', 'password']);

            $userExist = $this->userRepository_->getUserByEmail($request->email);

            VerificationService::verifyEmailPasswordCorrect($request, $userExist);
            
            $token = TokenService::createToken($userExist, 8);
    
            return response()->json([
                'message' => 'Usuário logado com sucesso!',
                'token' => $token,
                'user_id' => $userExist->id
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], $th->getCode());
        }
        
    }

    public function forgotPassword(Request $request) {
        // try {
        //     if(!$request->password) {
        //         return throw new ErrorException('O campo de senha é obrigatório', 500);
        //     }

        //     $token = TokenService::getToken($request);
        //     $user_id= TokenService::verifyToken($token);

        //     if(!$user_id) {
        //         return throw new ErrorException('Acesso negado', 500);
        //     }

        //     $user = $this->userRepository->getUserByID($user_id);

        //     if(!$user) {
        //         return throw new ErrorException('Falha a atualizar a senha', 500);
        //     }

        //     $updateUser = $this->userRepository->updatePassword($user, $request->password);
        //     $updateUser->update(['reset_token' => null]);

        //     if(!$updateUser) {
        //         return throw new ErrorException('Falha a atualizar a senha', 500);
        //     }

        //     $token = TokenService::createToken($user, 8);

        //     return response()->json([
        //         'message' => 'Senha alterada com sucesso',
        //         'user_id' => $user->id,
        //         'token' => $token
        //     ], 200);
            
        // } catch (\Exception $ex) {
        //     return response()->json([
        //         'message' => $ex->getMessage(),
        //     ], 500);
        // }
    }

    public function emailRecoverPassword(Request $request) {
        // $email = $request->email;
        // $subject = 'Redefinição de senha';
        // $view = 'forgot_password';

        // $user = $this->userRepository->getUserByEmail($email);

        // if (! $user) {
        //     return response()->json(['message' => 'Usuário não encontrado'], 404);
        // }

        // $token = TokenService::createTokenPassword($user);

        // $user->update(['reset_token' => $token]);

        // Mail::to($user)->send(new OrderShipped($subject, $view, $user, $token));

        // return response()->json(['message' => 'E-mail de redefinição de senha enviado', 'token' => $token], 200);
    }
}
