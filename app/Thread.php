<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Traits\RecordsActivity;
use App\Traits\Subscribable;
use Illuminate\Database\Eloquent\Model;
use \App\Notifications\ThreadWasUpdated;

class Thread extends Model
{
    use RecordsActivity, Subscribable;

    protected $guarded = [];

    protected $appends = ['subscriptionsCount', 'isSubscribed'];

    protected $with = ['owner', 'channel'];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function notifySubscribers(Reply $reply)
    {
        $this->subscriptions->where('user_id', '!=', $reply->user_id)
            ->each(function($subscription) use ($reply) {
                $subscription->user->notify(new ThreadWasUpdated($reply));
            });
    }

    public function getCacheVisitKeyAttribute()
    {
        return sprintf("users.%s.visits.%s", auth()->id(), $this->id);
    }

    public function hasUpdateForUser()
    {
        return $this->updated_at > \cache($this->cacheVisitKey);
    }
}
