@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{ Form::open(['route' => 'users.store']) }}
                @include('users.form', ['page_title' => 'Usuários - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>
</div>

@endsection
