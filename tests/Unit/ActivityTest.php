<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    public function testRecordActivityWhenAThreadIsCreated()
    {
        $this->signIn();
        $thread = create_testing(\App\Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => \App\Thread::class,
        ]);

        $activity = \App\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function testRecordActivityWhenAReplyIsCreated()
    {
        $this->signIn();
        $reply = create_testing(\App\Reply::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => \App\Reply::class,
        ]);

        $this->assertEquals(2, \App\Activity::count());
    }

    public function testItFetchesAFeedForAnyUser()
    {
        $this->signIn();

        create_testing(\App\Thread::class, ['user_id' => auth()->id()]);
        create_testing(\App\Thread::class, [
            'user_id' => auth()->id(),
            'created_at' => \Carbon\Carbon::now()->subWeek()
        ]);

        $feed = \App\Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(\Carbon\Carbon::now()->format('Y-m-d')));

    }
}
