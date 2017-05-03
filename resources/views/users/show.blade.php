@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>{{ $user->name }}</h1>
            <small>Since {{ $user->created_at->diffForHumans() }}</small>
        </div>

        @forelse ($activities as $date => $activity)
            <h3 class="page-header">{{ $date }}</h3>
            @foreach ($activity as $record)
                
                @include ("activities.{$record->type}_{$record->subject_type}", ['activity' => $record])

            @endforeach
        @empty

        @endforelse

    </div>
@endsection