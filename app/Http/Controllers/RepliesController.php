<?php

namespace App\Http\Controllers;

use App\{Thread, Reply};
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index(Thread $thread)
    {
        return $thread->replies()->paginate(25);
    }

    public function store(Request $request, Thread $thread)
    {
        try{
            $this->authorize('create', new Reply);
            $this->validate($request, ['body' => 'required|spamfree']);

            $reply = $thread->replies()->create([
                'body' => $request->body,
                'user_id' => $request->user()->id
            ]);
        } catch (\Exception $e) {
            return response('ttt', 422);
        }

        event(new \App\Events\ThreadHasNewReply($reply));

        return $reply->fresh()->load('owner');
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
        $this->validate(request(), ['body' => 'required|spamfree']);
        $reply->update(request(['body']));
    }
}
