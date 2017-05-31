<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use App\Channel;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function testAThreadHasReplies()
    {
        $thread = create_testing(Thread::class);
        $thread->replies()->saveMany([
            $reply = create_testing(Reply::class),
            create_testing(Reply::class)
        ]);

        $this->assertInstanceOf(Collection::class, $thread->replies);
        $this->assertTrue($thread->replies->contains($reply));
    }

    public function testAThreadHasOwner()
    {
        $thread = create_testing(Thread::class);

        $this->assertInstanceOf(User::class, $thread->owner);
    }

    public function testAThreadBelongToChannel()
    {
        $thread = create_testing(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

    public function testNotifyAllSubscribersForThread()
    {
        Notification::fake();

        $this->signIn();

        $thread = create_testing(Thread::class);
        $thread->subscribe();

        $reply = \create_testing(\App\Reply::class, ['thread_id' => $thread->id]);

        $thread->notifySubscribers($reply);

        Notification::assertSentTo(\auth()->user(), ThreadWasUpdated::class);
    }
}
