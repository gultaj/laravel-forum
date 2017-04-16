<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->signIn()
            ->post(route('replies.store', $thread), $reply->toArray());
            
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->get(route('threads.show', $thread))
            ->assertSee($reply->body);
    }

    public function testAnUnauthenticateUserMayNotAddReply()
    {
        $thread = create(Thread::class);

        $this->expectUnauthenticated();

        $response = $this->post(route('replies.store', $thread), []);
    }
}
