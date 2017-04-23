@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->owner->name }}</a>
                        posted: {{ $thread->title }}
                    </div>

                    <div class="panel-body">{{ $thread->body }}</div>
                </div>

                @each('replies.show', $replies, 'reply')

                {{ $replies->links() }}

                @if(auth()->check())

                    @include('replies.form')

                @else
                    <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }}
                        by <a href="#">{{ $thread->owner->name }}</a>,
                        and currently has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection