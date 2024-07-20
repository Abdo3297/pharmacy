<?php

namespace App\Http\Resources\Api;

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
        return [
            'orderId' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'totalAmount' => $this->total_amount,
            'paymentId'=> $this->payment_id,
            'paymentType'=> $this->payment_type,
            'createdAt'=> $this->created_at,
            'updatedAt'=> $this->updated_at,
        ];
    }
}
