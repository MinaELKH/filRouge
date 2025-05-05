{{-- resources/views/client/favorites.blade.php --}}
@extends('layouts.main')

@section('title', 'Mes Favoris')
@section('breadcrumb', 'Mes Favoris')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-wedding-dark">Mes Services Favoris</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($favorites->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <div class="text-5xl text-wedding-pink mb-4">
                <i class="far fa-heart"></i>
            </div>
            <h2 class="text-xl font-medium text-gray-700 mb-2">Vous n'avez pas encore de favoris</h2>
            <p class="text-gray-500 mb-6">Explorez les services disponibles et ajoutez-les à vos favoris pour les retrouver facilement.</p>
            <a href="{{ route('services.index') }}" class="bg-wedding-pink hover:bg-pink-600 text-white py-2 px-6 rounded-lg transition-colors">
                Explorer les services
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $service)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200 border border-gray-100 relative">
                    <!-- Image de couverture -->
                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                         alt="{{ $service->title }}"
                         class="h-48 w-full object-cover">

                    <!-- Badge favoris -->
                    <button class="remove-favorite absolute top-3 right-3 bg-white rounded-full p-2 shadow-md text-wedding-pink hover:text-red-700"
                            data-service-id="{{ $service->id }}"
                            title="Retirer des favoris">
                        <i class="fas fa-heart"></i>
                    </button>

                    <!-- Prix -->
                    <div class="absolute bottom-48 right-3 bg-wedding-pink text-white text-sm font-bold py-1 px-3 rounded-lg">
                        {{ number_format($service->price, 0, ',', ' ') }} DH
                    </div>

                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-800 mb-2 hover:text-wedding-pink transition-colors">{{ $service->title }}</h2>

                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($service->description, 80) }}</p>

                        <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <i class="fas fa-tag text-wedding-pink mr-1.5"></i>
                                    {{ $service->category->name }}
                                </span>

                                <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-wedding-pink mr-1.5"></i>
                                    {{ $service->ville->name }}
                                </span>
                            </div>

                            <a href="{{ route('services.show', $service->id) }}" class="text-wedding-pink hover:underline flex items-center">
                                Voir <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des boutons pour retirer des favoris
            const removeBtns = document.querySelectorAll('.remove-favorite');

            removeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-service-id');
                    const card = this.closest('.bg-white');

                    if (confirm('Êtes-vous sûr de vouloir retirer ce service de vos favoris ?')) {
                        fetch(`/client/favorites/${serviceId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Animation de suppression
                                    card.style.transition = 'all 0.3s ease';
                                    card.style.opacity = '0';
                                    card.style.transform = 'scale(0.8)';

                                    setTimeout(() => {
                                        card.remove();

                                        // Vérifier s'il reste des favoris
                                        if (document.querySelectorAll('.remove-favorite').length === 0) {
                                            location.reload(); // Recharger pour afficher le message "pas de favoris"
                                        }
                                    }, 300);
                                }
                            })
                            .catch(error => console.error('Erreur:', error));
                    }
                });
            });
        });
    </script>
@endpush
