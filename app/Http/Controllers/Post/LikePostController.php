<?php

namespace App\Http\Controllers\Post;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikePostController extends Controller
{
    public function __invoke(Request $request, $postId)
    {
        $post = Post::find($postId);
        $voteData = $request->user()->attachVoteStatus($post);

        if (!$voteData->has_upvoted) {
            $request->user()->upvote($post);
            return "upVoted";
        }

        $request->user()->cancelVote($post);
        return "downVoted";
    }
}
