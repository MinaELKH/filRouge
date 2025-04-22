@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 p-6 bg-white shadow rounded-xl">
    <h1 class="text-2xl font-bold mb-6">Mes Devis Envoyés</h1>

    <table class="min-w-full table-auto">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Service</th>
            <th class="px-4 py-2">Client</th>
            <th class="px-4 py-2">Montant</th>
            <th class="px-4 py-2">Statut</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($devisList as $devis)
        <tr class="border-t">
            <td class="px-4 py-2">{{ $devis->id }}</td>
            <td class="px-4 py-2">{{ $devis->reservation->service->title ?? '—' }}</td>
            <td class="px-4 py-2">{{ $devis->reservation->user->name ?? '—' }}</td>
            <td class="px-4 py-2">{{ $devis->total_amount }} €</td>
            <td class="px-4 py-2">{{ ucfirst($devis->status) }}</td>
            <td class="px-4 py-2">
                <a href="{{ route('devis.edit', $devis->id) }}" class="text-blue-600 hover:underline">Modifier</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">Aucun devis trouvé.</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
