@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'put']) }}
            @include('roles.form', ['page_title' => 'Permissões - '.__('label.edit')])
            {{Form::close()}}
        </div>
    </div>

@endsection
