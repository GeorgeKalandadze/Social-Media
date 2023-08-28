<?php

namespace App\Http\Controllers\Post;
use App\Events\LikeNotification;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LikePostController extends Controller
{
    public function __invoke(Request $request, $postId)
    {
        $post = Post::find($postId);
        $voteData = $request->user()->attachVoteStatus($post);
        $user = Auth::user();
        if (!$voteData->has_upvoted) {
            $request->user()->upvote($post);
            event(new LikeNotification($post, $user));
            return "upVoted";
        }
        $request->user()->cancelVote($post);
        return "downVoted";
    }


}
