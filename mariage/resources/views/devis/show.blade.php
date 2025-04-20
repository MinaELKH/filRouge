@extends('layouts.client')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-6">
        <h1 class="text-2xl font-bold mb-4">Devis #{{ $devis->id }}</h1>
        <p class="text-gray-600 mb-1">Date : {{ $devis->created_at->format('d/m/Y') }}</p>
        <p class="text-gray-800 font-semibold mb-4">Total : {{ number_format($devis->total_amount, 2) }} €</p>

        <h3 class="text-lg font-medium mb-2">Éléments :</h3>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-3 py-2 text-left">Service</th>
                    <th class="border px-3 py-2 text-right">Quantité</th>
                    <th class="border px-3 py-2 text-right">Prix unitaire</th>
                    <th class="border px-3 py-2 text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                @forelse($devis->devisItems as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $item->service_name }}</td>
                        <td class="border px-3 py-2 text-right">{{ $item->quantity }}</td>
                        <td class="border px-3 py-2 text-right">{{ number_format($item->unit_price, 2) }} €</td>
                        <td class="border px-3 py-2 text-right">{{ number_format($item->quantity * $item->unit_price, 2) }} €</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-3 py-2 text-center text-gray-500">
                            Aucun élément pour ce devis.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($devis->status === 'pending')
            <form action="{{ route('devis.confirm', $devis->id) }}" method="POST" class="mt-6">
                @csrf
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow"
                >
                    Confirmer et passer au paiement
                </button>
            </form>
        @else
            <p class="mt-6 text-green-600 font-semibold">Devis déjà confirmé.</p>
        @endif
    </div>
@endsection
