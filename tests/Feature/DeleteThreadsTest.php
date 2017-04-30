<?php

namespace Tests\Feature;

use App\Thread;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteThreadsTest extends TestCase
{
    use DatabaseMigrations;
   
   
    public function testAThreadCanBeDeleted()
    {

        $thread = create_testing(Thread::class);
        $reply = create_testing(Reply::class, ['thread_id' => $thread->id]);

        $this->signIn($thread->owner()->first())
            ->json('DELETE', route('threads.destroy', $thread))
            ->assertStatus(204);
            
        $this->assertDatabaseMissing('threads', $thread->toArray());
        $this->assertDatabaseMissing('replies', $reply->toArray());

        
        $this->get(route('threads.index'))
            ->assertDontSee($thread->title);
    }

    public function testGuestCannotDeleteThreads()
    {
        $thread = create_testing(Thread::class);

        $this->withExceptionHandling();
        $this->delete(route('threads.destroy', $thread))
            ->assertRedirect('/login');
    }

    public function testThreadMayDeletedOnlyByOwner()
    {
        $thread = create_testing(Thread::class);

        $this->withExceptionHandling()
            ->signIn()
            ->delete(route('threads.destroy', $thread))
            ->assertStatus(403);

        // $this->assertSee($thread->title);
    }
}
