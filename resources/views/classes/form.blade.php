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
            {{ Form::label('image', 'Imagem') }} <span style="color:red">*</span>
            {!! Form::textarea('image', old('image'), ['class' => $errors->has('image') ? 'ckeditor is-invalid-input' : 'ckeditor']) !!}
            @error('image')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::label('year_id', 'Ano') }} <span style="color:red">*</span>
            {{ Form::select('year_id', $years, $year ?? null, ['id' => 'year_id', 'placeholder' => 'Selecione...', 'class' => $errors->has('year_id') ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
            @error('year_id')
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
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/translations/pt-br.js"></script>
    <script src="{!! asset('js/ckeditor-img.js') !!}"></script>
    <script>
        $(function() {

            runConfirmCancel();

            $('.ckeditor').each(function() {
                ClassicEditor
                    .create($(this).get(0), {
                        extraPlugins: [MyCustomUploadAdapterPlugin],
                        toolbar: [
                            'uploadImage'
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
                const fileDest = "{{ route('classes.uploadImage', ['_token' => csrf_token()]) }}";
                return new MyUploadAdapter(loader, fileDest);
            };
        }
    </script>
@endpush
