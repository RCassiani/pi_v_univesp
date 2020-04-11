@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="box">
                    <div class="box-header">
                        <div class="pull-left">
                            @if($class)
                                <h4><b>Assuntos - {{$class->name}}</b></h4>
                            @else
                                <h4><b>Assuntos - {{__('label.list')}}</b></h4>
                            @endif
                        </div>
                        <div class="pull-right pb-4">
                            @can('subject-create')
                                {!! btnNew(route('subjects.create')) !!}
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                               id="subject-table">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                @if($class_id <= 0)
                                    <th>Matéria</th>
                                @endif
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
        <input type="hidden" id="class_id" name="class_id" value="{{$class_id}}">
    </div>


    @push('js')

        <script>
            $(function () {

                const class_id = $("#class_id").val();
                const url = "{{route('subjects.index', '_id_')}}".replace('_id_', class_id);

                let arrColumn = [{data: 'name', name: 'name'}];
                if (class_id <= 0) {
                    arrColumn.push({data: 'classe.name', name: 'classe.name'});
                }
                arrColumn.push({data: 'action', name: 'action', orderable: false, searchable: false});

                console.log(arrColumn);

                var table = $('#subject-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url,
                    columns: arrColumn,
                    language: {
                        url: "{{asset('datatable-pt-BR.json')}}"
                    }
                });

                runConfirmDelete();

            });

        </script>

    @endpush

@endsection
