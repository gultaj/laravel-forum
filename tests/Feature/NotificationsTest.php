<?php

namespace Tests\Feature;

use Tests\TestCase;
use \Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function  setUp()
    {
        parent::setUp();
        
        $this->signIn();
        $this->thread = \create_testing(\App\Thread::class);
    }

    public function testNotificationWhenSubscribedThreadReceiveANewReply()
    {
        $this->post(route('threads.subscribe', $this->thread));

        $this->assertCount(0, \auth()->user()->notifications);

        $reply = \create_testing(\App\Reply::class, ['thread_id' => $this->thread->id]);

        $this->assertCount(1, \auth()->user()->fresh()->notifications);
    }

    public function testNotNotificationToOwnerReply()
    {
        $this->post(route('threads.subscribe', $this->thread));

        $reply = \create_testing(\App\Reply::class, [
            'thread_id' => $this->thread->id,
            'user_id' => \auth()->id()
        ]);

        $this->assertCount(0, \auth()->user()->fresh()->notifications);
    }

    public function testAUserCanClearNotifications()
    {
        $notification = create(DatabaseNotification::class);

        $this->assertCount(1, \auth()->user()->unreadNotifications);
        
        $this->delete(route('users.notifications.destroy', [\auth()->user(), $notification]));

        $this->assertCount(0, \auth()->user()->fresh()->unreadNotifications);
    }

    public function testGetAllUserNotifications()
    {
        \create(DatabaseNotification::class, [], $notifications_count = 10);

        $response = $this->getJson(\route('users.notifications', auth()->user()))->json();
        // dd($response);
        $this->assertCount($notifications_count, $response);

    }
}
