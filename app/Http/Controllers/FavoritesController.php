<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        if (!$reply->favorites()->whereUserId(auth()->id())->exists()) {
            $reply->favorites()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}
