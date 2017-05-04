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

    /**
     * Remove the specified resource from storage
     * 
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->favorites->each->delete();
        $reply->delete();

        return back()->with('flash', 'Reply deleted');
    }
}
