<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;


class DeletePostController extends Controller
{
    public function __invoke(int $id)
    {
        $post = Post::find($id);
        if (auth()->user()->hasAnyPermission(['delete_post'])|| auth()->user()->id === $post->user_id) {
            $post->delete();
            return "post delete successfully";
        } else {
            return "post is not deleted";
        }
    }

}
