<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Reply;


class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUserCanFetchTheirRecentReply()
    {
        $user = create(User::class);
        $reply = create_testing(Reply::class,[
            'user_id' => $user->id
        ]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }
}
