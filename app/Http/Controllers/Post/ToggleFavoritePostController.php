<?php

namespace App\Http\Controllers\Post;

use App\Events\LikeNotification;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToggleFavoritePostController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $user = Auth::user();
        if ($user->favorites()->where('post_id', $post->id)->exists()) {
            $user->favorites()->detach($post);

            return "favorited";
        } else {
            $user->favorites()->attach($post);
            return "unfavorited";
        }
    }

}
