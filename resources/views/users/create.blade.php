@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::open(['route' => 'users.store']) }}
                @include('users.form', ['page_title' => 'Usuários - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>

@endsection
