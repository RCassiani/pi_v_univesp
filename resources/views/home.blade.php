@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-deck">
                    @foreach($classes as $class)
                        <div class="card">
                            <a href="{{route('subjects.index', $class->id)}}">
                                <img class="card-img-top center"
                                     src="{{$class->image}}"
                                     alt="Card image cap"
                                     style="max-width: 150px"
                                >
                                <div class="card-footer">
                                    <h5 class="card-title">{{$class->name}}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
