@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::open(['route' => 'roles.store']) }}
            @include('roles.form', ['page_title' => 'Permissões - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>

@endsection
