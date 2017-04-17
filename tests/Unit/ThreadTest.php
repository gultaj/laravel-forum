<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use App\Channel;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function testAThreadHasReplies()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Collection::class, $thread->replies);
    }

    public function testAThreadHasOwner()
    {
        $thread = create(Thread::class, [
            'user_id' => create(User::class)->id
        ]);

        $this->assertInstanceOf(User::class, $thread->owner);
    }

    public function testAThreadBelongToChannel()
    {
        $thread = create(Thread::class, [
            'channel_id' => create(Channel::class)->id
        ]);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
