<?php

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LikeNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $user;
    public $notification_id;

    /**
     * Create a new event instance.
     */
    public function __construct(Post $post, User $user, $notification_id)
    {
        $this->post = $post;
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
        return new PrivateChannel('like-channel.'.$this->post->id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification_id,
            'message' => "liked your post",
            'author_name' => $this->user->name,
            'is_read' => false,
//            'post_id' => $this->post->id,

        ];
    }

    public function broadcastAs(): string
    {
        return 'new-like';
    }
}
