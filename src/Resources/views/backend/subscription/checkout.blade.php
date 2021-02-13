@extends('Admin::layouts.backend.main')
@section('title', 'Assinatura')
@section('content')
@endsection

@section('style_head')
    <button id="checkout">Subscribe</button>
@endsection
@section('script_footer_end')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/datatables.js')}}></script>
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/select2.js')}}></script>
    <script type="text/javascript" src={{mix('/vendor/oka6/admin/js/daterangepicker.js')}}></script>
    <script type="text/javascript">


    </script>

@endsection