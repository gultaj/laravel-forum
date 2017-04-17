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
        $reply = create(Reply::class, [
            'user_id' => create(User::class)->id
        ]);

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
