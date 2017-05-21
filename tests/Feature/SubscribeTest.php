<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanSubscribeToThreads()
    {
        $thread = \create_testing(\App\Thread::class);

        $this->signIn();

        $this->post(route('threads.subscribe', $thread));

        $this->assertCount(1, $thread->subscriptions);

        $reply = \create_testing(\App\Reply::class, [
            'thread_id' => $thread->id,
            'user_id' => \auth()->id(),
        ]);

        // $this->assertCount(1, \auth()->user()->notifications);
    }
}
