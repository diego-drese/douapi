@extends('Admin::layouts.backend.main')
@section('title', 'Assinaturas')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center m-b-10">
                        <h4 class="card-title">&nbsp;</h4>
                        <div class="ml-auto">
                            <div class="btn-group">
                                <a href="{{route('douapi.subscription.create')}}" class="btn btn-primary">
                                    <span class="fa fa-plus"></span> <b>Nova Assinatura</b>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" role="grid" >
                            <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Status</th>
                                <th>Validate</th>
                                <th>Criado em</th>
                                <th>Atualizado em</th>
                                <th style="width: 120px">Ações</th>
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
@endsection

@section('style_head')
    <link rel="stylesheet" href="{{mix('/vendor/oka6/admin/css/datatables.css')}}">
    <link rel="stylesheet" href="{{mix('/vendor/oka6/admin/css/select2.css')}}">
    <link rel="stylesheet" href="{{mix('/vendor/oka6/admin/css/daterangepicker.css')}}">
    <style>
        .select2-selection.select2-selection--single, .select2-selection--multiple {
            height: 32px;

        }

        /*.select2-container {z-index: 100002;}*/
        /*.swal2-container.swal2-shown{z-index: 900000;}*/
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            height: auto;
            line-height: 20px;
        }

        .select2-container--default .select2-selection--multiple {
            height: auto;
            line-height: 20px;
        }

        .select2-search__field {
            width: 100% !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #fff;
            color: black;
        }

        .openModal {
            cursor: pointer;
        }

        .openModal:hover {
            text-decoration: underline;
        }

        b, strong {
            font-weight: bolder;
            padding: 0 2px;
        }
    </style>
@endsection
@section('script_footer_end')
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/datatables.js')}}></script>
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/select2.js')}}></script>
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/daterangepicker.js')}}></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table').DataTable({
                language: {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                },
                serverSide: true,
                processing: true,
                autoWidth: false,
                orderCellsTop: true,
                "order": [[ 1, "desc" ]],
                ajax: {
                    url: '{{ route('douapi.subscription.index') }}',
                    type: 'GET',
                    data: function (d) {
                        d._token = $("input[name='_token']").val();
                        return d;
                    }
                },
                columns: [
                    {data: "plan_name", 'name': 'plan_name'},
                    {data: "status", 'name': 'status', render:function(data, row){
                        if(data==1){
                            return '<span class="badge badge-success mr-1 ">Ativa</span>'
                        }
                        return '<span class="badge badge-secondary mr-1 ">Cancelada</span>';
                    }},
                    {data: "validate_at", 'name': 'validate_at'},
                    {data: "created_at", 'name': 'created_at'},
                    {data: "updated_at", 'name': 'updated_at'},
                    {
                        data: null, searchable: false, orderable: false, render: function (data, display, row) {
                            if(!data.configured){
                                var edit_button = '<a href="'+data.configure_url+'" class="btn btn-xs btn-danger"> <span class="fas fa-cog"></span> <b>Configurar</b></a>';
                            }else{
                                var edit_button = '<a href="'+data.configure_url+'" class="btn btn-xs btn-secondary"> <span class="fas fa-cog"></span> <b>Editar</b></a>';
                            }

                            return edit_button;
                        }
                    }
                ]
            });
        });

    </script>
@endsection