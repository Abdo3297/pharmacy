<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "offerId" => $this->id,
            "offerName" => $this->name,
            "offerDiscountType" => $this->discount_type,
            "offerDiscountValue" => $this->discount_value,
            "offerStartDate" => $this->start_date,
            "offerEndDate" => $this->end_date,
            'createdAt'=> $this->created_at,
            'updatedAt'=> $this->updated_at,
            'products' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}
