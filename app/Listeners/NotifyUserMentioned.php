<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Notifications\UserWereMentioned;

class NotifyUserMentioned
{
    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        preg_match_all('/@([\w.]+)(?=\b.)/', $event->reply->body, $matches);
        User::whereIn('name', $matches[1])->get()
            ->each
            ->notify(new UserWereMentioned($event->reply));
    }
}
