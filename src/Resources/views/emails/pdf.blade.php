@component('mail::message')
# Olá {{$data['user']->name}},

Segue abaixo o Diário Oficial da União (Seção 1, 2 e 3) de hoje <b>{{date('d/m/Y')}}</b> para que você tenha acesso aos atos oficiais publicados pelo Governo.

Lembrando que:

Na <b>Seção 1</b> são publicados (leis, decretos, resoluções, instruções normativas, portarias e outros atos normativos de interesse geral).

Na <b>Seção 2</b> (Atos de interesse dos servidores da Administração Pública Federal).

E na <b>Seção 3</b> (Contratos, editais, avisos ineditoriais).

Fonte: Imprensa Nacional
@foreach($data['files'] as $file)
@component('mail::button', ['url' => $file['link']])
{{$file['name']}}
@endcomponent
@endforeach
Obrigado,

{{ config('app.name') }}
@endcomponent