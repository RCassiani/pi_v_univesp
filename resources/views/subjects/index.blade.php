@extends('layouts.app')

@section('content')

    <div class="container">
        @if (!empty($class))
            <div class="pull-left">
                <a href="{{ route('classes.show', $class->year_id) }}">
                    <span class="btn btn-primary py-1 px-2">
                        <i class="fa fa-arrow-circle-left fa-2x"></i>
                    </span>
                </a>
            </div>
            <div class="row justify-content-center mb-4">
                <h1><b>{{ $class->year->name }} - Assuntos</b></h1>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">                        
                        <div class="pull-left">
                            @if ($class)
                                <h2><b>{{ $class->name }}</b></h2>
                            @else
                                <h1><b>Assuntos - {{ __('label.list') }}</b></h1>
                            @endif
                        </div>
                        <div class="pull-right pb-1">
                            @can('subject-create')
                                {!! btnNew(route('subjects.create')) !!}
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered"
                                id="subject-table">
                                <thead>
                                    <tr>
                                        <th>Assunto</th>
                                        @if ($class_id <= 0)
                                            <th>Matéria</th>
                                        @endif
                                        <th width="100px">{{ __('label.form.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="class_id" name="class_id" value="{{ $class_id }}">
    </div>

    @push('js')
        <script>
            $(function() {

                const class_id = $("#class_id").val();
                const url = "{{ route('subjects.index', '_id_') }}".replace('_id_', class_id);

                let arrColumn = [{
                    data: 'name',
                    name: 'name'
                }];
                if (class_id <= 0) {
                    arrColumn.push({
                        data: 'year_class',
                        name: 'year_class'
                    });
                }
                arrColumn.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });

                var table = $('#subject-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url,
                    columns: arrColumn,
                    language: {
                        url: "{{ asset('datatable-pt-BR.json') }}"
                    },
                    lengthChange: false,
                    info: false,
                    dom: '<"top"f>rt<"bottom"p><"clear">'
                });

                runConfirmDelete();

            });
        </script>
    @endpush
@endsection
