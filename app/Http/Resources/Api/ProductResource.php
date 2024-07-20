<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productId' => $this->id,
            'productName' => $this->name,
            'productDescription' => $this->description,
            'productUnitPrice' => $this->unit_price,
            'productNoUnits' => $this->no_units,
            'productBarcode' => $this->barcode,
            'productStock' => $this->stock,
            'productImage' => MediaResource::collection($this->whenLoaded('media')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'side_effects' => SideResource::collection($this->whenLoaded('sideEffects')),
            'indications' => IndicationResource::collection($this->whenLoaded('indications')),
            'offer' => OfferResource::collection($this->whenLoaded('offers')),
        ];
    }
}
