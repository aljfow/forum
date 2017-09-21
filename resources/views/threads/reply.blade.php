<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="/profiles/{{ $reply->owner->name }}">
                    {{ $reply->owner->name }}
                </a> said ...
                {{ $reply->created_at->diffForHumans() }}
            </h5>

            <div>
                <form action="/replies/{{ $reply->id }}/favourites" method="POST">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default" {{ $reply->isFavourited() ? 'disabled' : '' }}>
                        {{ $reply->favourites_count }}
                        {{ str_plural('Favourite', $reply->favourites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="body">
                {{ $reply->body }}
            </div>
        </div>
    </div>
    @can('delete', $reply)
        <div class="panel-footer">
            <form action="/replies/{{ $reply->id }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger btn-xs"> DELETE</button>
            </form>
        </div>
    @endif
</div>
