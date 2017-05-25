<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function testNotificationWhenSubscribedThreadReceiveANewReply()
    {
        $thread = \create_testing(\App\Thread::class);

        $this->signIn();

        $this->post(route('threads.subscribe', $thread));

        $this->assertCount(0, \auth()->user()->notifications);

        $reply = \create_testing(\App\Reply::class, ['thread_id' => $thread->id]);

        $this->assertCount(1, \auth()->user()->fresh()->notifications);
    }

    public function testNotNotificationToOwnerReply()
    {
        $thread = \create_testing(\App\Thread::class);

        $this->signIn();

        $this->post(route('threads.subscribe', $thread));

        $reply = \create_testing(\App\Reply::class, [
            'thread_id' => $thread->id,
            'user_id' => \auth()->id()
        ]);

        $this->assertCount(0, \auth()->user()->fresh()->notifications);
    }

    public function testAUserCanClearNotifications()
    {
        $this->signIn();

        $thread = \create_testing(\App\Thread::class);

        $this->post(route('threads.subscribe', $thread));

        $reply = \create_testing(\App\Reply::class, ['thread_id' => $thread->id]);

        $this->assertCount(1, \auth()->user()->unreadNotifications);
        
        $this->delete(route('users.notifications', \auth()->user()));

        $this->assertCount(0, \auth()->user()->fresh()->unreadNotifications);
    }
}
