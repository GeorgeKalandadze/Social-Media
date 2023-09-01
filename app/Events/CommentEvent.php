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


    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->saveNotification();
    }


    private function saveNotification()
    {
        $this->user->notifications()->create([
            'notifiable_type' => get_class($this->comment->post),
            'notifiable_id' => $this->comment->post->id,
            'author_id' => $this->user->id,
            'is_read' => false,
        ]);
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
            'message' => "writes comment on your post",
            'message_author' => $this->user->name,
            'comment_id' => $this->comment->id,

        ];
    }

    public function broadcastAs(): string
    {
        return 'new-comment';
    }
}
