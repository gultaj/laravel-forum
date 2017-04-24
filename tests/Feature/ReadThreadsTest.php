<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create_testing(Thread::class);
    }
    public function testAUserCanViewAllThreads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testAUserCanViewSingleThread()
    {
        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($this->thread->title);
    }

    public function testAUserCanViewRepliesForAThread()
    {
        $reply = create_testing(Reply::class, [
            'thread_id' => $this->thread->id
        ]);

        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($reply->body);
    }

    public function testAUserCanFilterThreadsByTag()
    {
        $thread1 = create_testing(Thread::class);
        $thread2 = create_testing(Thread::class);

        $this->get(route('threads.index', $thread1->channel))
            ->assertSee($thread1->title)
            ->assertDontSee($thread2->title);
    }

    public function testAUserCanFilterThreadsByUsername()
    {
        $anotherThread = create_testing(Thread::class);

        $this->get(route('threads.index', [null, 'by' => $this->thread->owner->name]))
            ->assertSee($this->thread->title)
            ->assertDontSee($anotherThread->title);
    }

    public function testAUserCanFilterThreadsByPopularity()
    {
        $thread3Replies = create_testing(Thread::class);
        create_testing(Reply::class, [
            'thread_id' => $thread3Replies->id
        ], 3);
        $thread2Replies = create_testing(Thread::class);
        create_testing(Reply::class, [
            'thread_id' => $thread2Replies->id
        ], 2);

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
