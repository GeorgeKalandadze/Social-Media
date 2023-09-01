<?php

namespace App\Http\Resources;

use App\Models\User;
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
        $owner = User::find($this->owner_id);
        $author = User::find($this->author_id);

        return [
//            'owner_name' => $owner ? $owner->name : 'Unknown',
            'author_name' => $author ? $author->name : 'Unknown',
            'is_read' => $this->is_read,
            'message' => "liked your post"
        ];
    }
}
