@component ('activities.activity')
    @slot ('header')
        {{ $user->name }} published 
        <a href="{{ route('threads.show', [$activity->subject->channel, $activity->subject]) }}">
            {{ $activity->subject->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent