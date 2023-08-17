<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ToggleFavoritePostController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $user = Auth::user();

        if ($user->favorites()->where('post_id', $post->id)->exists()) {
            $user->favorites()->detach($post);
            return response()->json(['message' => 'Post removed from favorites']);
        } else {
            $user->favorites()->attach($post);
            return response()->json(['message' => 'Post added to favorites']);
        }
    }

}
