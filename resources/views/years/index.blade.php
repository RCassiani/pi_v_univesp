@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <h1><b>Anos - {{ __('label.list') }}</b></h1>
                        </div>
                        <div class="pull-right">
                            @can('class-create')
                                {!! btnNew(route('years.create')) !!}
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
    </div>


    @push('js')

        <script>
            $(function() {

                var table = $('#class-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('years.index') }}",
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    language: {
                        url: "{{ asset('datatable-pt-BR.json') }}"
                    },
                    lengthChange: false,
                    info: false,
                    dom: '<"top"f>rt<"bottom"p><"clear">',
                    order: [[0]],
                });

                runConfirmDelete();

            });
        </script>

    @endpush

@endsection
