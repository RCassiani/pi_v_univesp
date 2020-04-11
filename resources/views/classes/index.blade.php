@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-left">
                            <h4><b>Matérias - {{__('label.list')}}</b></h4>
                        </div>
                        <div class="pull-right pb-4">
                            @can('class-create')
                                {!! btnNew(route('classes.create')) !!}
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                               id="class-table">
                            <thead>
                            <tr>
                                <th>Nome</th>
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

                var table = $('#class-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('classes.index') }}",
                    columns: [
                        {data: 'name', name: 'name'},
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
