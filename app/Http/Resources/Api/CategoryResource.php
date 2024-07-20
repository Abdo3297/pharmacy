<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'categoryId' => $this->id,
            'categoryName' => $this->name,
            'categoryImage' => MediaResource::collection($this->whenLoaded('media')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
