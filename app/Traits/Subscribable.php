<?php

namespace App\Traits;

use App\Subscription;

trait Subscribable
{
    protected static function bootSubscribable()
    {
        if (auth()->guest()) return ;

        static::deleting(function($model) {
            $model->subscriptions->each->delete();
        });
    }

    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribe');
    }

    public function subscribe($userId = null)
    {
       return $this->subscriptions()->create(['user_id' => $userId ?: auth()->id()]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: \auth()->id())
            ->delete();
    }

    public function getSubscriptionsCountAttribute()
    {
        return $this->subscriptions()->count();
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }
}