@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($class, ['route' => ['classes.update', $class->id], 'method' => 'put']) }}
                @include('classes.form', ['page_title' => 'Matérias - '.__('label.edit')])
            {{Form::close()}}
        </div>
    </div>

@endsection
