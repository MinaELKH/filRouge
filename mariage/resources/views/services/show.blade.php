@extends('layouts.main')

@section('title', $service->title)

@section('breadcrumb', 'Détail du service')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Colonne principale -->
            <div class="md:w-2/3">
                <!-- Galerie d'images -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Image principale -->
                        <div class="col-span-2 md:col-span-3">
                            <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                 alt="{{ $service->title }}"
                                 class="w-full h-96 object-cover rounded-lg shadow">
                        </div>

                        <!-- Galerie d'images -->
                        @if($service->gallery)
                            @php
                                $gallery = is_string($service->gallery) ? json_decode($service->gallery, true) : $service->gallery;
                            @endphp
                            @if(is_array($gallery))
                                @foreach($gallery as $index => $image)
                                    <div class="relative">
                                        <img src="{{ asset('images/services/gallery/' . $image) }}"
                                             alt="Galerie - {{ $service->title }}"
                                             class="w-full h-48 object-cover rounded-lg shadow cursor-pointer hover:opacity-90 transition">
                                        @if($index == 3 && count($gallery) > 4)
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg">
                                                <span class="text-white text-lg font-medium">Voir Photos +{{ count($gallery) - 4 }}</span>
                                            </div>
                                            @break
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-tag w-6 text-gray-500"></i>
                        <span>{{ $service->category->name }}</span>
                    </div>
                </div>

                <!-- Informations importantes -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <h2 class="text-2xl font-bold mb-4">À la hauteur de vos rêves</h2>
                    <div class="flex items-start mb-4">
                        <i class="fas fa-file-alt text-gray-500 mr-3 mt-1"></i>
                        <p class="text-gray-700">{{ $service->description }}</p>
                    </div>
                </div>

                <!-- Avis -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <h2 class="text-2xl font-bold mb-6">Avis de {{ $service->title }}</h2>

                    <div class="text-center mb-8">
{{--                        <div class="flex justify-center items-center mb-2">--}}
{{--                            @for($i = 1; $i <= 5; $i++)--}}
{{--                                <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>--}}
{{--                            @endfor--}}
{{--                        </div>--}}
                        <p class="text-lg font-medium">Ce prestataire n'a pas encore d'avis, donnez le vôtre !</p>
                        <p class="text-gray-600 mt-2">Votre opinion peut aider les futurs couples à prendre la bonne décision pour leur grand jour</p>
                        <button class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg mt-4 hover:bg-gray-50 transition-colors">
                            Écrivez une recommandation
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                    <h2 class="text-2xl font-bold mb-2">{{ $service->title }}</h2>

                    <!-- Étoiles et recommandation -->
                    <div class="flex items-center mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                        @endfor
                        <span class="ml-2 text-sm text-gray-600">0 avis Écrire une recommandation</span>
                    </div>

                    <!-- Localisation -->
                    <div class="flex items-center text-gray-600 mb-6">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $service->ville->name }}</span>
                    </div>

                    <!-- Prix -->
                    <div class="flex items-center mb-6">
                        <i class="fas fa-euro-sign mr-2 text-gray-600"></i>
                        <span class="text-gray-700">à partir de {{ number_format($service->price, 0, ',', ' ') }}€</span>
                    </div>



                    <!-- Bouton de contact -->
                    <button class="w-full bg-[#f76c6f] text-white py-3 rounded-lg font-medium hover:bg-pink-700 transition-colors mb-4">
                        Nous contacter
                    </button>

                    <!-- Actions favorites -->
                    <button class="w-full bg-white border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center">
                        <i class="far fa-heart mr-2"></i>
                        <span>Ajouter aux favoris</span>
                    </button>

                </div>
            </div>
        </div>

        <!-- Section informations de l'entreprise -->
{{--        <div class="mt-12">--}}
{{--            <div class="bg-white rounded-lg shadow-lg p-6">--}}
{{--                <h2 class="text-2xl font-bold mb-6">Informations</h2>--}}
{{--                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">--}}
{{--                    @if($service->entreprise->email)--}}
{{--                        <div>--}}
{{--                            <h3 class="font-medium text-gray-900 mb-1">Contact</h3>--}}
{{--                            <p class="text-gray-600">{{ $service->user->email }}</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    @if($service->entreprise->telephone)--}}
{{--                        <div>--}}
{{--                            <h3 class="font-medium text-gray-900 mb-1">Téléphone</h3>--}}
{{--                            <p class="text-gray-600">{{ $service->user->telephone }}</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    @if($service->entreprise->adresse)--}}
{{--                        <div>--}}
{{--                            <h3 class="font-medium text-gray-900 mb-1">Adresse</h3>--}}
{{--                            <p class="text-gray-600">{{ $service->user->adresse }}</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}


{{--        </div>--}}
    </div>
@endsection

@push('script')
    <script>
        // Script pour la galerie d'images (optionnel)
        document.addEventListener('DOMContentLoaded', function() {
            const galleryImages = document.querySelectorAll('.cursor-pointer');

            galleryImages.forEach(image => {
                image.addEventListener('click', function() {
                    // Vous pouvez ajouter une fonctionnalité de lightbox ici
                    console.log('Image clicked');
                });
            });
        });
    </script>
@endpush
