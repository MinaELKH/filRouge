<!-- resources/views/client/reservations.blade.php -->


@extends('layouts.main')

@section('title', 'Mes Réservations')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <h1 class="text-2xl font-bold mb-6 text-wedding-dark">Mes Réservations</h1>

        @if ($reservations->isEmpty())
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <i class="fas fa-calendar-times text-wedding-pink text-5xl mb-4"></i>
                <p class="text-gray-600">Aucune réservation trouvée.</p>
                <a href="{{ route('services.index') }}" class="mt-4 inline-block bg-wedding-pink hover:bg-pink-600 text-white font-medium py-2 px-4 rounded transition duration-300">
                    Explorer les services
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($reservations as $reservation)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Galerie avec badge de statut -->
                        <div class="relative">
                            <img src="{{ asset('images/services/' . $reservation->service->cover_image) }}"
                                 alt="{{ $reservation->service->title }}"
                                 class="w-full h-56 object-cover">
                            <div class="absolute top-0 right-0 m-3">
                            <span class="text-xs font-medium px-3 py-1 rounded-full
                                @if($reservation->status == 'completed') bg-green-500
                                @elseif($reservation->status == 'pending') bg-yellow-500
                                @elseif($reservation->status == 'rejected') bg-red-500
                                @else bg-blue-500
                                @endif text-white">
                                {{ $reservation->status }}
                            </span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                <h2 class="text-white text-xl font-semibold">{{ $reservation->service->title }}</h2>
                                <div class="flex items-center text-white/80 text-sm">
                                    <i class="fas fa-tag mr-2"></i>
                                    <span>{{ $reservation->service->category->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Détails de la réservation -->
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-full bg-wedding-pink/10 flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar-day text-wedding-pink"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Date de l'événement</p>
                                    <p class="font-medium">{{ $reservation->event_date }}</p>
                                </div>
                            </div>

                            <!-- Vérification du devis et discussion -->
                            @php
                                // Vérifier si un devis existe pour la réservation
                                $devis = $reservation->devis; // Assurez-vous que 'devis' est bien une relation dans le modèle Reservation
                                $client = auth()->user();
                            @endphp

                            <div class="mt-6 space-y-3">
                                @if ($devis)
                                    <!-- Afficher le bouton 'Afficher Devis' -->
                                    <a href="{{ route('devis.page', ['id' => $devis->id]) }}"
                                       class="bg-wedding-pink hover:bg-pink-600 text-white font-medium py-3 px-4 rounded-lg w-full text-center block transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        Afficher Devis
                                    </a>
                                @else
                                    <a href="#"
                                       class="bg-gray-300  text-white font-medium py-3 px-4 rounded-lg w-full text-center flex items-center justify-center">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        En attente de devis
                                    </a>
                                @endif
                                    <!-- Afficher le boutQ00on 'Voir Discussion' -->
                                    <a href="{{ route('messages.index', ['partnerId' => $reservation->service->user_id]) }}"
                                       class="bg-wedding-pink hover:bg-pink-600 text-white font-medium py-3 px-4 rounded-lg w-full text-center block transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-comments mr-2"></i>
                                        Voir Discussion
                                    </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
