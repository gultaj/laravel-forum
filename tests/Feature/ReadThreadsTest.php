<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }
    public function testAUserCanViewAllThreads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function testAUserCanViewSingleThread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    public function testAUserCanViewRepliesForAThread()
    {
        $reply = factory(Reply::class)->create([
            'thread_id' => $this->thread->id
        ]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);

    }
}
