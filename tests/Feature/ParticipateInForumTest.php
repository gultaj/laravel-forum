<?php

namespace Tests\Feature;

use App\Channel;
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
        $thread = create_testing(Thread::class);
        $reply = make_testing(Reply::class);

        $this->signIn()
            ->post(route('replies.store', $thread), $reply->toArray());
            
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);


        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertSee($reply->body);
    }

    public function testAnUnauthenticatedUserMayNotAddReply()
    {
        $this->withExceptionHandling()
            ->post(route('replies.store', create(Thread::class)))
            ->assertRedirect('/login');
    }

    public function testAReplyRequiresABody()
    {
        $this->_publishReply(['body' => ''])
        ->assertSessionHasErrors('body');
    }

    private function _publishReply($overrides = [])
    {
        $thread = create_testing(Thread::class);
        $reply = make_testing(Reply::class, $overrides);
        $this->withExceptionHandling()->signIn();
        return $this->post(route('replies.store', $thread), $reply->toArray());
    }
}
