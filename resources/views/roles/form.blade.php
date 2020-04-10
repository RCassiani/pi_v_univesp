@push('css')

    <link rel="stylesheet" media="screen" type="text/css" href="{{ asset('assets/multi-select/multi-select.css') }}">

@endpush


<div class="box border-0">
    <div class="box-header">
        <h4><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<b>{{$page_title}}</b></h4>
    </div>
    <div class="box-body">
        <div class="row m-b">
            <div class="col-sm-8">
                {{ Form::label('name', 'Nome') }} <span style="color:red">*</span>
                {{ Form::text('name', old('name'), ['class' => ($errors->has('name')) ? 'form-control is-invalid-input' : 'form-control', 'required']) }}
                @error('name')
                <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row m-b">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    {{ Form::label('permission', 'Permissões') }} <span style="color:red">*</span>
                    <select multiple="multiple" id="mySelect" name="permission[]">
                        @foreach($permission as $value)
                            <option
                                value="{{ $value->id }}" {{ isset($rolePermissions) ? (in_array($value->id, $rolePermissions) ? 'selected' : '') : '' }}>{{ $value->display_name }}</option>
                        @endforeach
                    </select>
                    @error('permission')
                    <span class="is-invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="p-a">
        {!! btnCancel(route('roles.index')) !!}
        &nbsp&nbsp&nbsp
        @canany(['role-create', 'role-edit'])
            {!! btnSave() !!}
        @endcanany
    </div>
</div>

@push('js')
    <script src="{{ asset('assets/multi-select/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script>

        $('#mySelect').multiSelect();

        $(function () {

            runConfirmCancel();

        });
    </script>
@endpush
