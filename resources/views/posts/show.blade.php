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
    <div class="row row-form">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4><b>Publicação - {{$post->subject_id}}</b></h4>
                </div>
                <div class="card-body">
                    <h2>{{ $post->title }}</h2>
                    <div class="ckeditor-custom-comments" id="post-body-editor">{!! $post->body !!}</div>
                    <hr/>
                    <h4 class="text-center">Comentários</h4>

                    @include('posts.comments', ['comments' => $post->comments, 'post_id' => $post->id])

                    <hr/>
                    <h4>Novo Comentário</h4>
                    <form method="post" action="{{ route('comments.store') }}">
                        @csrf
                        <div class="form-group">
                            <textarea class="ckeditor-new-comment" id="post-comment-editor" name="body"></textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Adicionar Comentário"/>
                        </div>
                    </form>
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
        $(function () {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const comment_id = urlParams.get('cmd');

            if (comment_id) {
                $('html, body').animate({
                    scrollTop: $("#comment-" + comment_id).offset().top - $(window).height() / 2
                }, 2000);

                var $el = $("#comment-" + comment_id).addClass("comment-active");

                setTimeout(function () {
                    $el.removeClass("comment-active");
                }, 5000);
            }

            // Accordion.
            $('.collapse').collapse('hide');
        });

        $('.ckeditor-custom-comments').each(function () {
            ClassicEditor
            .create( $(this).get(0), {
                toolbar: [],
                language: 'pt-br',
            })
            .then(editor => {
                editor.isReadOnly = true;
            }).catch( error => { 
                console.error( error ); 
            });
        });

        $('.ckeditor-new-comment').each(function () {
            ClassicEditor
            .create( $(this).get(0), {
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
            .catch( error => {
                console.error( error );
            } );
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
