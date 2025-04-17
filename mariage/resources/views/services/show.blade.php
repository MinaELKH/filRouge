@extends('layouts.app')

@section('title', 'Service - ' . $service->title)

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Galerie -->
            <div class="md:w-2/3">
                <div class="grid grid-cols-6 gap-2 mb-8">
                    <!-- Couverture principale -->
                    <div class="col-span-3 row-span-2">
                        <img src="{{ asset('images/services/' . $service->cover_image) }}"
                             alt="{{ $service->title }}"
                             class="w-full h-full object-cover rounded-l-lg">
                    </div>

                    <!-- Deux premières images -->
                    <div class="col-span-3 grid grid-cols-2 gap-2">
                        @php
                            $gallery = is_array($service->gallery) ? $service->gallery : json_decode($service->gallery ?? '[]', true);
                        @endphp
                        @foreach(array_slice($gallery, 0, 2) as $image)
                            <div>
                                <img src="{{ asset('images/services/' . $image) }}"
                                     alt=""
                                     class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>

                    <!-- Troisième image -->
                    @if(count($gallery) > 2)
                        <div class="col-span-3 relative">
                            <img src="{{ asset('images/services/' . $gallery[2]) }}"
                                 alt=""
                                 class="w-full h-full object-cover rounded-br-lg">
                            <button class="absolute bottom-4 right-4 bg-white hover:bg-gray-100 text-gray-800 text-sm font-medium py-1 px-3 rounded shadow flex items-center">
                                Voir Photos <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Détails -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Description</h2>
                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Catégorie</h2>
                    <p class="text-sm">{{ $service->category->name }}</p>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Prestataire</h2>
                    <p class="text-sm">{{ $service->user->name }}</p>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Ville</h2>
                    <p class="text-sm">{{ $service->ville->name }}</p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="md:w-1/3">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-4">{{ $service->title }}</h1>

                    <div class="mb-4">
                        <i class="far fa-clock text-gray-500 mr-2"></i>
                        <span class="text-sm">À partir de {{ $service->price }} DH</span>
                    </div>

                    <button
                        class="openModalBtn bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded"
                        data-receiver-id="{{ $service->user_id }}"
                    >
                        Nous contacter
                    </button>

                </div>
            </div>
        </div>
    </div>

    <x-contact-modal/>
@endsection
