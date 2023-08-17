<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'parent_comment_id' => $this->parent_comment_id,
            'post_id' => $this->post_id,
            'replies' => CommentResource::collection($this->whenLoaded('childCommentsRecursive')),
            'votes' => (int)$this->totalVotes,
            'has_voted' => $user ? $user->attachVoteStatus($this->resource)['has_voted'] : false,
        ];
    }
}
