<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeTest extends TestCase
{
    use DatabaseMigrations;

    public function testAThreadCanBeSubscribedTo()
    {
        $thread = \create_testing(\App\Thread::class);

        $this->signIn();

        $thread->subscribe($userId = \auth()->id());

        $subscriptionCount = $thread->subscriptions()->count();

        $this->assertEquals(1, $subscriptionCount);
        $this->assertTrue($thread->fresh()->is_subscribed);
    }

    public function testAThreadCanBeUnsubscribedFrom()
    {
        $thread = \create_testing(\App\Thread::class);

        $this->signIn();

        $thread->subscribe($userId = \auth()->id());

        $thread->unsubscribe($userId);

        $subscriptionCount = $thread->subscriptions()->count();

        $this->assertEquals(0, $subscriptionCount);
        $this->assertFalse($thread->fresh()->is_subscribed);
    }
}
