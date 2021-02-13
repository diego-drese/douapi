@extends('Admin::layouts.backend.main')
@section('title', 'Erro de assinatura')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 my-5 text-center">
                    <div class="text-danger">
                        <i class="batch-icon batch-icon-link-alt batch-icon-xxl"></i>
                        <i class="batch-icon batch-icon-search batch-icon-xxl"></i>
                        <i class="batch-icon batch-icon-link-alt batch-icon-xxl"></i>
                    </div>
                    <h1 class="display-1">500</h1>
                    <div class="display-4 mb-3">{{$title}}</div>
                    <div class="lead">
                        {!! $message !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
