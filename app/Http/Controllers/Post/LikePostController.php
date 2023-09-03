<?php

namespace App\Http\Controllers\Post;
use App\Events\LikeNotification;
use App\Models\Notification;
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
           $notification = Notification::create([
                'owner_id' => $post->user_id,
                'notifiable_type' => get_class($post),
                'notifiable_id' => $post->id,
                'author_id' => $user->id,
                'is_read' => false,
            ]);
            $notification_id = $notification->id;
            event(new LikeNotification($post, $user, $notification_id));
            return "upVoted";

        }
        $request->user()->cancelVote($post);
        return "downVoted";
    }
}
