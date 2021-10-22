@foreach ($comments as $comment)
    <div class="display-comment mt-3 mb-3 @if (!empty($comment->parent_id)) child-comment @endif" id="comment-{{ $comment->id }}">
        <strong>{{ $comment->user->name }}</strong> - {{ $comment->created_at }}
        @if (auth()->user()->isSuperAdmin() || $comment->user_id === auth()->user()->id)
            <div class="action-btn">
                <a href="javascript:void(0)" class="btn btn-edit p-1" data-comment-id="{{ $comment->id }}">
                    <i class="material-icons md-24" id="grid-edit">edit</i> Editar
                </a>
                <span href="{{ route('comments.destroy', $comment->id) }}"
                    data-sa-title="{{ trans('sys.alert.delete.sa_title') }}" 
                    data-sa-type="warning"
                    data-sa-message="{{ trans('sys.alert.delete.sa_message') }}"
                    data-sa-confirmbuttontext="{{ trans('sys.alert.delete.sa_confirmButtonText') }}"
                    data-sa-cancelbuttontext="{{ trans('sys.alert.delete.sa_cancelButtonText') }}"
                    data-sa-popuptitlecancel="{{ trans('sys.alert.delete.sa_popupTitleCancel') }}"
                    data-original-title="{{ trans('sys.btn.delete') }}" 
                    data-placement="top" 
                    class="btn btn-delete p-1">
                    <i class="material-icons md-24" id="grid-delete">delete</i> Excluir
                </span>
            </div>
        @endif
        <form method="post" action="{{ route('comments.update', $comment->id) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
                <textarea class="ckeditor-custom-comments" id="ckeditor-custom-{{ $comment->id }}"
                    name="body">{!! $comment->body !!}</textarea>
                <input type="hidden" name="post_id" value="{{ $post_id }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary d-none" id="submit-comment-update-{{ $comment->id }}" value="Salvar" />
            </div>
        </form>
        <div id="accordion">
            <div class="card">
                <div class="card-header p-1" id="heading{{ $comment->id }}">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse"
                            data-target="#collapse{{ $comment->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $comment->id }}">
                            <i class="material-icons md-24">reply</i>
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
                                <input type="submit" class="btn btn-primary" value="Enviar" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('posts.comments', ['comments' => $comment->replies])
    </div>
    @if (empty($comment->parent_id))
        <hr class="mt-3 mb-3">
    @endif
@endforeach
