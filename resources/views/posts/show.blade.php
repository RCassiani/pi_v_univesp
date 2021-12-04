@extends('layouts.app')

@push('css')
    <style>
        div[id*="comment-"] {
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

    </style>
@endpush

@section('content')
    <div class="container">
        <div class="pull-left">
            <a href="{{ route('posts.indexList', $post->subject->id) }}">
                <span class="btn btn-primary py-1 px-2">
                    <i class="fa fa-arrow-circle-left fa-2x"></i>
                </span>
            </a>
        </div>
        <div class="row justify-content-center mb-4">
            <h1><b>{{ $post->subject->year_class }}</b></h1>
        </div>
        <div class="row justify-content-center row-form">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h2><b>{{ $post->subject->name }}</b></h2>
                    </div>
                    <div class="card-body">
                        <h3><b>{{ $post->title }}</b></h3>
                        <div class="ckeditor-custom-comments" id="post-body-editor">{!! $post->body !!}</div>
                        <hr />
                        <h4 class="text-center"><i class="material-icons md-24">forum</i> Comentários</h4>

                        @include('posts.comments', ['comments' => $post->comments, 'post_id' => $post->id])

                        <h4 class="mt-5">Novo Comentário</h4>
                        <form method="post" action="{{ route('comments.store') }}">
                            @csrf
                            <div class="form-group">
                                <textarea class="ckeditor-new-comment" id="post-comment-editor" name="body"></textarea>
                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Adicionar Comentário" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/translations/pt-br.js"></script>
    <script src="{!! asset('js/ckeditor-img.js') !!}"></script>
    <script>
        $(function() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const comment_id = urlParams.get('cmd');

            if (comment_id) {
                $('html, body').animate({
                    scrollTop: $("#comment-" + comment_id).offset().top - $(window).height() / 2
                }, 2000);

                var $el = $("#comment-" + comment_id).addClass("comment-active");

                setTimeout(function() {
                    $el.removeClass("comment-active");
                }, 5000);
            }

            // Accordion.
            $('.collapse').collapse('hide');

            runConfirmDelete();
        });

        function editComment(e) {
            let element = e.currentTarget;

            let commentId = $(element).data('comment-id');
            const customComment = $('#ckeditor-custom-' + commentId);
            const domEditableElement = customComment.siblings('.ck-editor').find('.ck-editor__editable');
            // Get the editor instance from the editable element.
            const editorInstance = domEditableElement.get(0).ckeditorInstance;
            // Destroy current.
            editorInstance.destroy();
            // Create new.
            ClassicEditor
                .create(customComment.get(0), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: [
                        'bold',
                        'italic',
                        'numberedList',
                        'bulletedList',
                        'uploadImage',
                        'mediaEmbed'
                    ],
                    language: 'pt-br',
                })
                .catch(error => {
                    console.error(error);
                });
            // Show Save button.
            $('#submit-comment-update-' + commentId).removeClass('d-none');
        }

        $('.btn-edit').on('click', editComment);

        $('.ckeditor-custom-comments').each(function() {
            ClassicEditor
                .create($(this).get(0), {
                    toolbar: [],
                    language: 'pt-br',
                })
                .then(editor => {
                    editor.isReadOnly = true;
                }).catch(error => {
                    console.error(error);
                });
        });

        $('.ckeditor-new-comment').each(function() {
            ClassicEditor
                .create($(this).get(0), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: [
                        'bold',
                        'italic',
                        'numberedList',
                        'bulletedList',
                        'uploadImage',
                        'mediaEmbed'
                    ],
                    language: 'pt-br',
                })
                .catch(error => {
                    console.error(error);
                });
        });

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                const fileDest = "{{ route('comments.uploadImage', ['_token' => csrf_token()]) }}";
                return new MyUploadAdapter(loader, fileDest);
            };
        }
    </script>
@endpush
