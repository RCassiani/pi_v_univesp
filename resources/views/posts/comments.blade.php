@foreach ($comments as $comment)
    <div class="display-comment" id="comment-{{ $comment->id }}" @if ($comment->parent_id != null) style="margin-left:40px;" @endif>
        <strong>{{ $comment->user->name }}</strong>
        <div class="ckeditor-custom-comments" id="ckeditor-custom-{{ $comment->id }}">
            {!! $comment->body !!}
        </div>
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="heading{{ $comment->id }}">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse"
                            data-target="#collapse{{ $comment->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $comment->id }}">
                            Responder
                        </button>
                    </h5>
                </div>
                <div id="collapse{{ $comment->id }}" class="collapse"
                    aria-labelledby="heading{{ $comment->id }}" data-parent="#accordion">
                    <div class="card-body">
                        <form method="post" action="{{ route('comments.store') }}">
                            @csrf
                            <div class="form-group">
                                <textarea class="ckeditor-new-comment" id="ckeditor-new-{{ $comment->id }}"
                                    name="body"></textarea>
                                <input type="hidden" name="post_id" value="{{ $post_id }}" />
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info" value="Enviar" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('posts.comments', ['comments' => $comment->replies])
    </div>
@endforeach
