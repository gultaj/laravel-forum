@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>Forum Threads @if($channel->exists) for: {{ $channel->name }} @endif</h1>
                </div>
                        
                @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">{{ $thread->title }}</a>
                                </h4>

                                <strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong>
                            </div>
                        </div>

                        <div class="panel-body">{{ $thread->body }}</div>
                    </div>
                @empty
                    There are no relevant results at this time.
                @endforelse
            </div>
        </div>
    </div>
@endsection