@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card-title mb-3 p-3">
                    <h1><strong>{{ env('APP_NAME') }}</strong></h1>
                    <h5 class="my-3">Seja bem-vindo ao portal mais completo de ensino e aprendizagem, onde você
                        é
                        responsável pelo seu
                        aprendizado.
                        Aqui você pesquisa, aprende, reproduz, ensina, compartilha ideias e muito mais.</h5>
                </div>
                <div class="card login-card-body">
                    <div class="card-header">
                        <h3><strong>Login</strong></h3>
                    </div>
                    <div class="card-body">
                        <div class="avatar">
                            <i class="fa fa-user fa-3x"></i>
                        </div>
                        <p class="text-center">Entre com seu e-mail e senha para realizar o login</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="{{ __('E-Mail Address') }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="{{ __('Password') }}">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row"> --}}
                            {{-- <div class="col-md-6 offset-md-4"> --}}
                            {{-- <div class="form-check"> --}}
                            {{-- <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> --}}

                            {{-- <label class="form-check-label" for="remember"> --}}
                            {{-- {{ __('Remember Me') }} --}}
                            {{-- </label> --}}
                            {{-- </div> --}}
                            {{-- </div> --}}
                            {{-- </div> --}}

                            <div class="form-group row mb-0 justify-content-center">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary" style="width: 100%">
                                        {{ __('Login') }}
                                    </button>

                                    {{-- @if (Route::has('password.request')) --}}
                                    {{-- <a class="btn btn-link" href="{{ route('password.request') }}"> --}}
                                    {{-- {{ __('Forgot Your Password?') }} --}}
                                    {{-- </a> --}}
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
