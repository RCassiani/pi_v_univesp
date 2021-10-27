@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'put']) }}
            @include('posts.form', ['page_title' => 'Publicações - '.__('label.edit')])
            {{ Form::close() }}
        </div>
    </div>

@endsection
