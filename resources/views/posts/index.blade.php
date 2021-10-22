@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($subject)
            <div class="pull-left">
                <a href="{{ route('subjects.index', $subject->class_id) }}">
                    <span class="btn btn-primary py-1 px-2">
                        <i class="fa fa-arrow-circle-left fa-2x"></i>
                    </span>
                </a>
            </div>
            <div class="row justify-content-center mb-4">
                <h1><b>{{ $subject->classe->year->name }} - Publicações</b></h1>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <h2><b>{{ $subject->classe->name }} - {{ $subject->name }}</b></h2>
                        </div>
                        @can('post-create')
                            <div class="pull-right">
                                <a href="{{ route('posts.create') }}" class="btn btn-success" style="float: right">
                                    Nova Publicação
                                </a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered"
                                id="posts-table">
                                <thead>
                                    <tr>
                                        <th>Publicação</th>
                                        <th>Criada em</th>
                                        @if (empty($subject_id))
                                            <th>Ano - Matéria - Assunto</th>
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
            <input type="hidden" id="subject_id" name="subject_id" value="{{ $subject_id }}">
        </div>
    </div>

    @push('js')
        <script>
            $(function() {

                const subject_id = $("#subject_id").val();
                const url = "{{ route('posts.indexList', '_id_') }}".replace('_id_', subject_id);

                let arrColumn = [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ];
                if (!subject_id) {
                    arrColumn.push({
                        data: 'year_class_subject',
                        name: 'year_class_subject'
                    });
                }
                arrColumn.push({
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                });

                var table = $('#posts-table').DataTable({
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
            });
        </script>
    @endpush
@endsection
