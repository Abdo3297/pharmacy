<?php

namespace App\Http\Resources\Api;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pharmacy = Pharmacy::find(1);
        return [
            'aboutId' => $this->id,
            'aboutContent' => $this->content,
            'pharmacyLogo' => $pharmacy->getFirstMediaUrl('pharmacyLogo'),
        ];
    }
}
