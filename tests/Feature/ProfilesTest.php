<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserHasAProfile()
    {
        $user = create(User::class);

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    public function testViewAllUsersThreadsInProfile()
    {
        $this->signIn();
        $user = auth()->user();

        $thread = create_testing(Thread::class, ['user_id' => $user->id]);

        $this->assertDatabaseHas('threads', [
            'user_id' => $thread->user_id,
            'channel_id' => $thread->channel_id
        ]);
        
        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
