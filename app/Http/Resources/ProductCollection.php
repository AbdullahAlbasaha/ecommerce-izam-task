<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    private array $meta;
    public function __construct($resource)
    {
        $this->meta = [
            "current_page" =>  $resource->currentPage(),
            "from" => $resource->firstItem(),
            "last_page" => $resource->lastPage(),
            "per_page" => $resource->perPage(),
            "to" => $resource->lastItem(),
            "total" => $resource->total()
        ];
        $resource = $resource->getCollection();

        parent::__construct($resource);

    }

    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'data' => $this->mappingData(),
            'meta' => $this->meta,
        ];
    }
    private function mappingData()
    {
       return $this->collection->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'sku' => $item->sku,
                'price' => $item->price,
                'stock' => $item->stock,
            ];
        });
    }
}
