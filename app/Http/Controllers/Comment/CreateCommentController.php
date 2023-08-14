<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CreateCommentController extends Controller
{
    public function __invoke(CommentRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $data->post_id,
            'body' => $data->body,
            'parent_comment_id' => $data->parent_comment_id,
        ]);

        return response()->json($comment);
    }
}
