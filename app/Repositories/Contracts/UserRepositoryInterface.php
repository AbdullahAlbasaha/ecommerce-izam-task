<?php
namespace App\Repositories\Contracts;

use App\Models\user;
use Illuminate\Http\Request;
use App\Http\Resources\userResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\userCollection;
use App\Http\Requests\StoreuserRequest;
use App\Http\Requests\UpdateuserRequest;


interface UserRepositoryInterface   {
    /**
     * create new user
     *
     * store new user into db and return it as response
     *
     * @param RegisterRequest $request
     * @return userResource
     * @throws \Exception
     **/
    public function create_user(RegisterRequest $request);

  /**
     * retrieve user
     *
     * retrieve user by specific fields and where clause
     *
     * @param array $fields
     * @return User
     * @throws \Exception
     **/
    public function retrieve_user(array $fields = []);
}
