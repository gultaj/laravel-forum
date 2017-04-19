@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Forum Threads @if($channel->exists) for: {{ $channel->name }} @endif
                    </div>

                    <div class="panel-body">
                        @foreach($threads as $thread)
                            <article>
                                <section class="article-header clearfix">
                                    <h4 class="pull-left"><a href="{{ route('threads.show', [$thread->channel, $thread]) }}">{{ $thread->title }}</a></h4>
                                    <p class="pull-right">{{ $thread->owner->name }}</p>
                                </section>


                                <div class="body">{{ $thread->body }}</div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection