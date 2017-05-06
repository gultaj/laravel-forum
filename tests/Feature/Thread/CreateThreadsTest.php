<?php

namespace Tests\Feature\Thread;

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

        $this->signIn();
        
        $response = $this->post('/threads', $thread->toArray());
        
        $this->assertDatabaseHas('threads', [
            'title' => $thread->title,
            'body' => $thread->body
        ]);

        $this->get('/threads')
            ->assertSee($thread->title);

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function testAThreadRequiresATitle()
    {
        $this->_publishThread(['title' => ''])
            ->assertSessionHasErrors('title');
    }

    public function testAThreadRequiresABody()
    {
        $this->_publishThread(['body' => ''])
            ->assertSessionHasErrors('body');
    }

    public function testAThreadRequiresAValidChannel()
    {
        $this->_publishThread(['channel_id' => 2])
            ->assertSessionHasErrors('channel_id');
    }

    public function testAnUnauthenticateUserCannotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads')->assertRedirect('/login');
    }

    private function _publishThread($overrides = [])
    {
        $thread = make_testing(Thread::class, $overrides);
        $this->withExceptionHandling()->signIn();
        return $this->post('/threads', $thread->toArray());
    }

}
