<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'order_id' => $this->id,
            'order_status' => strtolower($this->status),
            'order_total' => number_format($this->total,2),
            'order_items' => OrderItemCollection::collection($this->items),
        ];
    }
}
