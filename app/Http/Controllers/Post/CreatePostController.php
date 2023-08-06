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

class CreatePostController extends Controller
{
    public function __invoke(PostRequest $request): PostResource
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $post = Post::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'sub_category_id' => $data['sub_category_id'],
                'user_id' => $request->user()->id
            ]);

            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $index => $image) {
                    $imageName = $post->id  . time()  . $index . $image->getClientOriginalName();
                    $image->storeAs('public/post_images', $imageName);

                    PostImage::create([
                        'post_id' => $post->id,
                        'path' => env('APP_URL').Storage::url('post_images/' . $imageName),
                    ]);
                }
            }
            DB::commit();
            $post->load('postImages');
            return new PostResource($post);
        }catch (\Exception $exception)
        {
            DB::rollBack();
            throw $exception;
        }
    }
}
