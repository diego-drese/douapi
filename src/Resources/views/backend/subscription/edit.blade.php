@extends('Admin::layouts.backend.main')
@section('title', 'Editar assinatura')
@section('content')
    <form method="post" action="{{route('douapi.subscription.update',$data->_id)}}" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{$data->plan_name}}</h4>
                    </div>
                    <div class="col-md-12">
                        @if($data->email)
                            <label for="email_notify">Email</label>
                            <input type="text" class="form-control"
                                   value="{{old('email_notify',$data->exists() && !empty($data->email_notify) ? $data->email_notify : $user->email)}}"
                                   name="email_notify"
                                   id="email_notify" placeholder="Email para notificação">
                            @if($errors->has('email_notify'))
                                <span class="help-block">{{$errors->first('email_notify')}}</span>
                            @endif
                        @else
                            <label for="api_notify">Api</label>
                            <input type="text" class="form-control"
                                   value="{{old('api_notify',$data->exists() ? $data->api_notify : '')}}"
                                   name="api_notify"
                                   id="api_notify" placeholder="API para notificação">
                            @if($errors->has('api_notify'))
                                <span class="help-block">{{$errors->first('api_notify')}}</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($data->notify_email_50_news || $data->notify_api_50_news)
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4>Filtro</h4>
                            <div class="form-group">
                                <label for="categories">Orgão</label>
                                <select class="form-control" id="categories" name="categories[]" multiple>
                                    @if($data->filter && is_array($data->filter) && isset($data->filter['categories']))
                                        @foreach($data->filter['categories'] as $key=>$value)
                                            <option value="{{$value['id']}}" selected>{{$value['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="type">Tipo</label>
                                <select class="form-control" id="type" name="type[]" multiple>
                                    @if($data->filter && is_array($data->filter) && isset($data->filter['type']))
                                        @foreach($data->filter['type'] as $key=>$value)
                                            <option value="{{$value['id']}}" selected>{{$value['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="subject">Assunto</label>
                                <select class="form-control" id="subject" name="subject[]" multiple="multiple">
                                    @if($data->filter && is_array($data->filter) && isset($data->filter['subject']))
                                        @foreach($data->filter['subject'] as $key=>$value)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="content">Conteudo</label>
                                <select class="form-control" id="content" name="content[]" multiple="multiple">
                                    @if($data->filter && is_array($data->filter) && isset($data->filter['content']))
                                        @foreach($data->filter['content'] as $key=>$value)
                                            <option value="{{$value}}" selected>{{$value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="doc">Seção</label>
                                <select class="form-control" id="pub" name="pub[]" multiple>
                                    <option value="DO1" {{$data->filter && in_array('DO1',$data->filter['pub']) ? 'selected' : ''}}>Seção 1</option>
                                    <option value="DO1E" {{$data->filter && in_array('DO1E',$data->filter['pub']) ? 'selected' : ''}}>Seção 1 Extra</option>
                                    <option value="DO2" {{$data->filter && in_array('DO2',$data->filter['pub']) ? 'selected' : ''}}>Seção 2</option>
                                    <option value="DO2E" {{$data->filter && in_array('DO2E',$data->filter['pub']) ? 'selected' : ''}}>Seção 2 Extra</option>
                                    <option value="DO3" {{$data->filter && in_array('DO3',$data->filter['pub']) ? 'selected' : ''}}>Seção 3</option>
                                    <option value="DO3E" {{$data->filter && in_array('DO3E',$data->filter['pub']) ? 'selected' : ''}}>Seção 3 Extra</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <button style="float: right;" type="submit" class="btn btn-success">Salvar</button>
                <a style="float: right;" href="{{route('douapi.subscription.index')}}"
                   class="btn btn-primary m-r-5">
                    <span class=" fas fa-arrow-left"></span> <b>Voltar</b>
                </a>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-body">
            Assinatura válida até <b>{{$data->validate_at->format('d/m/Y H:i')}}</b>
        </div>
        @if($data->status)
            <div class="card-body">
                <button id="{{$data->subscription_id}}" class="btn btn-xs btn-danger cancelSubscription"> <span class="fas fa-ban"></span> <b>Cancelar
                        assinatura</b></button>
            </div>
        @endif
    </div>

@endsection
@section('style_head')
    <link rel="stylesheet" href="{{mix('/vendor/oka6/admin/css/select2.css')}}">
    <link rel="stylesheet" href="{{mix('/vendor/oka6/admin/css/sweetalert2.css')}}">
    <style>
        .card-body {
            padding: 1.25rem !important;
        }

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
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/select2.js')}}></script>
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/sweetalert2.js')}}></script>

    <script type="text/javascript">

        $(document).ready(function () {
            var cancelSubscripton = function (url, text) {
                swal({
                    title: "Você têm certeza?",
                    text: text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim!",
                    cancelButtonText: "Cancelar!",
                }).then((isConfirm) => {
                    console.log(isConfirm);
                    if (isConfirm.dismiss=='cancel') return;
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {},
                        dataType: "json",
                        success: function (data) {
                            swal("Sucesso!", "Assinatura cancelada com sucesso", "success").then(() => {
                                window.location= '{{route('douapi.subscription.index')}}';
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Erro!", xhr.responseJSON.message, "error");
                        }
                    });
                });
            }

            $('.cancelSubscription').click(function (){
                var url = '{{route('douapi.subscription.cancel')}}'+'?subscription_id='+this.id;
                cancelSubscripton(url, 'Você está prestes a cancelar sua assinatura.')
            })
            $('#categories').select2({
                width: '100%',
                placeholder: 'Buscar por orgão',
                tag: true,
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
                width: '100%',
                placeholder: 'Buscar por tipos',
                tag: true,
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
                width: '100%',
            });

            $('#subject, #content').select2({
                width: '100%',
                tags: true,
                maximumSelectionLength: 10,
                tokenSeparators: [','],
                createTag: function (params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                }
            });


        });


    </script>

@endsection


