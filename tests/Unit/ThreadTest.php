<?php

namespace Tests\Unit;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function testAThreadHasReplies()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Collection::class, $thread->replies);
    }

    public function testAThreadHasOwner()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(User::class, $thread->owner);
    }
}
