<?php

namespace App\Http\Controllers;

use App\{Thread, Reply};
use Illuminate\Http\Request;
use App\Http\Requests\CreateReplyRequest;

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

    public function store(CreateReplyRequest $request, Thread $thread)
    {
        try{
            $this->authorize('create', new Reply);
        } catch (\Exception $e) {
            return response(['body'=> ['ttt']], 422);
        }
        $reply = $thread->replies()->create([
            'body' => $request->body,
            'user_id' => $request->user()->id
        ]);
        event(new \App\Events\ThreadHasNewReply($reply));

        return $reply->load('owner');
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
