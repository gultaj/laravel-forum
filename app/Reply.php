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
            $reply->thread->subscriptions->each(function($subscription) use ($reply) {
                if ($subscription->user_id != $reply->user_id) {
                    $subscription->user->notify(new ThreadWasUpdated($reply));
                }
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
