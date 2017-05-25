<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribesToTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanSubscribeToThreads()
    {
        $thread = \create_testing(\App\Thread::class);

        $this->signIn();

        $this->post(route('threads.subscribe', $thread));

        $this->assertCount(1, $thread->subscriptions);  
    }
}
