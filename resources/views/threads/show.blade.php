@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->owner->name }}</a>
                        posted: {{ $thread->title }}
                    </div>

                    <div class="panel-body">{{ $thread->body }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @each('replies.show', $thread->replies, 'reply')

            </div>
        </div>
        <div class="row" style="padding-bottom: 100px">
            <div class="col-md-8 col-md-offset-2">
                @if(auth()->check())

                    @include('replies.form')

                @else
                    <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>
        </div>
    </div>
@endsection