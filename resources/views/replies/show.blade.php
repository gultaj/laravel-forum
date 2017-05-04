<article>
    <section class="level">
        <h5 class="flex">
            <a href="{{ route('users.show', $reply->owner) }}">{{ $reply->owner->name }}</a> 
            said {{ $reply->created_at->diffForHumans() }}
        </h5>
        @if (auth()->check())
            <form action="{{ route('replies.favorites', $reply) }}" method="post">
                {{ csrf_field() }}
                {{ $reply->favorites_count }}
                <button type="submit" class="btn btn-link btn-lg btn-favorite" {{ $reply->isFavorited ? 'disabled' : '' }}>
                     <span class="glyphicon glyphicon-heart{{ $reply->isFavorited ? '' : '-empty' }}"></span>
                </button>
            </form>
            @can('delete', $reply)
                <form action="{{ route('replies.destroy', $reply) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete reply</button>
                </form>
            @endcan
        @endif
    </section>
    <div class="body">{{ $reply->body }}</div>
</article>
<hr>
