@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) }}
                @include('users.form', ['page_title' => 'Usuários - '.__('label.edit')])
            {{Form::close()}}
        </div>
    </div>

@endsection
