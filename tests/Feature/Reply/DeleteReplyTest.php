<?php

namespace Tests\Feature\Reply;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function testUnauthorizedUzerCannotDeleteReply()
    {
        $this->withExceptionHandling();

        $reply = \create_testing(\App\Reply::class);

        $this->delete(route('replies.destroy', $reply))
            ->assertRedirect('/login');
    }

    public function testAnAuthorizedOwnerCanDeleteReply()
    {
        $this->signIn();

        $reply = \create_testing(\App\Reply::class, ['user_id' => \auth()->id()]);
        $favorite = $reply->favorites()->create(['user_id' => \auth()->id()]);

        $this->delete(route('replies.destroy', $reply));

        $this->assertDatabaseMissing('replies', $reply->getAttributes());
        $this->assertDatabaseMissing('favorites', $favorite->toArray());
    }

    public function testReplyMayDeleteOnlyByOwner()
    {
        $reply = \create_testing(\App\Reply::class);

        $this->withExceptionHandling()
            ->signIn()
            ->delete(route('replies.destroy', $reply))
            ->assertStatus(403);
    }
}
