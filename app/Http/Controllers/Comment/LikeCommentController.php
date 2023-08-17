<?php

namespace App\Http\Controllers\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

class LikeCommentController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $post = Comment::find($id);
        $voteData = $request->user()->attachVoteStatus($post);

        if (!$voteData->has_upvoted) {
            $request->user()->upvote($post);
            return "upVoted";
        }

        $request->user()->cancelVote($post);
        return "downVoted";
    }
}
