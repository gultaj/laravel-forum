<?php

namespace Tests\Feature;

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

        $this->signIn()
            ->post('/threads', $thread->toArray());
        
        $this->assertDatabaseHas('threads', [
            'title' => $thread->title,
            'body' => $thread->body
        ]);

        $this->get('/threads')
            ->assertSee($thread->title);

        $this->get(route('threads.show', $thread))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function testAnUnauthenticateUserCannotCreateThreads()
    {
        $this->expectUnauthenticated();

        $response = $this->post('/threads', []);
    }

    public function testGuestCannotSeeTheCreateThreadPage()
    {
        $this->withExceptionHandling()->get('/threads/create')
            ->assertRedirect('/login');
    }
}
