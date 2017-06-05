<?php

namespace App\Notifications;

use App\Thread;
use App\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ThreadWasUpdated extends Notification
{
    use Queueable;

    protected $reply, $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
        $this->thread = $reply->thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->getNotification();
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->getNotification());
    }

    private function getNotification()
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link' => \URL::route('threads.show', [$this->thread->channel, $this->thread], false),
        ];
    }
}
