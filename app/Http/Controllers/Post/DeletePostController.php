<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;


class DeletePostController extends Controller
{
    public function __invoke(int $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Invalid post ID.'], 400);
        }
        if (auth()->user()->hasAnyPermission(['delete-post']) || auth()->user()->id === $post->user_id) {
            $postImages = PostImage::where('post_id', $post->id)->get();
            foreach ($postImages as $postImage) {
                $imagePath = str_replace(env('APP_URL'), '', $postImage->path);
                Storage::delete($imagePath);
                $postImage->delete();
            }
            $post->delete();
            return "Post and associated images deleted successfully";
        } else {
            return "You don't have permission to delete this post";
        }
    }

}
