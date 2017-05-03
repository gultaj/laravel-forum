<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user, $times = 50)
    {
        return static::whereUserId($user->id)
            ->latest()
            ->with('subject')
            ->get()
            ->groupBy(function($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
