<?php

namespace App\Http\Controllers;

use \App\Thread;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Model;

class SubscribesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeThread(Thread $thread)
    {
        $thread->subscribe();
    }

    public function destroyThread(Thread $thread)
    {
        $thread->unsubscribe();
    }

}
