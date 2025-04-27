{{--services.show.blade.php--}}

@extends('layouts.main')

@section('title', $service->title)

@section('breadcrumb', 'Détail du service')

@section('content')
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Section image principale et galerie -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            <!-- Image principale -->
            <div class="relative">
                <img src="{{ asset('images/services/' . $service->cover_image) }}"
                     alt="{{ $service->title }}"
                     class="w-full h-96 object-cover rounded-lg shadow">

                <!-- Badge statut si archivé -->
                @if($service->archived)
                    <div class="absolute top-4 left-4">
                        <span class="bg-gray-800 text-white text-sm px-3 py-1 rounded-full">Archivé</span>
                    </div>
                @endif

                <!-- Badge prix -->
                <div class="absolute bottom-4 right-4">
                    <span class="bg-[#f76c6f] text-white font-bold text-lg px-4 py-2 rounded-lg shadow">
                        {{ number_format($service->price, 0, ',', ' ') }} €
                    </span>
                </div>
            </div>

            <!-- Galerie -->
            <div class="grid grid-cols-2 gap-4">
                @if($service->gallery)
                    @foreach(json_decode($service->gallery, true) as $image)
                        <img src="{{ asset('images/services/gallery/' . $image) }}"
                             alt="Galerie - {{ $service->title }}"
                             class="w-full h-44 object-cover rounded-lg shadow cursor-pointer hover:opacity-90 transition">
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Informations détaillées -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="col-span-2">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $service->title }}</h1>

                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 mb-3">Description</h2>
                        <p class="text-gray-600 whitespace-pre-line">{{ $service->description }}</p>
                    </div>

                    <!-- Informations importantes -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-700 mb-3">Informations importantes</h2>
                        <ul class="space-y-3">
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-alt w-6 text-[#f76c6f]"></i>
                                <span>Créé le {{ $service->created_at->format('d/m/Y') }}</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-tag w-6 text-[#f76c6f]"></i>
                                <span>Catégorie : {{ $service->category->name }}</span>
                            </li>
                            <li class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt w-6 text-[#f76c6f]"></i>
                                <span>Ville : {{ $service->ville->name }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Informations sur le prestataire -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">À propos du prestataire</h2>
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                <i class="fas fa-user text-gray-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $service->user->name }}</h3>
                                <p class="text-gray-600">Membre depuis {{ $service->user->created_at->format('Y') }}</p>
                            </div>
                        </div>
                        <p class="text-gray-600">
                            Ce prestataire propose des services de qualité dans le domaine de
                            {{ strtolower($service->category->name) }} à {{ $service->ville->name }}.
                        </p>
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="col-span-1">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-24">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-[#f76c6f]">{{ number_format($service->price, 0, ',', ' ') }} €</h3>
                            <p class="text-gray-500">Prix du service</p>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            @auth
                                @if(auth()->user()->id === $service->user_id)
                                    <!-- Actions pour le propriétaire -->
                                    <a href="{{ route('edite_service', $service->id) }}"
                                       class="flex items-center justify-center w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition">
                                        <i class="fas fa-edit mr-2"></i> Modifier
                                    </a>

                                    @if(!$service->archived)
                                        <button type="button"
                                                data-id="{{ $service->id }}"
                                                class="archive-btn flex items-center justify-center w-full bg-yellow-500 text-white px-4 py-3 rounded-lg hover:bg-yellow-600 transition">
                                            <i class="fas fa-box-archive mr-2"></i> Archiver
                                        </button>
                                    @else
                                        <button type="button"
                                                data-id="{{ $service->id }}"
                                                class="desarchive-btn flex items-center justify-center w-full bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition">
                                            <i class="fas fa-undo mr-2"></i> Désarchiver
                                        </button>
                                    @endif
                                @else
                                    <!-- Actions pour les clients -->
                                    <button type="button"
                                            class="flex items-center justify-center w-full bg-[#f76c6f] text-white px-4 py-3 rounded-lg hover:bg-pink-700 transition">
                                        <i class="fas fa-envelope mr-2"></i> Nous contacter
                                    </button>

                                    <button type="button"
                                            class="flex items-center justify-center w-full bg-white border border-gray-300 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-50 transition">
                                        <i class="fas fa-heart mr-2"></i> Ajouter aux favoris
                                    </button>
                                @endif
                            @else
                                <!-- Actions pour les visiteurs -->
                                <a href="{{ route('login') }}"
                                   class="flex items-center justify-center w-full bg-[#f76c6f] text-white px-4 py-3 rounded-lg hover:bg-pink-700 transition">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter pour réserver
                                </a>
                            @endauth
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Service vérifié
                            </p>
                            <p class="text-sm text-gray-500 flex items-center mt-2">
                                <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                                Paiement sécurisé
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Réutilisation du même script pour l'archivage/désarchivage
        document.addEventListener('DOMContentLoaded', function () {
            // Archive/Desarchive functionality
            const archiveBtn = document.querySelector('.archive-btn');
            const desarchiveBtn = document.querySelector('.desarchive-btn');

            if (archiveBtn) {
                archiveBtn.addEventListener('click', function () {
                    if (confirm('Êtes-vous sûr de vouloir archiver ce service ?')) {
                        const serviceId = this.dataset.id;
                        fetch(`/services/${serviceId}/archive`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                window.location.reload();
                            });
                    }
                });
            }

            if (desarchiveBtn) {
                desarchiveBtn.addEventListener('click', function () {
                    const serviceId = this.dataset.id;
                    fetch(`/services/${serviceId}/desarchive`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            window.location.reload();
                        });
                });
            }
        });
    </script>
@endpush
