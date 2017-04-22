<?php

namespace App\Filters;

class ThreadFilters extends Filters 
{
    protected $filters = ['by'];

    protected function by($username)
    {
        $user = \App\User::whereName($username)->firstOrFail();
        return $this->builder->whereUserId($user->id);
    }
}