@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <h4><b>Notificações - {{ __('label.list') }}</b></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                                id="notification-table">
                                <thead>
                                    <tr>
                                        <th>Notificação</th>
                                        <th>Data</th>
                                        <th></th>
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

                var table = $('#notification-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('users.indexNotifications') }}",
                    columns: [{
                            data: 'data',
                            name: 'data'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
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
                    dom: '<"top"f>rt<"bottom"p><"clear">'
                });

                runConfirmDelete();

            });
        </script>

    @endpush

@endsection
