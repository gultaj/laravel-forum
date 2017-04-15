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

    public function testAnUnauthenticateUserMayNotAddReply()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();

        $response = $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        $this->assertInstanceOf('Illuminate\Auth\AuthenticationException', $response->exception);
    }

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();

        $this->actingAs($user = factory(User::class)->create())
            ->post('/threads/' . $thread->id . '/replies', $reply->toArray());
            
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->get(route('threads.show', $thread))
            ->assertSee($reply->body);
    }
}
