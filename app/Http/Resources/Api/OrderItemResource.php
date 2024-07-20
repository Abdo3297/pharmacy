<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'orderItemId' => $this->id,
            'orderId' => $this->order_id,
            'productId' => $this->product_id,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unit_price,
            'totalPrice' => ($this->quantity) * ($this->unit_price),
            'createdAt'=> $this->created_at,
            'updatedAt'=> $this->updated_at,
        ];
    }
}
