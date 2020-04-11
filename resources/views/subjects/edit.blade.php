@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($subject, ['route' => ['subjects.update', $subject->id], 'method' => 'put']) }}
                @include('subjects.form', ['page_title' => 'Assuntos - '.__('label.edit')])
            {{Form::close()}}
        </div>
    </div>

@endsection
