<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'subcategory' => [
                'id' => $this->whenLoaded('subCategory', function () {
                    return $this->subCategory->id;
                }),
                'name' => $this->whenLoaded('subCategory', function () {
                    return $this->subCategory->name;
                }),
            ],
            'images' => PostImageResource::collection($this->whenLoaded('postImages')),
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
