<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row dark:text-white">
                <div class="card" style="width: 60rem;">
                    @session('success')
                        <div class="alert alert-success">{{ $value }}</div>
                    @endsession
                    <div class="card-header"><h4 class="text-center">Payment</h4></div>
                    <div class="card-body">
                        <h5 class="card-title">Order summary</h5>
                        <form action="{{ route('stripe-pay') }}" method="post" id="stripe-form">
                            @csrf
                            <div class="flex justify-between">
                                <label for="">Order Name</label>
                                <input name="name" value="{{ $name }}" readonly>
                            </div>
                            <br>
                            <div class="flex justify-between">
                                <label for="">Price</label>
                                <input name="price" value="{{ $price }}" readonly>
                            </div>
                            <br>

                            <div id="payment-element" class="form-control"></div>
                            <br>
                            <input type="hidden" id="stripeToken" name="stripeToken">
                            
                            <button class="cursor-pointer text-lg px-5 bg-slate-500 text-white" type="button" onclick="createToken()">Confirm</button>
                            <br>
                        </form>
                    </div>
                </div>
                {{-- <div class="text-[13px] leading-5 flex-1 p-6 pb-12 lg:p-20 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
                    <form action="{{ route('stripe-pay') }}" method="post">
                        @csrf
                        <div class="flex justify-between">
                            <label for="">Order Name</label>
                            <input name="name" value="{{ $name }}" readonly>
                        </div>
                        <div class="flex justify-between">
                            <label for="">Price</label>
                            <input name="price" value="{{ $price }}" readonly>
                        </div>
                        
                        <button class="cursor-pointer text-lg px-5 bg-slate-500" type="submit">Confirm</button>
                        <br>
                    </form>
                </div> --}}
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>

    {{-- <script src="https://js.stripe.com/clover/stripe.js"></script> --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');

        var elements = stripe.elements();

        var cardElement = elements.create('card');
        cardElement.mount('#payment-element');

        function createToken()
        {
            stripe.createToken(cardElement).then(function(result) {
                // Handle result.error or result.token
                console.log(result);
                if(result.token) {
                    document.getElementById("stripeToken").value = result.token.id;
                    document.getElementById("stripe-form").submit();
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>
