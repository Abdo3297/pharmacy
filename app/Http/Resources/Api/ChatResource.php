<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "sender_id"=> $this->sender_id,
            "receiver_id"=> $this->receiver_id,
            "message"=> $this->message,
            'chatFiles' => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
