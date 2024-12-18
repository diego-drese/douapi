@extends('Admin::layouts.backend.main')
@section('title', 'Diario oficial da união')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class=" align-items-center m-b-10">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="categories">Orgão</label>
                            <select class="form-control" id="categories" multiple>
                            </select>
                        </div>

                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="type">Tipo</label>
                            <select class="form-control" id="type" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="subject">Assunto</label>
                            <input id="subject" type="search" name="dates" class="form-control" autocomplete="off" >
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="doc">Seção</label>
                            <select class="form-control" id="pub" multiple>
                                <option value="DO1">Seção 1</option>
                                <option value="DO1E">Seção 1 Extra</option>
                                <option value="DO2">Seção 2</option>
                                <option value="DO2E">Seção 2 Extra</option>
                                <option value="DO3">Seção 3</option>
                                <option value="DO3E">Seção 3 Extra</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="period">Periodo</label>
                            <input type="text" name="period" id="period" class="form-control shawCalRanges" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="order">Ordenar</label>
                            <select class="form-control" id="order">
                                <option value="date">Data da publicação</option>
                                <option value="titulo">Orgão</option>
                                <option value="pub_name">Sessao</option>
                                <option value="type_name">Tipo</option>
                                <option value="identifica">Assunto</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="direction">Ordenação</label>
                            <select class="form-control" id="direction">
                                <option value="desc">Z-A</option>
                                <option value="asc">A-Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="doc">&nbsp;</label><br/>
                            <button style=""  class="btn btn-success" id="searsh">Buscar</button>
                            <button style=""  class="btn btn-info" id="clear">Limpar</button>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="doc">Último processamento:</label><br/>
                            <p class="note-date font-12 text-muted p-t-5">{{$lastProcessed}}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="note-full-container" class="note-has-grid row">
        <div class="col-md-12">
            <div class="card card-body">
            <table id="table" class="table table-striped table-bordered" role="grid">
                <thead style="display:none">
                <tr>
                    <td>
                        Noticia
                    </td>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h5 id="modal-organ">Orgão</h5>
                        <h5 id="modal-sub-organ">Sub orgão</h5>
                        <p id="info">Sessão - Tipo - data</p>
                        <p id="link">---</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div id="text">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
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
        .openModal{
            cursor:pointer;
        }
        .openModal:hover{
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
            var emptyStorageFilter = function (){
                $('#categories').val('').trigger('change')
                $('#type').val('').trigger('change');
                $('#subject').val('').trigger('change');
                $('#pub').val('').trigger('change');
                $('#period').val('').trigger('change');
                $('#order').val('date').trigger('change');
                $('#direction').val('desc').trigger('change');
                saveStorageFilter();
            }
            var saveStorageFilter =  function(){
                var categoriesStorage = [];
                var typeStorage = [];
                var pubStorage = [];

                if($('#categories').val()!=""){
                    $('#categories option').each(function (){
                        categoriesStorage.push({'text':this.text,'value':this.value})
                    });
                }

                if($('#type').val()!="") {
                    $('#type option').each(function () {
                        typeStorage.push({'text': this.text, 'value': this.value})
                    });
                }

                if($('#pub').val()!="") {
                    $('#pub option:selected').each(function () {
                        pubStorage.push({'text': this.text, 'value': this.value})
                    });
                }

                localStorage.setItem('categories', JSON.stringify(categoriesStorage));
                localStorage.setItem('type', JSON.stringify(typeStorage));
                localStorage.setItem('subject', $("#subject").val());
                localStorage.setItem('pub', JSON.stringify(pubStorage));
                localStorage.setItem('period', $("#period").val());
                localStorage.setItem('order', $("#order").val());
                localStorage.setItem('direction', $("#direction").val());
            }
            var setStorageFilter =  function(){
                var categoriesStorage   = localStorage.getItem('categories');
                var typeStorage         = localStorage.getItem('type');
                var subjectStorage      = localStorage.getItem('subject');
                var pubStorage          = localStorage.getItem('pub');
                var periodStorage       = localStorage.getItem('period');
                var orderStorage        = localStorage.getItem('order');
                var directionStorage    = localStorage.getItem('direction');
                var option              = null;
                if(categoriesStorage){
                    categoriesStorage = JSON.parse(categoriesStorage);
                    for (var i=0; i<categoriesStorage.length;i++){
                        option = categoriesStorage[i];
                        $('#categories').append('<option value="'+option.value+'" selected>'+option.text+'</option>')
                    }
                }
                if(typeStorage){
                    typeStorage = JSON.parse(typeStorage);
                    for (var i=0; i<typeStorage.length;i++){
                        option = typeStorage[i];
                        $('#type').append('<option value="'+option.value+'" selected>'+option.text+'</option>')
                    }
                }
                if(subjectStorage){
                    $('#subject').val(subjectStorage)
                }

                if(pubStorage){
                    pubStorage = JSON.parse(pubStorage);
                    for (var i=0; i<pubStorage.length;i++){
                        option = pubStorage[i];
                        $('#pub option[value='+option.value+']').attr('selected','selected');
                    }
                }

                if(periodStorage){
                    $('#period').val(periodStorage)
                }
                if(orderStorage){
                    $('#order option[value='+orderStorage+']').attr('selected','selected');
                }
                if(directionStorage){
                    $('#direction option[value='+directionStorage+']').attr('selected','selected');
                }

            };
            setStorageFilter();
            $('#categories').select2({
                width:'100%',
                placeholder: 'Buscar por orgão',
                tag:true,
                minimumInputLength: 3,
                ajax: {
                    url: '{{route('douapi.index')}}',
                    data: function (params) {
                        var query = {
                            search_category: params.term
                        }
                        return query;
                    },
                    processResults: function (data) {
                        var myData = $.map(data, function (obj) {
                                  obj.text = obj.text || obj.name;
                                  return obj;
                                });
                        return {
                          results: myData
                        }
                    }
                },
            });

            $('#type').select2({
                width:'100%',
                placeholder: 'Buscar por tipos',
                tag:true,
                minimumInputLength: 3,
                ajax: {
                    url: '{{route('douapi.index')}}',
                    data: function (params) {
                        var query = {
                            search_type: params.term
                        }
                        return query;
                    },
                    processResults: function (data) {
                        console.log(data);
                        var myData = $.map(data, function (obj) {
                                  obj.text = obj.text || obj.name;
                                  return obj;
                                });
                        return {
                          results: myData
                        }
                    }
                },
            });
            $('#pub').select2({
                width:'100%',
                tag:true,
            });


            var daterangepicker = $('#period').daterangepicker({
                startDate: moment().subtract(30, 'days'),
                autoUpdateInput:false,
                endDate:  moment(),
                valueDefault: null,
                locale: {
                    "format": "dd/mm/yy"
                },
                alwaysShowCalendars: true,
                ranges: {
                    'Últimos 03 Dias': [moment().subtract(3, 'days'), moment()],
                    'Últimos 05 Dias': [moment().subtract(5, 'days'), moment()],
                    'Últimos 07 Dias': [moment().subtract(7, 'days'), moment()],
                    'Últimos 15 Dias': [moment().subtract(15, 'days'), moment()],
                    'Últimos 30 Dias': [moment().subtract(30, 'days'), moment()],
                    'Últimos 60 Dias': [moment().subtract(60, 'days'), moment()],
                    'Últimos 90 Dias': [moment().subtract(90, 'days'), moment()],
                    'Últimos 180 Dias': [moment().subtract(90, 'days'), moment()],
                },
                locale:{
                    dateFormat: 'dd/mm/yy',
                    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    nextText: 'Proximo',
                    prevText: 'Anterior',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    weekLabel: 'Sem',
                    customRangeLabel: 'Período de',
                }
                }, function(start, end) {
                    $('#period').val(start.format('L')+' - '+ end.format('L'))

            });



            $('#date').change(function () {
                var dateFilter = this.value;
                ajaxData(urlDocumentNew, {date:dateFilter}, buildPieChart, 'document_new');
                ajaxData(urlDocumentAction, {date:dateFilter}, buildPieChart, 'document_action');
            });
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

                searching: false,
                lengthChange: false,
                ajax: {
                    url: '{{ route('douapi.index') }}',
                    type: 'GET',
                    data: function (d) {
                        saveStorageFilter();
                        d._token = $("input[name='_token']").val();
                        d.length = 10;
                        d.categories = $("#categories").val();
                        d.types = $("#type").val();
                        d.subject = $("#subject").val();
                        d.pub = $("#pub").val();
                        d.period = $("#period").val();
                        d.my_order = $("#order").val();
                        d.direction = $("#direction").val();
                        return d;
                    }
                },
                columns: [
                    { data: null, searchable: false, orderable: false, render: function (data) {
                            var categories  = data.categories;
                            var organ       = categories[0];
                            var subOrgans   = '';
                            for(var i=1; i<categories.length;i++ ){
                                subOrgans+=(i>1? ' / ': '')+categories[i]['name'];
                            }

                            return '<div >'+
                                        '<span class="side-stick"></span>'+
                                        '<h4 class="note-title text-truncate w-75 mb-0">'+organ.name+'</h4>'+
                                        '<h5 class="note-title text-truncate w-75 mb-0">'+subOrgans+'</h5>'+
                                        '<h6 class="note-title text-truncate w-75 mb-0">'+data.pub_name+' - '+data.type_name+'</h6>'+
                                        '<p class="note-date font-12 text-muted">'+moment(data.date).format('ll')+'</p>'+
                                        '<h3 class="note-title text-truncate w-75 mb-0 openModal " id="dou-'+data.id+'">'+(data.identifica ? data.identifica : data.name)+'</h3>'+
                                        '<div class="note-content">'+
                                             '<p class="note-inner-content text-muted">'+
                                            (data.ementa ? data.ementa : '')+
                                            '</p>'+
                                            '<p class="note-inner-content text-muted">'+
                                            (data.text_start)+
                                            '</p>'+
                                        '</div>'+
                                        '<div class="note-link">'+
                                           '<a href="'+data.url_dou+'" target="_blank">Página PDF do DOU</a>'+
                                        '</div>'+
                                    '</div>';
                            }
                    }
                ],

            });
            $('#searsh').click(function(){
                table.draw();
            });

            $('#clear').click(function(){
               emptyStorageFilter();
               table.draw();
            });

            $(document).on("click", ".openModal" , function() {
                var id = this.id.split('-')[1];
                $.ajax({
                    url: '{{ route('douapi.index') }}',
                    type: "get",
                    dataType: 'json',
                    data: {id:id},
                    beforeSend: function () {

                    },
                    success: function (data) {
                        console.log(data);
                        var categories  = data.categories;
                        var organ       = categories[0];
                        var subOrgans   = '';
                        for(var i=1; i<categories.length;i++ ){
                            subOrgans+=(i>1? ' / ': '')+categories[i]['name'];
                        }
                        $('#modal #attoEmissora').attr('data-dou-id', data.id);
                        $('#modal #attoEmissora').attr('data-emissora-ato', (data.ato_id ? data.ato_id : ''));
                        $('#modal #modal-organ').html(organ.name);
                        $('#modal #modal-sub-organ').html(subOrgans);

                        var info = data.pub_name+" - "+data.type_name+' - '+moment(data.date).format('ll');
                        $('#modal #info').html(info);
                        $('#modal #title').html((data.identifica ? data.identifica : data.name));
                        $('#modal #text').html(data.text);
                        $('#modal #link').html('<a href="'+data.url_dou+'" target="_blank">Página PDF do DOU</a>');

                    },
                    error: function (erro) {
                        toastr.error(erro.responseJSON.message, 'Erro');
                    }
                });
                $('#modal').modal('show')
            });
});



</script>

@endsection