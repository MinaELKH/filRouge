@extends('layouts.client')

@section('content')
    <h2 class="text-xl font-bold mb-4">Mes services réservés</h2>

    @forelse($reservations as $reservation)
        <div class="border p-4 rounded mb-4 shadow-sm">
            <h3 class="text-lg font-semibold">{{ $reservation->service->title }}</h3>
            <p><strong>Date de réservation :</strong> {{ $reservation->created_at->format('d/m/Y') }}</p>
            <p><strong>Date de l'événement :</strong> {{ $reservation->event_date->format('d/m/Y') }}</p>
            <p><strong>Prestataire :</strong> {{ $reservation->service->user->name }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($reservation->status) }}</p>

            <div class="mt-3 flex gap-2">
                <a href="{{ route('messages.start', $reservation->id) }}"
                   class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">
                    Contacter le prestataire
                </a>

                @if($reservation->devis && $reservation->status === 'accepted')
                    <a href="{{ route('devis.show', $reservation->devis->id) }}"
                       class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Voir le devis
                    </a>
                @endif
            </div>
        </div>
    @empty
        <p>Aucune réservation pour le moment.</p>
    @endforelse
@endsection
