<?php
namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Traits\HelperTrait;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface {
    use HelperTrait;
  /**
     * create new user
     *
     * store new user into db and return it as response
     *
     * @param RegisterRequest $request
     * @return userResource
     * @throws \Exception
     **/
    public function create_user(RegisterRequest $request){
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
               ]);
                return new UserResource($user,true);
        } catch (\Throwable $th) {
            $this->error_log('create user error',$th);
            throw $th;
        }
    }
  /**
     * retrieve user
     *
     * retrieve user by specific fields and where clause
     *
     * @param array $fields
     * @return User
     * @throws \Exception
     **/
    public function retrieve_user(array $fields = []){
        try {

            return User::where($fields)->first();
        } catch (\Throwable $th) {
            $this->error_log('retrieve user',$th);
            throw $th;
        }
    }
}
