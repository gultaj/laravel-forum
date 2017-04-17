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
        $channel = create(Channel::class);
        $thread = create(Thread::class, [
            'user_id' => create(User::class)->id,
            'channel_id' => $channel->id,
        ]);
        $reply = make(Reply::class);

        $this->signIn()
            ->post(route('replies.store', $thread), $reply->toArray());
            
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);


        $this->get(route('threads.show', [$channel, $thread]))
            ->assertSee($reply->body);
    }

    public function testAnUnauthenticatedUserMayNotAddReply()
    {
        $this->withExceptionHandling()
            ->post(route('replies.store', create(Thread::class)))
            ->assertRedirect('/login');
    }
}
