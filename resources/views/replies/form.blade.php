<form action="{{ route('replies.store', $thread) }}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?..."></textarea>
    </div>
    <button type="submit" class="btn btn-default">Post</button>
</form>