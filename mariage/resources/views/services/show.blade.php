@extends('layouts.main')

@section('title', $service->title)

@section('breadcrumb', 'Détail du service')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Colonne principale -->
            <div class="md:w-2/3">
                <!-- Galerie d'images style mariages.net adaptative -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($service->gallery)
                        @php
                            $gallery = is_string($service->gallery) ? json_decode($service->gallery, true) : $service->gallery;
                            $galleryImages = is_array($gallery) ? array_slice($gallery, 0, 4) : [];
                            $totalImages = count($galleryImages);
                        @endphp

                        @if($totalImages == 0)
                            <!-- Seulement l'image de couverture -->
                            <div class="relative">
                                <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                     alt="{{ $service->title }}"
                                     class="w-full h-[400px] object-cover">
                            </div>
                        @elseif($totalImages == 1)
                            <!-- Image de couverture + 1 image -->
                            <div class="grid grid-cols-2 gap-0.5">
                                <div class="relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[0]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                            </div>
                        @elseif($totalImages == 2)
                            <!-- Image de couverture + 2 images -->
                            <div class="grid grid-cols-3 gap-0.5">
                                <div class="col-span-2 relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                <div class="grid grid-rows-2 gap-0.5">
                                    @foreach($galleryImages as $image)
                                        <div class="relative">
                                            <img src="{{ asset('images/services/gallery/' . $image) }}"
                                                 alt="Galerie - {{ $service->title }}"
                                                 class="w-full h-[200px] object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($totalImages == 3)
                            <!-- Image de couverture + 3 images -->
                            <div class="grid grid-cols-4 gap-0.5">
                                <div class="col-span-2 row-span-2 relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                <div class="col-span-2 relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[0]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[200px] object-cover">
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[1]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[200px] object-cover">
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[2]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[200px] object-cover">
                                </div>
                            </div>
                        @else
                            <!-- Image de couverture + 4 images -->
                            <div class="grid grid-cols-3 gap-0.5">
                                <div class="col-span-2 row-span-2 relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                @foreach($galleryImages as $index => $image)
                                    <div class="relative">
                                        <img src="{{ asset('images/services/gallery/' . $image) }}"
                                             alt="Galerie - {{ $service->title }}"
                                             class="w-full h-[200px] object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <!-- Seulement l'image de couverture si pas de galerie -->
                        <div class="relative">
                            <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                 alt="{{ $service->title }}"
                                 class="w-full h-[400px] object-cover">
                        </div>
                    @endif
                </div>

                <!-- Informations importantes -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <h2 class="text-2xl font-bold mb-4">Informations importantes</h2>
                    <div class="flex items-start mb-4">
                        <i class="fas fa-file-alt text-gray-500 mr-3 mt-1"></i>
                        <p class="text-gray-700">{!! $service->description !!}</p>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <h2 class="text-2xl font-bold mb-4">Informations</h2>
                    <div class="space-y-4">
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-calendar-alt w-6 text-gray-500"></i>
                            <span>Créé le {{ $service->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-tag w-6 text-gray-500"></i>
                            <span>{{ $service->category->name }}</span>
                        </div>
                    </div>
                </div>

                @if($service->user->description)
                    <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                        <h2 class="text-2xl font-bold mb-4">À propos de {{ $service->user->nom ?? $service->user->name }}</h2>
                        <p class="text-gray-700">{!! $service->user->description !!}</p>
                    </div>
                @endif

                <!-- Avis -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <h2 class="text-2xl font-bold mb-6">Avis de {{ $service->title }}</h2>

                    <div class="text-center mb-8">
                        <div class="flex justify-center items-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>
                            @endfor
                        </div>
                        <p class="text-lg font-medium">Ce prestataire n'a pas encore d'avis, donnez le vôtre !</p>
                        <p class="text-gray-600 mt-2">Votre opinion peut aider les futurs couples à prendre la bonne décision pour leur grand jour</p>
                        <button class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg mt-4 hover:bg-gray-50 transition-colors">
                            Écrivez une recommandation
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar fixée à droite -->
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

                    <!-- Capacité -->
                    <div class="flex items-center mb-6">
                        <i class="fas fa-users mr-2 text-gray-600"></i>
                        <span class="text-gray-700">80 - 490 invité(s)</span>
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

                    <!-- Très sollicité à Paris -->
                    <div class="mt-4 text-sm text-gray-600">
                        <i class="fas fa-chart-line mr-1"></i>
                        Très sollicité à {{ $service->ville->name }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section informations de l'entreprise -->
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-6">Informations de contact</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if($service->user->email)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">{{ $service->user->email }}</p>
                        </div>
                    @endif

                    @if($service->user->telephone)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Téléphone</h3>
                            <p class="text-gray-600">{{ $service->user->telephone }}</p>
                        </div>
                    @endif

                    @if($service->user->adresse)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Adresse</h3>
                            <p class="text-gray-600">{{ $service->user->adresse }}</p>
                        </div>
                    @endif

                    @if($service->user->personne_contact)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Personne de contact</h3>
                            <p class="text-gray-600">{{ $service->user->personne_contact }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Script pour ouvrir la galerie en mode lightbox (optionnel)
        document.addEventListener('DOMContentLoaded', function() {
            const galleryButtons = document.querySelectorAll('.cursor-pointer');

            galleryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ici vous pouvez ajouter la fonctionnalité pour ouvrir une lightbox
                    // ou une modale pour afficher toutes les images
                    console.log('Ouvrir la galerie complète');
                });
            });
        });
    </script>
@endpush
