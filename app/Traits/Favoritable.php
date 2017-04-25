<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable {
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }
}