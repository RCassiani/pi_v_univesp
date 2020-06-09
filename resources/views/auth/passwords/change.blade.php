@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            {{ Form::model($user, ['route' => ['password_change.update', $user->id], 'method' => 'put']) }}
            <div class="card">
                <div class="card-header">
                    <h4><b>Alterar Senha</b></h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {{ Form::label('name', 'Usuário') }} <span style="color:red">*</span>
                        {{ Form::text('name', $user->name, ['class' => ($errors->has('name')) ? 'form-control is-invalid-input' : 'form-control', 'required', 'disabled']) }}
                        @error('name')
                        <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('new_password', 'Nova Senha') }} <span style="color:red">*</span>
                        {{ Form::password('new_password', ['id' => 'new_password', 'class' => ($errors->has('new_password')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
                        @error('new_password')
                        <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        {{ Form::label('new_password_confirmation', 'Confirme a Nova Senha') }} <span style="color:red">*</span>
                        {{ Form::password('new_password_confirmation', ['id' => 'new_password_confirmation', 'class' => ($errors->has('new_password_confirmation')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
                        @error('new_password_confirmation')
                        <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <p class="text-muted"><span style="color:red">*</span> Campos obrigatórios</p>
                </div>
                <div class="card-footer">
                    <div class="p-a">
                        {!! btnSave() !!}
                    </div>
                </div>
            </div>
            {{{Form::close()}}}
        </div>
    </div>
@endsection
