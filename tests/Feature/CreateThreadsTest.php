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
        $thread = make_testing(Thread::class);

        $this->signIn()
            ->post('/threads', $thread->toArray());
        
        $this->assertDatabaseHas('threads', [
            'title' => $thread->title,
            'body' => $thread->body
        ]);

        $this->get('/threads')
            ->assertSee($thread->title);

        $thread = Thread::where('title', $thread->title)->first();
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
