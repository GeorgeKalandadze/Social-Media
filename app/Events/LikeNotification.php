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

    /**
     * Create a new event instance.
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;

        $this->saveNotification();
    }


    private function saveNotification()
    {
        $this->user->notifications()->create([
            'notifiable_type' => get_class($this->post),
            'notifiable_id' => $this->post->id,
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
        return new PrivateChannel('like-channel.'.$this->post->id);
    }

    public function broadcastWith(): array
    {
        return [
            'message' => "liked your post",
            'message_author' => $this->user->name,
            'post_id' => $this->post->id,
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-like';
    }
}
