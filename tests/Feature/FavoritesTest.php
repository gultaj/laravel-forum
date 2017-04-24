<?php

namespace Tests\Feature;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnAuthenticatedUserCanFavoriteAnyReply()
    {
        $reply = create_testing(Reply::class);


        $this->signIn()
            ->post(route('replies.favorites', $reply));

        $this->assertCount(1, $reply->favorites);
    }

    public function testAnAuthenticatedUserCanFavoriteReplyOnce()
    {
        $reply = create_testing(Reply::class);

        $this->signIn()
            ->post(route('replies.favorites', $reply));
            
        $this->post(route('replies.favorites', $reply));

        $this->assertCount(1, $reply->favorites);
    }

    public function testGuestCannotFavoriteAnything()
    {
        $reply = create_testing(Reply::class);

        $this->withExceptionHandling();

        $this->post(route('replies.favorites', $reply))
            ->assertRedirect('/login');
    }
}
