<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Direct Checkout - Payment Intent') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('direct.paymentIntent.post') }}" method="POST" id="form">
                        @csrf

                        <input type="hidden" name="payment_method" id="payment_method">
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div>

                        <button type="button" id="card-button" class="btn btn-sm btn-primary mt-3"
                            data-secret="{{ $payment->client_secret }}">
                            Process Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Stripe
        const stripe = Stripe(@json(env('STRIPE_KEY')));
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');


        // Handle Payment Process
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
        const { paymentIntent, error } = await stripe.confirmCardPayment(
            clientSecret, {
                payment_method: {
                    card: cardElement
                }
            }
            );
        
            if (error) {
                alert('error');
                console.error(error);
            } else {
                alert('success');
                console.error(paymentIntent);
                // document.getElementById('payment_method').value = paymentMethod.id;
                // document.getElementById('form').submit();
            }
        });

    </script>
</x-app-layout>