<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class UpdatePostController extends Controller
{
    public function __invoke(PostRequest $request, $id): PostResource
    {
        $post = Post::find($id);
        if ($request->user()->id !== $post->user_id) {
            throw new AuthorizationException('You are not authorized to update this post.');
        }
        $data = $request->validated();

        $currentImageCount = $post->postImages->count();
        $allowedImageCount = 5;

        if (isset($data['images']) && is_array($data['images'])) {
            if ($currentImageCount + count($data['images']) > $allowedImageCount) {
                throw new \InvalidArgumentException('This post can only have up to '.$allowedImageCount.' images.');
            }

            foreach ($data['images'] as $index => $image) {
                $imageName = $post->id . time() . $index . $image->getClientOriginalName();
                $image->storeAs('public/post_images', $imageName);

                PostImage::create([
                    'post_id' => $post->id,
                    'path' => env('APP_URL') . Storage::url('post_images/' . $imageName),
                ]);
            }
        }

        $post->load('postImages');
        return new PostResource($post);
    }


}

