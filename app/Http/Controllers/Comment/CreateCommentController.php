<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CreateCommentController extends Controller
{
    public function __invoke(CommentRequest $request): CommentResource
    {
        $data = $request->validated();
        $user = Auth::user();
        $comment = Comment::create([
            'user_id' => $user->id,
            'post_id' => $data['post_id'],
            'body' => $data['body'],
            'parent_comment_id' => $data['parent_comment_id'],
        ]);
        $comment->load('user');
        return new CommentResource($comment);
    }
}
