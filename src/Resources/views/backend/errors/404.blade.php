@if(Auth::check())
    @extends('Admin::layouts.backend.main')
    @section('title', 'Page not Found')
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
                    <h1 class="display-1">404</h1>
                    <div class="display-4 mb-3">Page Not Found</div>
                    <div class="lead">We can't find the page you are looking for.</div>
                    <div class="lead">Try searching for it using the search field below or you can go <a href="/">back
                            to our homepage</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@else
    <h1>{{$exception->getMessage()}}</h1>
@endif