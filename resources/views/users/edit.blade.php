@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) }}
                @include('users.form', ['page_title' => 'Usuários - '.__('label.edit')])
            {{Form::close()}}
        </div>
    </div>
</div>

@endsection
