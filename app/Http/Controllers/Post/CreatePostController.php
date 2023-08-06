<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreatePostController extends Controller
{
    public function __invoke(PostRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $post = Post::create([
                'title' => $data['title'],
                'body' => $data['body'],
                'subcategory_id' => $data['subcategory_id'],
                'user_id' => $request->user()->id
            ]);
            $images = $data['images'];
            foreach ($images as $index => $image) {
                $imageName = $post->id  . time()  . $index . $image->getClientOriginalName();
                $image->storeAs('public/post_images', $imageName);

                PostImage::create([
                    'post_id' => $post->id,
                    'path' => env('APP_URL').Storage::url('post_images/' . $imageName),
                ]);
            }
            DB::commit();
            $post->load('postImages');
            return response()->json($post);

        }catch (\Exception $exception)
        {
            DB::rollBack();
            throw $exception;
        }
    }
}
