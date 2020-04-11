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
            {{ Form::label('class_id', 'Matéria') }} <span style="color:red">*</span>
            {{ Form::select('class_id', $classes, null, ['id' => 'class_id', 'placeholder' => 'Selecione...','class' => ($errors->has('class_id')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('class_id')
            <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <p class="text-muted"><span style="color:red">*</span> Campos obrigatórios</p>
    </div>
    <div class="card-footer">
        <div class="p-a">
            {!! btnForm(route('subjects.index')) !!}
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
