<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    private $token ;
    public function __construct($resource,$withToken)
    {
        if ($withToken) {
            $this->token = $resource->createToken($resource->email,['admin'])->plainTextToken;
        }

        parent::__construct($resource);

    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
        if ($this->token) {
            $data['token'] = $this->token;
        }
        return $data;
    }
}
