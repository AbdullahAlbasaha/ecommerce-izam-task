<?php

namespace App\Http\Controllers\API\Login;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Auth\User as Auth;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    protected string|null $email;
    protected string|null $password;
    protected string $token;
    //auth
    protected Auth|null $auth;

     public function login(Request $request)
     {
         //validation
        $this->validation($request,$this->set_rules());
        //set auth model
        $this->set_auth();
        //check auth
        $this->check_auth();
        //generate token
        $this->generate_token();
        //success response
      return $this->response();

     }


     public function check_auth()
     {
        if (! $this->auth || ! Hash::check($this->password, $this->auth->password)) {
            $this->response_has_errors('credentials are invalid ','logged in failed');
        }
     }
     protected function generate_token()
     {

     }
     protected function set_auth(){

     }
      protected function set_rules():array{
        return [
           
        ];
     }
     protected function response()
     {

     }
}
