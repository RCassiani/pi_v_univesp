@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::open(['route' => 'posts.store']) }}
            @include('posts.form', ['page_title' => 'Conteúdo - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>

@endsection
