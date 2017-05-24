<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = []; 

    protected $appends = ['favoritesCount', 'isFavorited', 'canChange'];

    protected $with = ['owner', 'favorites'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($reply) {
            // if ($reply->thread->subscriptions->count())
            $reply->thread->subscriptions->each(function($subscription) {
                // dd($subscription->user);
                $subscription->user->notify(new ThreadWasUpdated($this->thread, $this));
            });
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function getCanChangeAttribute()
    {
        return auth()->user() and auth()->user()->can('change', $this);
    }

}
