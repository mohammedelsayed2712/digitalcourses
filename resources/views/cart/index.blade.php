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

                    {{-- <div class="card">
                        <div class="p-6 text-gray-900">
                            <a href="{{ route('courses.show', $course) }}">
                                <h5>{{ $course->name }}</h5>
                            </a>
                            <p>{{ $course->description }}</p>
                            <p>Price: {{ $course->price }}</p>
                            <a href="{{ route('addToCart', $course) }}" class="btn btn-sm btn-primary">Add To Cart</a>
                        </div>
                    </div> --}}
                    <div class="bg-light p-2 mb-3 d-flex justify-content-between align-items-center">
                        <h6>{{ $course->name }}
                            <small class="text-primary">({{ $course->price }})</small>
                        </h6>
                        <a href="#" class="btn btn-sm btn-danger">Remove</a>
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