@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <h1><b>Matérias - {{ __('label.list') }}</b></h1>
                        </div>
                        <div class="pull-right">
                            @can('class-create')
                                {!! btnNew(route('classes.create')) !!}
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                                id="class-table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        @if ($year_id <= 0)
                                            <th>Ano</th>
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
        <input type="hidden" id="year_id" name="year_id" value="{{ $year_id }}">
    </div>


    @push('js')

        <script>
            $(function() {

                const year_id = $("#year_id").val();
                const url = "{{ route('classes.index', '_id_') }}".replace('_id_', year_id);

                let arrColumn = [{
                    data: 'name',
                    name: 'name'
                }];
                if (year_id <= 0) {
                    arrColumn.push({
                        data: 'year.name',
                        name: 'year.name'
                    });
                }
                arrColumn.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });

                var table = $('#class-table').DataTable({
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
