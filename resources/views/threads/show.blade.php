@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
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
                        @can ('change', $thread)
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
                        <replies :data="{{ $replies }}" 
                            :thread-id="{{ $thread->id }}"
                            @removed="repliesCount--" 
                            @added="repliesCount++">
                        </replies>              
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }}
                        by <a href="#">{{ $thread->owner->name }}</a>,
                        and currently has <span v-text="pluralCount"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection