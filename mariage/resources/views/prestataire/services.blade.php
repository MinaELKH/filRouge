@extends('layouts.prestataire')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Mes Services</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-md overflow-hidden relative" id="service-{{ $service->id }}">
                <img src="{{ $service->cover_image }}" alt="{{ $service->title }}" class="h-48 w-full object-cover">

                <div class="p-4 space-y-2">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $service->title }}</h2>
                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                    <p class="text-sm text-gray-500">Catégorie : {{ $service->category->name }}</p>
                    <p class="text-sm text-gray-500">Ville : {{ $service->ville->name }}</p>
                    <p class="text-sm text-pink-600 font-semibold">Prix : {{ $service->price }} €</p>
                </div>

                <div class="absolute top-2 right-2 flex space-x-2">
                    <!-- Modifier -->
                    <a href="{{ route('edite_service', $service->id) }}"
                       class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit fa-lg"></i>
                    </a>

                    <!-- Archiver -->
                    @if($service->archived != true)
                        <button type="button"
                                class="text-yellow-500 hover:text-yellow-700 archive-btn"
                                data-id="{{ $service->id }}"
                                aria-label="Archiver">
                            <i class="fas fa-box-archive fa-lg"></i>
                        </button>
                    @else
                        <span class="text-gray-400">
                            <i class="fas fa-box-archive"></i>
                        </span>
                    @endif

                    <!-- Désarchiver -->
                    @if($service->archived == true)
                        <button type="button"
                                class="text-green-500 hover:text-green-700 desarchive-btn"
                                data-id="{{ $service->id }}"
                                aria-label="Désarchiver">
                            <i class="fas fa-undo fa-lg"></i>
                        </button>
                    @else
                        <span class="text-gray-400">
                            <i class="fas fa-undo"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Archive Service
            document.querySelectorAll('.archive-btn').forEach(button => {
                button.addEventListener('click', function () {
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
                            alert(data.message);
                            location.reload(); // Recharge la page pour afficher l'état mis à jour
                        })
                        .catch(err => {
                            console.error('Erreur lors de l\'archivage:', err);
                            alert('Une erreur s\'est produite lors de l\'archivage.');
                        });
                });
            });

            // Desarchive Service
            document.querySelectorAll('.desarchive-btn').forEach(button => {
                button.addEventListener('click', function () {
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
                            alert(data.message);
                            location.reload(); // Recharge la page pour afficher l'état mis à jour
                        })
                        .catch(err => {
                            console.error('Erreur lors du désarchivage:', err);
                            alert('Une erreur s\'est produite lors du désarchivage.');
                        });
                });
            });
        });
    </script>
@endsection
