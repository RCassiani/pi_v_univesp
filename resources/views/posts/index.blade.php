@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4><b>Publicações</b></h4>
                    @if ($subject)
                        {{ $subject->classe->name }} - {{ $subject->name }}
                    @endif
                    @can('post-create')
                        <a href="{{ route('posts.create') }}" class="btn btn-success" style="float: right">
                            Nova Publicação
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($posts as $post)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    @if(empty($subject)) <i>({{$post->subject->classe->name}} - {{$post->subject->name}}) - </i> @endif
                                    <b>{{ $post->title }}</b>
                                </span>
                                <span class="badge badge-primary badge-pill">
                                    <a href="{{ route('posts.show', $post->id) }}" class="btn text-white">Visualizar</a>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
