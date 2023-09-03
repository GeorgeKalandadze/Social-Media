<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Post;
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

        $message = '';

        // Check the notifiable_type and set the message accordingly
        if ($this->notifiable_type === Post::class) {
            $message = 'liked your post';
        } elseif ($this->notifiable_type === Comment::class) {
            $message = 'wrote a comment on your post';
        }

        return [
            'id' => $this->id,
            'author_name' => $author ? $author->name : 'Unknown',
            'is_read' => $this->is_read ? true : false,
            'message' => $message,
        ];
    }
}
