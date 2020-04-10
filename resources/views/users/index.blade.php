@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-left">
                            <h4><i class="fa fa-list"></i>&nbsp;&nbsp;<b>Usuários - {{__('label.list')}}</b></h4>
                        </div>
                        <div class="pull-right">
                            @can('user-create')
                                {!! btnNew(route('users.create')) !!}
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                               id="user-table">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th width="100px">{{__('label.form.action')}}</th>
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


    @push('js')

        <script>
            $(function () {

                var table = $('#user-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('users.index') }}",
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    language: {
                        url: "{{asset('datatable-pt-BR.json')}}"
                    }
                });

                runConfirmDelete();

            });

        </script>

    @endpush

@endsection
