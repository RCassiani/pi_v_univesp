<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{!! asset('theme/font-awesome/css/font-awesome.min.css') !!}" type="text/css"/>
    <link rel="stylesheet" href="{!! asset('theme/material-design-icons/material-design-icons.css') !!}"
          type="text/css"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sys.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
@include('sweetalert::alert')
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @guest
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    </ul>
                @else
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @can(['year-list', 'year-create'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('years.index')}}">Anos</a>
                            </li>
                        @endcan
                        @can(['class-list', 'class-create'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('classes.index')}}">Matérias</a>
                            </li>
                        @endcan
                        @can(['subject-list', 'subject-create'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('subjects.index')}}">Assuntos</a>
                            </li>
                        @endcan
                        @can(['post-list', 'post-create'])
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('posts.index')}}">Publicações</a>
                            </li>
                        @endcan
                        @canany(['role-list', 'user-list'])
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Segurança
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @can('user-list')
                                        <a class="dropdown-item" href="{{route('users.index')}}">Usuários</a>
                                    @endcan
                                    @can('role-list')
                                        <a class="dropdown-item" href="{{route('roles.index')}}">Permissões</a>
                                    @endcan
                                </div>
                            </li>
                        @endcanany
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- // add this dropdown // -->
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle notification" data-toggle="dropdown"
                               role="button"
                               aria-expanded="false">
                                <span style="font-size: x-large">
                                    <i class="fa fa-bell"></i>
                                </span>
                                @if(count(Auth::user()->unreadNotifications))
                                    <span class="badge">{{count(Auth::user()->unreadNotifications)}}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li class="nav-item new-notification">
                                    @foreach (Auth::user()->unreadNotifications as $notification)
                                        <a href="{{ route('posts.show', $notification->data['post']['id']) }}?cmd={{$notification->data["comment"]["id"]}}"
                                           data-notif-id="{{$notification->id}}"
                                           class="dropdown-item break"
                                        >
                                            <i>{{ $notification->data["user"]["name"] }}</i>
                                            @isset($notification->data["comment"]["parent_id"])
                                                respondeu seu comentário
                                            @else
                                                comentou
                                            @endisset
                                            na publicação
                                            <b>{{ $notification->data["post"]["title"] }}</b>
                                        </a>
                                    @endforeach
                                </li>
                            </ul>
                        </li>
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle user-card" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item"  href="{{route('password_change.edit', auth()->user()->id)}}">
                                    {{__('Change Password')}}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                @endguest
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{!! asset('js/sys.js') !!}"></script>
<script>
    $(function () {
        $('a[data-notif-id]').click(function () {

            var notif_id = $(this).data('notifId');
            var targetHref = $(this).attr('href');

            $.post('/comments/markNotifAsRead',
                {
                    '_token': "{{ csrf_token() }}",
                    'notif_id': notif_id
                }, function (data) {
                    data.success ? (window.location.href = targetHref) : false;
                }, 'json');

            return false;
        });
    });
</script>
@stack('js')

</body>
</html>
