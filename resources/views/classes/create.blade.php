@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::open(['route' => 'classes.store']) }}
                @include('classes.form', ['page_title' => 'Matérias - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>

@endsection
