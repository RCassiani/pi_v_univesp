@foreach($comments as $comment)
    <div class="display-comment" id="comment-{{$comment->id}}" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <strong>{{ $comment->user->name }}</strong>
        <div class="ckeditor-custom-comments" id="ckeditor-custom-{{$comment->id}}">{!! $comment->body !!}</div>
        <form method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <textarea class="ckeditor-new-comment" id="ckeditor-new-{{$comment->id}}" name="body"></textarea>
                <input type="hidden" name="post_id" value="{{ $post_id }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info" value="Responder" />
            </div>
        </form>
        @include('posts.comments', ['comments' => $comment->replies])
    </div>
@endforeach
