@extends('Admin::layouts.backend.main')
@section('title', 'Plans')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center m-b-10">
                        <h4 class="card-title">&nbsp;</h4>
                        <div class="ml-auto">
                            <div class="btn-group">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" role="grid" >
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>Api</th>
                                <th>Email PDF</th>
                                <th>Api XML</th>
                                <th>50 NEWS email</th>
                                <th>50 NEWS Api</th>
                                <th>All NEWS Api</th>
                                <th>Stripe ID</th>
                                <th>Stripe environment</th>
                                <th style="width: 120px">Ações</th>
                            </tr>
                            <tr>
                                <th role="row">
                                    <input type="text" autocomplete="off" class="fieldSearch form-control text-primary" placeholder="Name">
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th>
                                    ---
                                </th>
                                <th style="width: 60px">
                                    <spa class="btn btn-primary btn-xs m-r-5" id="clearFilter">
                                        <span class="fas fa-sync-alt"></span> <b>Clear</b>
                                    </spa>
                                </th>
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
        var hasEdit = '{{$hasEditPlan}}';
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
                stateSave: true,
                stateLoaded: function (settings, data) {
                    setTimeout(function () {
                        var dataExtra = settings.ajax.data({});
                        var searchCols = settings.aoPreSearchCols;
                        if (searchCols && searchCols.length) {
                            for (var i = 0; i < searchCols.length; i++) {
                                $('#table thead tr:eq(1) th:eq(' + i + ') .fieldSearch').val(searchCols[i]['sSearch']);
                            }
                        }
                        console.log(settings.aoPreSearchCols, data);
                    }, 50);
                },
                ajax: {
                    url: '{{ route('douapi.plan.index') }}',
                    type: 'GET',
                    data: function (d) {
                        d._token = $("input[name='_token']").val();
                        return d;
                    }
                },
                columns: [
                    {data: "name", 'name': 'name'},
                    {data: "status", 'name': 'status',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    }, {data: "email_notify", 'name': 'email_notify',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },{data: "api_notify", 'name': 'api_notify',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },{data: "notify_email_pdf", 'name': 'notify_email_pdf',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },{data: "notify_api_xml", 'name': 'notify_api_xml',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },{data: "notify_email_50_news", 'name': 'notify_email_50_news',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },{data: "notify_api_50_news", 'name': 'notify_api_50_news',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },{data: "notify_api_all_news", 'name': 'notify_api_all_news',
                        render: function (data, display, row) {
                            if (data == "1") {
                                return '<span class="badge badge-success mr-1 ">Enable</span>';
                            } else if (data == '0') {
                                return '<span class="badge badge-danger mr-1 ">Disable</span>';
                            }
                            return '---';
                        }
                    },
                    {data: "stripe_id", 'name': 'stripe_id'},
                    {data: "stripe_environment", 'name': 'stripe_environment'},
                   {
                        data: null, searchable: false, orderable: false, render: function (data) {
                            var edit_button = "";
                            @if($hasEditPlan)
                                edit_button += '<a href="' + data.edit_url + '" class="badge badge-secondary mr-1 " role="button" aria-pressed="true"><b>Editar</b></a>';
                            @endif

                                return edit_button
                        }
                    }
                ]
            });

            $('#table thead tr:eq(1) th').each(function (i) {
                $('.fieldSearch', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value, true).draw();
                    }
                });
            });

            $('#clearFilter').click(function () {
                table.state.clear();
                window.location.reload();
            })
        });

    </script>
@endsection