<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
{
    protected $includeName;

    protected $includeLogo;

    protected $includeCarousel;

    public function __construct($resource, $includeName = true, $includeLogo = true, $includeCarousel = true)
    {
        parent::__construct($resource);
        $this->includeName = $includeName;
        $this->includeLogo = $includeLogo;
        $this->includeCarousel = $includeCarousel;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        if ($this->includeName) {
            $data['pharmacyName'] = $this->name;
        }
        if ($this->includeLogo) {
            $data['pharmacyLogo'] = $this->getFirstMediaUrl('pharmacyLogo');
        }
        if ($this->includeCarousel) {
            $data['pharmacyCarousel'] = $this->getMedia('pharmacyCarousel')->map(function ($media) {
                return $media->getUrl();
            })->toArray();
        }

        return $data;
    }
}
