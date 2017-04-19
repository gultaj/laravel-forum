@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New Thread</div>

                    <div class="panel-body">
                        <form action="{{ route('threads.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('channel_id') ? ' has-error' : '' }}">
                                <label for="channel_id" class="control-label">Channel</label>
                                <select id="channel_id" class="form-control" name="channel_id" required>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected': '' }}>{{ $channel->name }}</option>
                                    @endforeach
                                    <option value="666">Test</option>
                                </select>
                                @if ($errors->has('channel_id'))
                                    <span class="help-block"><strong>{{ $errors->first('channel_id') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="help-block"><strong>{{ $errors->first('title') }}</strong></span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body">Body:</label>
                                <textarea name="body" id="body" class="form-control" rows="8">{{ old('body') }}</textarea>
                                @if ($errors->has('body'))
                                    <span class="help-block"><strong>{{ $errors->first('body') }}</strong></span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection