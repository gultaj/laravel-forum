@component ('activities.activity')
    @slot ('header')
        @php $thread = $activity->subject->thread @endphp
        {{ $user->name }} replied to 
        <a href="{{ route('threads.show', [$thread->channel, $thread]) }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent