<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Direct Checkout - Payment Method') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="#" method="POST">
                        @csrf

                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div>

                        <button id="card-button" class="btn btn-sm btn-primary mt-3">
                            Process Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const stripe = Stripe('pk_test_51QwRjF2KxKhpsanMk3hRPVLC373m6wMoh1l7y0K8OwBstnD3ypbti77ZmIMsLVSzn1no6Ot9QLzRH1kPWz5Nxow500TAM4tbtL');
     
        const elements = stripe.elements();
        const cardElement = elements.create('card');
     
        cardElement.mount('#card-element');
    </script>
</x-app-layout>