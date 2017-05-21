<?php

namespace App;

use App\Traits\RecordsActivity;
use App\Traits\Subscribable;
use Illuminate\Database\Eloquent\Model;

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
}
