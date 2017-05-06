<?php

namespace Tests\Feature\Reply;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnAuthorizedUserCanUpdateReply()
    {
        $this->signIn();

        $reply = \create_testing(\App\Reply::class, ['user_id' => auth()->id()]);
        $newreply = \make_testing(\App\Reply::class);

        $this->patch(route('replies.update', $reply), [
            'body' => $newreply->body
        ]);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => $newreply->body
        ]);
    }

    public function testAnUnauthorizedUserCannotUpdateReply()
    {
        $reply = \create_testing(\App\Reply::class);

        $this->withExceptionHandling()
            ->patch(route('replies.update', $reply), ['body' => 'New body'])
            ->assertRedirect('/login');

        $this->signIn()
            ->patch(route('replies.update', $reply), ['body' => 'New body'])
            ->assertStatus(403);
    }
}
