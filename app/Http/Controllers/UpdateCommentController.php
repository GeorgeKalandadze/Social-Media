<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

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
