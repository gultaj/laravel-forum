<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @return void
     */
    public function testAUserCanViewAllThreads()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    public function testAUserCanViewSingleThread()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }
}
