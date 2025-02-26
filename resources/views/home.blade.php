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
                    <h4>{{ $course->name }}</h4>
                    <p>{{ $course->description }}</p>
                    <p>Price: {{ $course->price }}</p>
                    <a href="#">Add To Cart</a>
                    {{-- <a href="" class="block text-sm font-medium text-blue-500 hover:text-blue-600">
                        {{ __('View Course') }}
                        <svg class="ml-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4
                            a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                        </svg>
                    </a> --}}
                </div>
            </div>

            @endforeach
            @endif

        </div>
    </div>
</x-app-layout>