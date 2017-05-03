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
        $this->signIn();
        $thread = create_testing(Thread::class, ['user_id' => auth()->id()]);
        $reply = create_testing(Reply::class, ['thread_id' => $thread->id]);

        $this->json('DELETE', route('threads.destroy', $thread))
            ->assertStatus(204);
   
        $this->assertDatabaseMissing('threads', $thread->toArray());
        $this->assertDatabaseMissing('replies', $reply->toArray());
        
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => 'thread'
        ]);
         $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'subject_type' => 'reply'
        ]);

        
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
