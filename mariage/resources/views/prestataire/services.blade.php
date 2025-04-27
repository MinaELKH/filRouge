@extends('layouts.main')

@section('title', 'Mes Services')

@section('breadcrumb', 'Mes Services')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#f76c6f]">Mes Services</h1>
        <a href="{{Route('services.create')}}" class="bg-[#f76c6f] hover:bg-pink-700 text-white py-2 px-4 rounded-lg transition-colors duration-150 flex items-center">
            <i class="fas fa-plus mr-2"></i> Ajouter un service
        </a>
    </div>

    @if(count($services) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200 border border-gray-100" id="service-{{ $service->id }}">
                    <!-- Statut comme un badge en haut à gauche -->
                    @if($service->archived == true)
                        <div class="absolute top-3 left-3 z-10">
                            <span class="bg-gray-800 text-white text-xs px-2 py-1 rounded">Archivé</span>
                        </div>
                    @endif

                    <div class="relative">
                        <img src="{{ asset('images/services/' . $service->cover_image) }}" alt="{{ $service->title }}" class="h-48 w-full object-cover">

                        <!-- Actions flottantes sur l'image -->
                        <div class="absolute top-3 right-3 flex space-x-1">
                            <a href="{{ route('edite_service', $service->id) }}" class="bg-white bg-opacity-90 text-gray-700 p-2 rounded-md hover:bg-blue-500 hover:text-white transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if($service->archived != true)
                                <button type="button" class="bg-white bg-opacity-90 text-gray-700 p-2 rounded-md hover:bg-yellow-500 hover:text-white transition-colors archive-btn" data-id="{{ $service->id }}">
                                    <i class="fas fa-box-archive"></i>
                                </button>
                            @else
                                <button type="button" class="bg-white bg-opacity-90 text-gray-700 p-2 rounded-md hover:bg-green-500 hover:text-white transition-colors desarchive-btn" data-id="{{ $service->id }}">
                                    <i class="fas fa-undo"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Prix en badge sur l'image -->
                        <div class="absolute bottom-3 right-3">
                <span class="bg-[#f76c6f] text-white font-bold py-1 px-3 rounded-lg">
                    {{ $service->price }} €
                </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-800 mb-2 hover:text-[#f76c6f] transition-colors">{{ $service->title }}</h2>

                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($service->description, 80) }}</p>

                        <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                            <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <i class="fas fa-tag text-[#f76c6f] mr-1.5"></i>
                        {{ $service->category->name }}
                    </span>

                                <span class="flex items-center">
                        <i class="fas fa-map-marker-alt text-[#f76c6f] mr-1.5"></i>
                        {{ $service->ville->name }}
                    </span>
                            </div>

                            <a href="{{ route('services.show', $service->id) }}" class="text-[#f76c6f] hover:underline flex items-center">
                                Voir <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-200">
            <i class="fas fa-store text-gray-300 text-5xl mb-3"></i>
            <h2 class="text-xl font-medium text-gray-700 mb-2">Aucun service disponible</h2>
            <p class="text-gray-500 mb-6">Vous n'avez pas encore créé de services à proposer à vos clients.</p>
            <a href="{{ route('create_service') }}" class="bg-[#f76c6f] hover:bg-pink-700 text-white py-2 px-6 rounded-lg transition-colors duration-150 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Créer mon premier service
            </a>
        </div>
    @endif
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Notifications avec SweetAlert au lieu d'alert standard
            function showNotification(message, type = 'success') {
                const notif = document.createElement('div');
                notif.className = `fixed top-4 right-4 bg-white shadow-lg rounded-lg p-4 flex items-center z-50 ${
                    type === 'success' ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500'
                }`;

                notif.innerHTML = `
                    <div class="mr-3 text-${type === 'success' ? 'green' : 'red'}-500">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} fa-lg"></i>
                    </div>
                    <div>
                        <p class="font-medium">${message}</p>
                    </div>
                    <button class="ml-4 text-gray-400 hover:text-gray-500" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;

                document.body.appendChild(notif);

                setTimeout(() => {
                    notif.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => notif.remove(), 500);
                }, 3000);
            }

            // Archive Service
            document.querySelectorAll('.archive-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = this.dataset.id;
                    const serviceCard = document.getElementById(`service-${serviceId}`);

                    if (confirm('Êtes-vous sûr de vouloir archiver ce service ? Il ne sera plus visible par les clients.')) {
                        fetch(`/services/${serviceId}/archive`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                showNotification(data.message);
                                serviceCard.classList.add('opacity-50');
                                setTimeout(() => location.reload(), 1000);
                            })
                            .catch(err => {
                                console.error('Erreur lors de l\'archivage:', err);
                                showNotification('Une erreur s\'est produite lors de l\'archivage.', 'error');
                            });
                    }
                });
            });

            // Desarchive Service
            document.querySelectorAll('.desarchive-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = this.dataset.id;
                    const serviceCard = document.getElementById(`service-${serviceId}`);

                    fetch(`/services/${serviceId}/desarchive`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            showNotification(data.message);
                            setTimeout(() => location.reload(), 1000);
                        })
                        .catch(err => {
                            console.error('Erreur lors du désarchivage:', err);
                            showNotification('Une erreur s\'est produite lors du désarchivage.', 'error');
                        });
                });
            });
        });
    </script>
@endpush
