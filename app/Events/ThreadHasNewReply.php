<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Reply;

class ThreadHasNewReply
{
    use SerializesModels;

    public $thread, $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->thread = $reply->thread;
        $this->reply = $reply;
    }
}
