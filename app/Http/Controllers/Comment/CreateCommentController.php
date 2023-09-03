<?php

namespace App\Http\Controllers\Comment;

use App\Events\CommentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Notification;
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
        $notification = Notification::create([
            'owner_id' => $comment->post->user_id,
            'notifiable_type' => get_class($comment),
            'notifiable_id' => $comment->id,
            'author_id' => $user->id,
            'is_read' => false,
        ]);
        $notification_id = $notification->id;
        event(new CommentEvent($comment, $user, $notification_id));
        return new CommentResource($comment);
    }
}
