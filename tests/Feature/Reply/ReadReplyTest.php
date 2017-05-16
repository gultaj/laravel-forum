<?php

namespace Tests\Feature\Reply;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanRequestAllRepliesForAGivenThread()
    {
        $this->signIn();
        $thread = create_testing(Thread::class);
        $replies = \create_testing(Reply::class, ['thread_id' => $thread->id], 3);

        $response = $this->getJson(\route('replies.index', $thread))->json();
        // dd($response);
        $this->assertCount(1, $response['data']);
        $this->assertEquals(3, $response['total']);
    }
}
