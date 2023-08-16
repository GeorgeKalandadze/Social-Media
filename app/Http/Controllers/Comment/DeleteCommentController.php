<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class DeleteCommentController extends Controller
{
    public function __invoke(int $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Invalid comment ID.'], 400);
        }
        if (auth()->user()->hasAnyPermission(['delete-comment']) || auth()->user()->id === $comment->user_id) {
            $comment->delete();
            return "Comment deleted successfully";
        } else {
            return "You don't have permission to delete this comment";
        }
    }
}
