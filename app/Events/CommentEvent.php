<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $comment;
    public $user;
    public $notification_id;

    public function __construct(Comment $comment, User $user, $notification_id)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->notification_id = $notification_id;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel|array
    {
        return new PrivateChannel('comment-channel.'.$this->comment->post->id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification_id,
            'message' => "writes comment on your post",
            'author_name' => $this->user->name,
            'is_read' => false,

        ];
    }

    public function broadcastAs(): string
    {
        return 'new-comment';
    }
}
