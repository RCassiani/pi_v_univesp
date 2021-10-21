@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($year, ['route' => ['years.update', $year->id], 'method' => 'put']) }}
                @include('years.form', ['page_title' => 'Anos - '.__('label.edit')])
            {{Form::close()}}
        </div>
    </div>

@endsection
