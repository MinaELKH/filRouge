@extends('layouts.app')

@section('title', 'Mariages.net - Services')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="flex flex-col md:flex-row gap-8">

            <!-- Sidebar des filtres -->
            <div class="md:w-1/4 space-y-6">
                <!-- Promotions -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-tag text-gray-500"></i>
                        <span class="font-medium">Promotions</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gray-400 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>

                <!-- Awards -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-trophy text-gray-500"></i>
                        <span class="font-medium">Gagnants Wedding Awards</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-gray-400 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>

                <hr class="my-4">

                <!-- Prix -->
                <div>
                    <div class="flex items-center justify-between cursor-pointer">
                        <h3 class="font-medium text-lg">Prix</h3>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach ([
                            'Moins de 500DH',
                            '500DH - 1.000DH',
                            '1.000DH - 1.500DH',
                            'Plus de 1.500DH'
                        ] as $i => $prix)
                            <div class="flex items-center">
                                <input id="price-{{ $i }}" type="checkbox" class="h-4 w-4 text-coral-500 rounded border-gray-300 focus:ring-coral-500">
                                <label for="price-{{ $i }}" class="ml-2 text-sm text-gray-700">{{ $prix }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="my-4">

                <!-- Services -->
                <div>
                    <div class="flex items-center justify-between cursor-pointer">
                        <h3 class="font-medium text-lg">Services</h3>
                        <i class="fas fa-chevron-down text-gray-500"></i>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach (['Séance d\'engagement', 'Après le mariage', 'Album', 'Album digital'] as $i => $serviceName)
                            <div class="flex items-center">
                                <input id="service-{{ $i }}" type="checkbox" class="h-4 w-4 text-coral-500 rounded border-gray-300 focus:ring-coral-500">
                                <label for="service-{{ $i }}" class="ml-2 text-sm text-gray-700">{{ $serviceName }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Liste des services -->
            <div class="md:w-3/4">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service->id) }}" class="block bg-white rounded-lg shadow-sm mb-6 overflow-hidden flex flex-col md:flex-row hover:shadow-md transition-shadow duration-300">
                        <div class="md:w-1/3 relative">
                            <img
                                src="{{ $service->cover_image ? asset('images/services/' . $service->cover_image) : 'https://placehold.co/600x400/e9ecef/495057?text=Service+Image' }}"
                                alt="{{ $service->title }}"
                                class="object-cover rounded-t-md md:rounded-l-md w-[340px] h-[240px] mx-auto"
                            >
                        </div>

                        <div class="p-6 md:w-2/3 flex flex-col justify-between">
                            <div>
                                <h2 class="text-xl font-semibold mb-1">{{ $service->title }}</h2>
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 mr-1">
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                        <i class="fas fa-star text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium">{{ number_format($service->rating ?? 0, 1) }}</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-sm text-gray-500">{{ $service->location ?? 'Non précisé' }}</span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ Str::limit($service->description, 300, '...') }}
                                </p>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-medium">À partir de {{ number_format($service->price, 0, ',', ' ') }}DH</div>
                                <button
                                    class="openModalBtn bg-gradient-to-r from-wedding-pink to-wedding-pink text-white py-3 rounded-lg font-medium hover:from-from-wedding-pink hover:to-rose-500 transition-colors  py-2 px-4 rounded z-10"
                                    data-receiver-id="{{ $service->user_id }}"
                                    data-service-id="{{ $service->id }}"
                                    onclick="event.preventDefault(); event.stopPropagation();"
                                >
                                    Nous contacter
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-contact-modal :receiverId="$service->user_id ?? null" :serviceId="$service->id ?? null" />
@endsection
