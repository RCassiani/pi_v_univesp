<div class="card">
    <div class="card-header">
        <h4><b>{{$page_title}}</b></h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('name', 'Nome') }} <span style="color:red">*</span>
            {{ Form::text('name', old('name'), ['class' => ($errors->has('name')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('name')
            <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('image', 'Imagem') }} <span style="color:red">*</span>
            {{ Form::text('image', old('image'), ['class' => ($errors->has('image')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('image')
            <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <p class="text-muted"><span style="color:red">*</span> Campos obrigatórios</p>
    </div>
    <div class="card-footer">
        <div class="p-a">
            {!! btnForm(route('classes.index')) !!}
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function () {

            runConfirmCancel();

        });
    </script>
@endpush
