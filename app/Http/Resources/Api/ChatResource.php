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
            'id' => $this->id,
            'filachat_conversation_id' => $this->filachat_conversation_id,
            'message' => $this->message,
            'attachments' => $this->attachments,
            'original_attachment_file_names' => $this->original_attachment_file_names,
            'senderable_id' => $this->senderable_id,
            'receiverable_id' => $this->receiverable_id,
        ];
    }
}
