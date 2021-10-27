<div class="card">
    <div class="card-header">
        <h4><b>{{ $page_title }}</b></h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('name', 'Nome') }} <span style="color:red">*</span>
            {{ Form::text('name', old('name'), ['class' => $errors->has('name') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('name')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('email', 'E-mail') }} <span style="color:red">*</span>
            {{ Form::email('email', old('email'), ['class' => $errors->has('email') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('email')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('roles', 'Grupo de Acesso') }} <span style="color:red">*</span>
            {{ Form::select('roles', $roles, isset($userRole) ? $userRole : null, ['id' => 'roles', 'placeholder' => 'Selecione...', 'class' => $errors->has('roles') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('roles')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Senha') }} <span style="color:red">*</span>
            {{ Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('password')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <p class="text-muted"><span style="color:red">*</span> Campos obrigatórios</p>
    </div>
    <div class="card-footer">
        <div class="p-a">
            {!! btnForm(route('users.index')) !!}
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {

            runConfirmCancel();

        });
    </script>
@endpush
