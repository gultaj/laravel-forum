<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\Favorite;
use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    public function testRecordActivityWhenAThreadIsCreated()
    {
        $this->signIn();
        $thread = create_testing(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function testRecordActivityWhenAReplyIsCreated()
    {
        $this->signIn();
        $reply = create_testing(Reply::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => 'reply',
        ]);

        $this->assertEquals(2, Activity::count());
    }

    public function testRecordActivityWhenAFavoritedReply()
    {
        $this->signIn();
        $reply = create_testing(Reply::class);

        $this->post(route('replies.favorites', $reply));

        $this->assertDatabaseHas('activities', [
            'type' => 'created',
            'user_id' => auth()->id(),
            'subject_id' => $reply->favorites()->first()->id,
            'subject_type' => 'favorite',
        ]);

        $this->assertEquals(3, Activity::count());
    }

    public function testItFetchesAFeedForAnyUser()
    {
        $this->signIn();

        create_testing(Thread::class, ['user_id' => auth()->id()]);
        $thread = create_testing(Thread::class, [
            'user_id' => auth()->id(),
            'created_at' => \Carbon\Carbon::now()->subWeek()
        ]);

        $thread->activity()->first()->update(['created_at' => \Carbon\Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user());
        
        $this->assertTrue($feed->keys()->contains(\Carbon\Carbon::now()->format('Y-m-d')));
        $this->assertTrue($feed->keys()->contains(\Carbon\Carbon::now()->subWeek()->format('Y-m-d')));

    }
}
