<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 row">

            {{-- {{ __("Home page here") }} --}}
            @if (count($courses) > 0)
            @foreach ($courses as $course)

            <div class="card col-4">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('courses.show', $course) }}">
                        <h5>{{ $course->name }}</h5>
                    </a>
                    <p>{{ $course->description }}</p>
                    <p>Price: {{ $course->price }}</p>
                    @if ($cart && $cart->courses->contains($course))

                    <a href="{{ route('removeFromCart', $course) }}" class="btn btn-sm btn-danger">Remove From Cart</a>
                    @else
                    <a href="{{ route('addToCart', $course) }}" class="btn btn-sm btn-primary">Add To Cart</a>
                    @endif
                </div>
            </div>

            @endforeach
            @endif

        </div>
    </div>
</x-app-layout>