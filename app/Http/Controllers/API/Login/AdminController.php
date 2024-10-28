<?php

namespace App\Http\Controllers\API\Login;


use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\AdminResource;
use App\Repositories\Eloquent\AdminRepository;
use App\Http\Controllers\API\Login\LoginController;

class AdminController extends LoginController
{
  private AdminRepository $adminRepository;
    public function __construct(Request $request,AdminRepository $adminRepository){
        $this->email = $request->email;
        $this->password = $request->password;
        $this->adminRepository = $adminRepository;

    }
    protected function generate_token()
    {
      $this->token = $this->auth->createToken('admin', ['admin'])->plainTextToken;
    }
    protected function set_auth(){

      $this->auth = $this->adminRepository->retrieve_admin(['email' => $this->email]);
    }
    protected function set_rules():array{
      return [
          'email' => 'required|email|exists:admins',
          'password' => 'required',
      ];
   }
   protected function response(): JsonResponse
     {
      return (new AdminResource($this->auth,true))->additional(['message' => 'Admin logged in'])->response()->setStatusCode(200);
     }
}
