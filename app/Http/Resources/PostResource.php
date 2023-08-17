<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $user = auth()->user();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'subcategory' => [
                'id' => $this->whenLoaded('subCategory', function () {
                    return $this->subCategory->id;
                }),
                'name' => $this->whenLoaded('subCategory', function () {
                    return $this->subCategory->name;
                }),
            ],
            'images' => PostImageResource::collection($this->whenLoaded('postImages')),
            'user' => new UserResource($this->whenLoaded('user')),
            'votes' => (int)$this->totalVotes,
            'has_voted' => $user ? $user->attachVoteStatus($this->resource)['has_voted'] : false,
        ];
    }
}
