<?php

namespace Tests\Feature\Reply;

use App\Channel;
use App\User;
use App\Thread;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $thread = create_testing(Thread::class);
        $reply = make_testing(Reply::class);

        $this->signIn()
            ->post(route('replies.store', $thread), $reply->toArray());
            
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
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

    public function testCannotCreateReplyWithSpam()
    {
        $thread = create_testing(Thread::class);
        $reply = make_testing(Reply::class, ['body' => 'Microsoft']);

        $this->expectException(\Exception::class);

        $this->signIn()
            ->post(route('replies.store', $thread), $reply->toArray());
    }

    private function _publishReply($overrides = [])
    {
        $thread = create_testing(Thread::class);
        $reply = make_testing(Reply::class, $overrides);
        $this->withExceptionHandling()->signIn();
        return $this->post(route('replies.store', $thread), $reply->toArray());
    }
}
