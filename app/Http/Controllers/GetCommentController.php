<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Post;
use Illuminate\Http\Request;

class GetCommentController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $comments = $post->comments()
            ->with('childCommentsRecursive', 'childCommentsRecursive.childCommentsRecursive')
            ->whereNull('parent_comment_id')
            ->get();
        $comments = $this->attachVoteStatusRecursive($request->user(), $comments);

        return CommentResource::collection($comments);
    }

    private  function attachVoteStatusRecursive($user, $comments)
    {
        foreach ($comments as $key => $comment) {
            $comment['user_name'] = $comment->user->name;
//            $comment['votes'] = (int) $comment->totalVotes();
//            $user->attachVoteStatus($comment);

            if ($comment->childCommentsRecursive) {
                $comments[$key]['childComments'] = $this->attachVoteStatusRecursive($user, $comment->childCommentsRecursive);
            }
        }
        return $comments;
    }
}
