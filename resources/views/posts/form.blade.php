<div class="card">
    <div class="card-header">
        <h4><b>{{ $page_title }}</b></h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('title', 'Título') }} <span style="color:red">*</span>
            {{ Form::text('title', old('title'), ['class' => $errors->has('title') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('title')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('year_id', 'Ano') }} <span style="color:red">*</span>
            {{ Form::select('year_id', $years, null, ['id' => 'year_id', 'placeholder' => 'Selecione...', 'class' => $errors->has('year_id') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('year_id')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('class_id', 'Matéria') }} <span style="color:red">*</span>
            {{ Form::select('class_id', [], null, ['id' => 'class_id', 'placeholder' => 'Selecione...', 'class' => $errors->has('class_id') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('class_id')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('subject_id', 'Assunto') }} <span style="color:red">*</span>
            {{ Form::select('subject_id', [], null, ['id' => 'subject_id', 'placeholder' => 'Selecione...', 'class' => $errors->has('subject_id') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('subject_id')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('body', 'Texto') }} <span style="color:red">*</span>
            {{ Form::textarea('body', old('body'), ['class' => $errors->has('body') ? 'form-control is-invalid-input ckeditor' : 'form-control ckeditor']) }}
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
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/translations/pt-br.js"></script>
    <script src="{!! asset('js/ckeditor-img.js') !!}"></script>
    <script>
        $(function() {
            $("#year_id").change(function() {
                const year_id = $(this).val();
                const url = "{{ route('years.classes', '_id_') }}".replace('_id_', year_id);

                $.get(url)
                    .done(function(data) {
                        $('#class_id').empty().append('<option></option>');
                        data.map(d => {
                            $('#class_id').append(new Option(d.name, d.id))
                        });
                    });
            });


            $("#class_id").change(function() {
                const class_id = $(this).val();
                const url = "{{ route('classes.subjects', '_id_') }}".replace('_id_', class_id);

                $.get(url)
                    .done(function(data) {
                        $('#subject_id').empty().append('<option></option>');
                        data.map(d => {
                            $('#subject_id').append(new Option(d.name, d.id))
                        });
                    });
            });

            $('.ckeditor').each(function() {
                ClassicEditor
                    .create($(this).get(0), {
                        extraPlugins: [MyCustomUploadAdapterPlugin],
                        toolbar: [
                            'bold',
                            'italic',
                            'numberedList',
                            'bulletedList',
                            'uploadImage',
                            'mediaEmbed'
                        ],
                        language: 'pt-br',
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        });

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                const fileDest = "{{ route('posts.uploadImage', ['_token' => csrf_token()]) }}";
                return new MyUploadAdapter(loader, fileDest);
            };
        }
    </script>
@endpush
