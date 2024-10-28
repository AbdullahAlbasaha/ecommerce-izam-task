<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\UserRepositoryInterface as UserRepository;

class RegisterController extends Controller
{

     public function register(RegisterRequest $request,UserRepository $userRepository)
     {
      try {
        return $userRepository->create_user($request)->additional(['message' => 'Register succeed'])->response()->setStatusCode(201);
      } catch (\Throwable $th) {
        $this->response_has_errors($th->getMessage(),'field to register new user !',code:500);
      }

     }
    }

