<div class="card">
    <div class="card-header">
        <h4><b>{{$page_title}}</b></h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('title', 'Título') }} <span style="color:red">*</span>
            {{ Form::text('title', old('title'), ['class' => ($errors->has('title')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('title')
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
        <div class="form-group">
            {{ Form::label('subject_id', 'Assunto') }} <span style="color:red">*</span>
            {{ Form::select('subject_id', [], null, ['id' => 'subject_id', 'placeholder' => 'Selecione...','class' => ($errors->has('subject_id')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('subject_id')
            <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Tipo') }} <span style="color:red">*</span>
            {{ Form::select('type', $types, null, ['id' => 'type', 'placeholder' => 'Selecione...','class' => ($errors->has('type')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('type')
            <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('body', 'Texto') }} <span style="color:red">*</span>
            {{ Form::textarea('body', old('body'), ['rows' => 10, 'class' => ($errors->has('body')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('body')
            <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <p class="text-muted"><span style="color:red">*</span> Campos obrigatórios</p>
    </div>
    <div class="card-footer">
        <div class="p-a">
            {!! btnForm(route('posts.index')) !!}
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function () {
            $("#class_id").change(function () {
                const class_id = $(this).val();
                const url = "{{route('classes.subjects', '_id_')}}".replace('_id_', class_id);

                $.get(url)
                    .done(function (data) {
                        $('#subject_id').empty().append('<option></option>');
                        data.map(d => {
                            $('#subject_id').append(new Option(d.name, d.id))
                        });
                    });
            });
        });
    </script>
@endpush
