<reply message="{{ $reply->body }}" id="{{ $reply->id }}" inline-template v-cloak>
    <article v-show="show">
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
                @can('change', $reply)
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-warning" type="button" @click="editing = true">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-danger" @click="destroy">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                @endcan
            @endif
        </section>
        <div v-if="editing">
            <div class="form-group">
                <textarea class="form-control" v-model="body"></textarea>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-xs btn-success" @click="update">Update</button>
                <button type="button" class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
        </div>
        <div v-else>
            <div class="body" v-text="body"></div>
        </div>
        <hr>
    </article>
</reply>
