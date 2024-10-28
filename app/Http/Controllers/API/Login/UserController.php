<?php

namespace App\Http\Controllers\API\Login;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\API\Login\LoginController;


class UserController extends LoginController
{
    private UserRepository $userRepository;
    public function __construct(Request $request,UserRepository $userRepository){
        $this->email = $request->email;
        $this->password = $request->password;
        $this->userRepository = $userRepository;
    }
    protected function generate_token()
    {
      $this->token = $this->auth->createToken('user',['user'])->plainTextToken;
    }
    protected function set_auth(){

        $this->auth = $this->userRepository->retrieve_user(['email' => $this->email]);
      }
      protected function set_rules():array{
        return [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ];
     }
     protected function response(): JsonResponse
     {
      return (new UserResource($this->auth,true))->additional(['message' => 'User logged in'])->response()->setStatusCode(200);
     }
}
