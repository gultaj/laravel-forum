<?php

namespace App\Filters;

class ThreadFilters extends Filters 
{
    protected $filters = ['by', 'popular', 'unanswered'];

    protected function by($username)
    {
        $user = \App\User::whereName($username)->firstOrFail();
        return $this->builder->whereUserId($user->id);
    }

    protected function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->builder->groupBy('threads.id')->having('replies_count', 0);
    }
}