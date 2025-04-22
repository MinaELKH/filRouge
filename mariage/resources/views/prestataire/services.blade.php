@extends('layouts.prestataire')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Mes Services</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
            <div class="bg-white rounded-xl shadow-md overflow-hidden relative">
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
                    @if($service->status != 'archived')
                        <form action="{{ route('services.archive', $service->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-500 hover:text-yellow-700">
                                <i class="fas fa-box-archive fa-lg"></i>
                            </button>
                        </form>
                    @else
                        <span class="text-gray-400">
                            <i class="fas fa-box-archive"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.archive-btn').on('click', function (e) {
            e.preventDefault();
            let button = $(this);
            let serviceId = button.data('id');

            $.ajax({
                url: '/prestataire/services/' + serviceId + '/archive',
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    button.closest('.service-item').fadeOut(); // ou changer l'état visuellement
                },
                error: function (xhr) {
                    alert('Erreur lors de l\'archivage.');
                }
            });
        });
    </script>
@endsection
