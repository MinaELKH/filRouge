<!-- resources/views/client/reservations.blade.php -->


@extends('layouts.client')

@section('title', 'Mes Réservations')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <h1 class="text-2xl font-bold mb-6">Mes Réservations</h1>

        @if ($reservations->isEmpty())
            <p>Aucune réservation trouvée.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($reservations as $reservation)
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <!-- Galerie -->
                        <div class="mb-4">
                            <img src="{{ asset('images/services/' . $reservation->service->cover_image) }}"
                                 alt="{{ $reservation->service->title }}"
                                 class="w-full h-48 object-cover rounded-lg">
                        </div>

                        <!-- Détails de la réservation -->
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold mb-2">{{ $reservation->service->title }}</h2>
                            <p class="text-sm text-gray-600">{{ $reservation->service->category->name }}</p>
                            <p class="text-sm text-gray-600">Date de l'événement : {{ $reservation->event_date }}</p>
                        </div>

                        <div class="mb-4">
                            <span class="text-sm font-medium">Statut de la réservation : </span>
                            <span class="text-sm font-semibold text-gray-600">{{ $reservation->status }}</span>
                        </div>

                        <!-- Vérification du devis et discussion -->
                        @php
                            // Vérifier si un devis existe pour la réservation
                            $devis = $reservation->devis; // Assurez-vous que 'devis' est bien une relation dans le modèle Reservation
                            $client = auth()->user();
                        @endphp

                        @if ($devis)
                            <!-- Afficher le bouton 'Afficher Devis' -->
                            <a href="{{ route('devis.page', ['id' => $devis->id]) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded mb-4 w-full text-center block">
                                Afficher Devis
                            </a>
                        @elseif ($client && $reservation->status == 'completed' || $reservation->status == 'rejected')
                            <!-- Afficher le bouton 'Voir Discussion' -->
                            <a href="{{ route('messages.index', ['partnerId' => $reservation->service->user_id]) }}"
                               class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded mb-4 w-full text-center block">
                                Voir Discussion
                            </a>
{{--                        @else--}}
{{--                            <!-- Afficher le bouton 'Nous contacter' si pas de devis ou discussion -->--}}
{{--                            <a href="{{ route('services.show', ['service' => $reservation->service->id]) }}"--}}
{{--                               class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded mb-4 w-full text-center block">--}}
{{--                                Nous contacter--}}
{{--                            </a>--}}
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
