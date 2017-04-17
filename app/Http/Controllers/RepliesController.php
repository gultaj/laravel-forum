<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request, Thread $thread)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $thread->replies()->create([
            'body' => $request->body,
            'user_id' => $request->user()->id
        ]);

        return back();
    }
}
