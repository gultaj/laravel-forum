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

        $this->assertDatabaseHas('threads', $thread->toArray());
        $this->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
