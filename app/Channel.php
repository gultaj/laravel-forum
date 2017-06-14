<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use Searchable;
    
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
