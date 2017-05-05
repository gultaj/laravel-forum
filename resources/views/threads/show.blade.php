@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ route('users.show', $thread->owner) }}">{{ $thread->owner->name }}</a>
                            posted: {{ $thread->title }}
                        </span>
                        @can ('delete', $thread)
                            <form action="{{ route('threads.destroy', $thread) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">Delete thread</button>
                            </form>
                        @endcan
                    </div>
                    </div>

                    <div class="panel-body">{{ $thread->body }}</div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Replies</div>

                    <div class="panel-body">
                        @each('replies.show', $replies, 'reply')
                        
                        {{ $replies->links() }}
                        
                    </div>
                </div>

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