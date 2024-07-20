<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userId' => $this->id,
            'userName' => $this->name,
            'userEmail' => $this->email,
            'userPhone' => $this->phone,
            'userGender' => $this->gender,
            'userBirth' => $this->birth,
            'userAdmin' => $this->is_admin,
            'token' => $this->whenNotNull($this->token),
            'userImage' => $this->getFirstMediaUrl('userProfile') ?: $this->getDefaultImageUrl(),
            'userFavourite' => ProductResource::collection($this->whenLoaded('favourites')),
        ];
    }
    protected function getDefaultImageUrl(): string
    {
        return $this->gender === 'female' ? url('assets/images/woman.svg') : url('assets/images/man.svg');
    }
}
