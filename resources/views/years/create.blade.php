@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::open(['route' => 'years.store']) }}
                @include('years.form', ['page_title' => 'Anos - '.__('label.new')])
            {{{Form::close()}}}
        </div>
    </div>

@endsection
