<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'owner_id' => $this->owner_id,
            'author_id' => $this->author_id,
            'is_read' => $this->is_read,
            'message' => "liked your post"
        ];
    }
}
