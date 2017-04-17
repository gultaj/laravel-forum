<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnAuthenticatedUserCanCreateNewThreads()
    {
        $thread = make(Thread::class);
        $channel = create(Channel::class);
        $thread->channel_id = $channel->id;

        $this->signIn()
            ->post('/threads', $thread->toArray());
        
        $this->assertDatabaseHas('threads', [
            'title' => $thread->title,
            'body' => $thread->body
        ]);

        $thread = Thread::where('title', $thread->title)->first();

        $this->get('/threads')
            ->assertSee($thread->title);
//        dd(route('threads.show', [$thread->channel, $thread]));
        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function testAnUnauthenticateUserCannotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads')->assertRedirect('/login');
    }

}
