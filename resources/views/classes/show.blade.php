@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pull-left">
            <a href="{{ route('landing') }}">
                <span value="Voltar" class="btn btn-primary py-1 px-2">
                    <i class="fa fa-arrow-circle-left fa-2x"></i>
                </span>
            </a>
        </div>
        <div class="row justify-content-center">
            <div class="page-title mb-5">
                <h1><b>{{ $year->name }} - Matérias</b></h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-deck">
                    @foreach ($classes as $class)
                        <div class="col-md-6">
                            <div class="card mb-5">
                                <a href="{{ route('subjects.index', $class->id) }}">
                                    <div class="card-img-top center">
                                        {!! $class->image !!}
                                    </div>
                                    <div class="card-footer">
                                        <h5 class="card-title">{{ $class->name }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
