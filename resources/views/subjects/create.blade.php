@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::open(['route' => 'subjects.store']) }}
                @include('subjects.form', ['page_title' => 'Assuntos - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>

@endsection
