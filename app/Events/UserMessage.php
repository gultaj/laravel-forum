<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.notification');
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->reply->thread->title,
            'link' => \URL::route('threads.show', [$this->reply->thread->channel, $this->reply->thread], false),
        ];
    }

    public function broadcastAs()
    {
        return 'UserMessage';
    }
}
