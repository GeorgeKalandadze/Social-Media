<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeletePostImageController extends Controller
{
    public function __invoke($postId, $imageId): JsonResponse
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['message' => 'Invalid post ID.'], 400);
        }
        if ($post->user_id !== auth()->user()->id) {
            throw new AuthorizationException('You are not authorized to delete images from this post.');
        }
        $image = $post->postImages()->find($imageId);
        if (!$image) {
            throw new \InvalidArgumentException('Image not found for this post.');
        }
        $imagePath = str_replace(env('APP_URL'), '', $image->path);
        Storage::delete('public/post_images/' . basename($imagePath));

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully.']);
    }
}
