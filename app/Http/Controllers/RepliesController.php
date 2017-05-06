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

        return back()->with('flash', 'Reply created');
    }

    /**
     * Remove the specified resource from storage
     * 
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('change', $reply);

        $reply->favorites->each->delete();
        $reply->delete();

        if (\request()->ajax()) {
            return \response(['status' => 'Reply deleted']);
        }

        return back()->with('flash', 'Reply deleted');
    }

    public function update(Reply $reply)
    {
        $this->authorize('change', $reply);
        $reply->update(request(['body']));
    }
}
