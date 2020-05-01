@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4><b>Posts - {{$post->subject_id}}</b></h4>
                </div>
                <div class="card-body">
                    <h2>{{ $post->title }}</h2>
                    <p class="post-body">
                        {{ $post->body }}
                    </p>
                    <hr/>
                    <h4 class="text-center">Comentários</h4>

                    @include('posts.comments', ['comments' => $post->comments, 'post_id' => $post->id])

                    <hr/>
                    <h4>Comentar</h4>
                    <form method="post" action="{{ route('comments.store') }}">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="body" required></textarea>
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
    <script>

        function urlify(text) {
            var urlRegex = /(((https?:\/\/)|(www\.))[^\s]+)/g;
            //var urlRegex = /(https?:\/\/[^\s]+)/g;
            return text.replace(urlRegex, function (url, b, c) {
                var url2 = (c == 'www.') ? 'http://' + url : url;
                return '<a href="' + url2 + '" target="_blank">' + url + '</a>';
            })
        }

        $(function () {
            let body = $(".post-body").text();
            $(".post-body").html(urlify(body));
        })
    </script>
@endpush
