@component('mail::message')
# Olá {{$data['user']->name}},

Segue abaixo as notícias encontrada no Diário Oficial da União de <b>{{date('d/m/Y')}}</b> de acordo com os critérios configurados na sua assinatura.
<table id="table" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="table_info">
@foreach($data['news'] as $news)
<tr role="row" class="even">
<td class="sorting_1">
<div>
    <span class="side-stick"></span>
    <h4 class="note-title text-truncate w-75 mb-0">{{$news->organ}}</h4>
    <h5 class="note-title text-truncate w-75 mb-0">{{$news->subOrgans}}</h5>
    <h6 class="note-title text-truncate w-75 mb-0">{{$news->pub_name}} - {{$news->type_name}} | {{$news->date->formatLocalized('%d de %B de %Y')}}</h6>
    <h3 class="note-title text-truncate w-75 mb-0">{{$news->identifica ? $news->identifica : $news->name}}</h3>
    <div class="note-content">
        <p class="note-inner-content text-muted">{{$news->text_start}}</p>
        @if(!empty($news->matched_by))
            <div class="note-inner-content" style="font-style: italic; color: #666;">
                <strong>Encontrado pelos termos:</strong><br/>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($news->matched_by as $campo => $termos)
                        <li><strong>{{ $campo }}:</strong> {{ implode(', ', $termos) }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    </div>
    <div class="note-link">
        <a clicktracking=off href="{{$news->url_dou}}" target="_blank">Notícia na íntegra</a>
    </div>
</div>
<hr/>
</td>
</tr>
@endforeach
</table>
Para conferir os filtros acesse o link abaixo.
@component('mail::button', ['url' => $data['subscription']])
{{$data['plan']}}
@endcomponent
Obrigado,

{{ config('app.name') }}
@endcomponent