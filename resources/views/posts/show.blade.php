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
        <div class="col-md-6 offset-md-3">
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
                    <h4>Comentar</h4>
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
    <script>
        $(function () {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const comment_id = urlParams.get('cmd');

            if (comment_id) {
                $('html, body').animate({
                    scrollTop: $("#comment-" + comment_id).offset().top - $(window).height() / 2
                }, 2000);

                // $("#comment-" + comment_id).addClass('comment-active', 5000, function () {
                //     console.log(this);
                // });

                var $el = $("#comment-" + comment_id).addClass("comment-active");

                setTimeout(function () {
                    $el.removeClass("comment-active");
                }, 5000);
            }
        })

        $('.ckeditor-custom-comments').each(function () {
            ClassicEditor
            .create( $(this).get(0), {
                toolbar: [],
            })
            .then(editor => {
                editor.isReadOnly = true;
            }).catch( error => { 
                console.error( error ); 
            });
        });

        class MyUploadAdapter {
            constructor( loader ) {
                // The file loader instance to use during the upload.
                this.loader = loader;
            }

            // Starts the upload process.
            upload() {
                return this.loader.file
                    .then( file => new Promise( ( resolve, reject ) => {
                        this._initRequest();
                        this._initListeners( resolve, reject, file );
                        this._sendRequest( file );
                    } ) );
            }

            // Aborts the upload process.
            abort() {
                if ( this.xhr ) {
                    this.xhr.abort();
                }
            }

            // Initializes the XMLHttpRequest object using the URL passed to the constructor.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();

                // Note that your request may look different. It is up to you and your editor
                // integration to choose the right communication channel. This example uses
                // a POST request with JSON as a data structure but your configuration
                // could be different.
                xhr.open( 'POST', "{{route('upload', ['_token' => csrf_token() ])}}", true );
                xhr.responseType = 'json';
            }

            // Initializes XMLHttpRequest listeners.
            _initListeners( resolve, reject, file ) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                xhr.addEventListener( 'abort', () => reject() );
                xhr.addEventListener( 'load', () => {
                    const response = xhr.response;

                    // This example assumes the XHR server's "response" object will come with
                    // an "error" which has its own "message" that can be passed to reject()
                    // in the upload promise.
                    //
                    // Your integration may handle upload errors in a different way so make sure
                    // it is done properly. The reject() function must be called when the upload fails.
                    if ( !response || response.error ) {
                        return reject( response && response.error ? response.error.message : genericErrorText );
                    }

                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    // This URL will be used to display the image in the content. Learn more in the
                    // UploadAdapter#upload documentation.
                    resolve( {
                        default: response.url
                    } );
                } );

                // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                // properties which are used e.g. to display the upload progress bar in the editor
                // user interface.
                if ( xhr.upload ) {
                    xhr.upload.addEventListener( 'progress', evt => {
                        if ( evt.lengthComputable ) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    } );
                }
            }

            // Prepares the data and sends the request.
            _sendRequest( file ) {
                // Prepare the form data.
                const data = new FormData();

                data.append( 'upload', file );

                // Important note: This is the right place to implement security mechanisms
                // like authentication and CSRF protection. For instance, you can use
                // XMLHttpRequest.setRequestHeader() to set the request headers containing
                // the CSRF token generated earlier by your application.

                // Send the request.
                this.xhr.send( data );
            }
        }
        // ...

        function MyCustomUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter( loader );
            };
        }

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
            })
            .catch( error => {
                console.error( error );
            } );
        });
        
    </script>
@endpush
