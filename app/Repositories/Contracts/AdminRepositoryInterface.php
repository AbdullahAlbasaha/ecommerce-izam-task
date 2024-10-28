<?php
namespace App\Repositories\Contracts;


use App\Http\Resources\userResource;
use App\Http\Requests\RegisterRequest;



interface AdminRepositoryInterface   {
  /**
     * retrieve admin
     *
     * retrieve admin by specific fields and where clause
     *
     * @param array $fields
     * @return \Illuminate\Http\Response
     * @throws \Exception
     **/
    public function retrieve_admin(array $fields = []);
}
