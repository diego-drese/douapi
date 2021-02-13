@extends('Admin::layouts.backend.main')
@section('title', 'Selecione o plano')
@section('content')
    <div class="card p-4">
        {{ csrf_field() }}
            @foreach($data as $key=>$plan)
                    @if($key%3==0)
                        </div>
                    @endif
                    @if($key==0 || $key%3==0)
                        <div class="card-deck mb-3 text-center">
                    @endif

                    <div class="card mb-4 border">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">{{$plan->name}}</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">R${{number_format($plan->value,2, ',', '.')}} <small class="text-muted">/ mês</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                {!! $plan->description !!}

                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-primary plan" id="{{$plan->stripe_id}}">Assinar</button>
                        </div>

                    </div>
            @endforeach
            @if($key%3!=0)
                </div>
            @endif
        </div>
    </div>
@endsection

@section('style_head')

@endsection
@section('script_footer_end')
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        // If a fetch error occurs, log it to the console and show it in the UI.
        var handleFetchResult = function(result) {
            if (!result.ok) {
                return result.json().then(function(json) {
                    if (json.error && json.error.message) {
                        throw new Error(result.url + ' ' + result.status + ' ' + json.error.message);
                    }
                }).catch(function(err) {
                    showErrorMessage(err);
                    throw err;
                });
            }
            return result.json();
        };

        // Create a Checkout Session with the selected plan ID
        var createCheckoutSession = function(priceId) {
            return fetch('{{route('douapi.subscription.create.checkout.session')}}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    priceId: priceId,
                    _token: $('input[name="_token"]').val(),
                })
            }).then(handleFetchResult);
        };

        // Handle any errors returned from Checkout
        var handleResult = function(result) {
            if (result.error) {
                showErrorMessage(result.error.message);
            }
        };

        var showErrorMessage = function(message) {
            var errorEl = document.getElementById("error-message")
            errorEl.textContent = message;
            errorEl.style.display = "block";
        };

        $('.plan').click(function (){
            var basicPriceId = this.id;
            createCheckoutSession(basicPriceId).then(function(data) {
                // Call Stripe.js method to redirect to the new Checkout page
                var stripe = Stripe(data.publicKey);
                stripe
                    .redirectToCheckout({
                        sessionId: data.sessionId
                    })
                    .then(handleResult);
            });
        })



    </script>

@endsection