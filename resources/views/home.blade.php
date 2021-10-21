@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-deck">
                    @foreach ($years as $year)
                    <div class="col-md-6">
                        <div class="card mb-5">
                            <a href="{{ route('classes.show', $year->id) }}">
                                <div class="card-img-top center" id="post-body-editor">
                                    {!! $year->image !!}
                                </div>
                                <div class="card-footer">
                                    <h5 class="card-title">{{ $year->name }}</h5>
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
