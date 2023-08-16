<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class UpdateCommentController extends Controller
{
    public function __invoke(CommentRequest $request, Comment $comment)
    {
        $data = $request->validated();
        if ($comment->post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->update([
            'body' => $data['body'],
        ]);

        return response()->json($comment);
    }
}
