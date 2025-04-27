@extends('layouts.main')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Liste des devis</h2>

        <table class="min-w-full bg-white border">
            <thead>
            <tr class="bg-gray-100 text-left text-sm font-medium text-gray-600">
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Réservation</th>
                <th class="py-3 px-4">Montant total</th>
                <th class="py-3 px-4">Statut</th>
                <th class="py-3 px-4">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($devisList as $devis)
                <tr class="border-t text-sm">
                    <td class="py-2 px-4">{{ $devis->id }}</td>
                    <td class="py-2 px-4">{{ $devis->reservation_id }}</td>
                    <td class="py-2 px-4">{{ number_format($devis->total_amount, 2) }} €</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded-full text-white text-xs
                            {{ $devis->status === 'approved' ? 'bg-green-500' :
                               ($devis->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                            {{ ucfirst($devis->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4 space-x-2">
                        <a href="{{ route('devis.show', $devis->id) }}"
                           class="text-blue-500 hover:underline">Voir</a>
                        <a href="{{ route('devis.edit', $devis->id) }}"
                           class="text-indigo-500 hover:underline">Modifier</a>
                        <form action="{{ route('devis.destroy', $devis->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Supprimer ce devis ?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
