<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = []; 

    protected $appends = ['favoritesCount', 'isFavorited', 'canChange'];

    protected $with = ['owner', 'favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function justWasPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function getCanChangeAttribute()
    {
        return auth()->user() and auth()->user()->can('change', $this);
    }
}
