<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($cart && count($cart->courses) > 0)
                    @foreach ($cart->courses as $course)
                    <div class="bg-light p-2 mb-3 d-flex justify-content-between align-items-center">
                        <h6>{{ $course->name }}
                            <small class="text-primary">({{ $course->price }})</small>
                        </h6>
                        <a href="{{ route('removeFromCart', $course) }}" class="btn btn-sm btn-danger">Remove</a>
                    </div>

                    @endforeach
                    @else
                    <div class="alert alert-info">Cart is empty</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>