@extends('layouts.app')

@section('title', 'Mariages.net - Services')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/4 h-48 md:h-auto relative">
                    <img
                        src="{{ $service->image ? asset('images/services/' . $service->image) : 'https://placehold.co/600x400/e9ecef/495057?text=Service+Image' }}"
                        alt="{{ $service->title }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="p-6 md:w-3/4 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold mb-1">{{ $service->title }}</h2>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 mr-1">
                                        <i class="fas fa-star text-sm"></i> <i class="fas fa-star text-sm"></i> <i class="fas fa-star text-sm"></i>
{{--                                        @php--}}
{{--                                            $rating = round($service->rating ?? 0);--}}
{{--                                        @endphp--}}
{{--                                        @for ($i = 1; $i <= 5; $i++)--}}
{{--                                            @if($i <= $rating)--}}
{{--                                                <i class="fas fa-star text-sm"></i>--}}
{{--                                            @else--}}
{{--                                                <i class="far fa-star text-sm"></i>--}}
{{--                                            @endif--}}
{{--                                        @endfor--}}
                                    </div>
                                    <span class="text-sm font-medium">{{ number_format($service->rating, 1) }}</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-sm text-gray-500">{{ $service->location ?? 'Non précisé' }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ Str::limit($service->description, 300, '...') }}
                        </p>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium">À partir de {{ number_format($service->price, 0, ',', ' ') }}€</div>
                        <a href="{{ route('contact.provider', $service->id) }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-md text-sm">
                            Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            {{ $services->links() }}
        </div>
    </div>

@endsection
