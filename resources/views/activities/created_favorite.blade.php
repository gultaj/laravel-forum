@component ('activities.activity')
    @slot ('header')
        @php $thread = $activity->subject->favoritable->thread @endphp
        {{ $user->name }} favorite reply to 
        <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">{{ $thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->favoritable->body }}
    @endslot
@endcomponent