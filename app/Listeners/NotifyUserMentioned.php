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
        collect($matches[1])
            ->map(function($name) {
                return User::whereName($name)->first();
            })
            ->filter()
            ->each
            ->notify(new UserWereMentioned($event->reply));
    }
}
