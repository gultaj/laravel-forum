<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $channels = factory(\App\Channel::class, 5)->create();
        $threads = factory(\App\Thread::class, 10)->create();
        $users = factory(\App\User::class, 20)->create();
        $users->push(factory(App\User::class)->create(['name' => 'gultaj', 'email' => '1@tut.by']));

        $threads->each(function($thread) use ($users, $channels) {
            $thread->replies()->saveMany($replies = factory(App\Reply::class, mt_rand(0, 5))->create());
            $replies->each(function($reply) use ($users) {
                $reply->owner()->associate($users->random());
                $reply->save();
                $reply->activity()->create([
                    'user_id' => $reply->owner->id,
                    'type' => 'created'
                ]);
            });
            $thread->owner()->associate($users->random());
            $thread->channel()->associate($channels->random());
            $thread->save();
            $thread->activity()->create([
                'user_id' => $thread->owner->id,
                'type' => 'created'
            ]);
        });
    }
}
