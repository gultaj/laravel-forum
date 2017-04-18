<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    public function testAChannelHaveThreads()
    {
        $channel = create(Channel::class);
        $channel->threads()->saveMany([
            $thread = create_testing(Thread::class),
            create_testing(Thread::class),
            create_testing(Thread::class),
        ]);

        $this->assertInstanceOf(Collection::class, $channel->threads);
        $this->assertTrue($channel->threads->contains($thread));
    }
}
