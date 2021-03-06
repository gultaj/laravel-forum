<?php

namespace App\Http\Controllers;

use App\{Channel, Thread, User};
use App\Inspections\Spam;
use App\Filters\ThreadFilters;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel|null $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->whereChannelId($channel->id);
        }

        $threads = $threads->get();

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads->load('channel'),
            'channel' => $channel,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id'
        ],[
            'channel_id.*' => 'The selected Channel name is invalid.'
        ]);

        Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user()->id,
            'channel_id' => $request->channel_id,
        ]);

        return redirect()
            ->route('threads.index')
            ->with('flash', 'Your thread is published');
    }

    /**
     * Display the specified resource.
     *
     * @param Channel $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        \cache()->forever($thread->cacheVisitKey, \Carbon\Carbon::now());

        return view('threads.show', [
            'thread' => $thread,
            'channel' => $channel,
            'members' => User::get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Thread $thread)
    {
        $this->authorize('change', $thread);
        $thread->replies->each->delete();
        $thread->delete();

        if (request()->wantsJson()) {
            return response(null, 204); 
        }

        return redirect()->route('threads.index')->with('flash', 'Thread deleted');;
    }
}
