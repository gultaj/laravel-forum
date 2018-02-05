<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function testItHasAnOwner()
    {
        $reply = create_testing(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    public function testReplyIsJustWasPublished()
    {
        $reply = create_testing(Reply::class);
        $this->assertTrue($reply->justWasPublished());
    }
}
