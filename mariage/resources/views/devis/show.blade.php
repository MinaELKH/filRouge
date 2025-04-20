@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-6">
        <h1 class="text-2xl font-bold mb-4">Détails du devis</h1>

        <p><strong>Réservation ID :</strong> {{ $devis->reservation_id }}</p>
        <p><strong>Montant total :</strong> {{ $devis->total_amount }} €</p>
        <p><strong>Status :</strong> {{ ucfirst($devis->status) }}</p>

        <hr class="my-4">

        <!-- Liste des items du devis -->
        <ul>
            @foreach ($devis->items as $item)
                <li>{{ $item->service_name }} - {{ $item->quantity }} x {{ $item->unit_price }} €</li>
            @endforeach
        </ul>

        @if($devis->status === 'pending')
            <form action="{{ route('devis.confirm', $devis->id) }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                    Confirmer et passer au paiement
                </button>
            </form>
        @else
            <p class="mt-4 text-green-600 font-semibold">Devis déjà confirmé.</p>
        @endif
    </div>
@endsection
