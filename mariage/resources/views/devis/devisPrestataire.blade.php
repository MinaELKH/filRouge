@extends('layouts.main')

@section('content')
    <div class="max-w-6xl mx-auto mt-8 p-6 bg-white shadow-lg rounded-xl border border-pink-100">
        <h1 class="text-3xl font-bold mb-8 text-[#f76c6f]  border-b pb-4 border-pink-200">Mes Devis Envoyés</h1>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead>
                <tr class="bg-[rgba(247,108,111,0.6)]">
                    <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Service</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Montant</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Statut</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold" colspan="2">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-100">
                @forelse($devisList as $devis)
                    <tr class="hover:bg-pink-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $devis->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $devis->reservation->service->title ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $devis->reservation->user->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $devis->total_amount }} DH</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $devis->status == 'accepté' ? 'bg-green-100 text-green-800' :
                              ($devis->status == 'refusé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($devis->status) }}
                        </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('devis.show', $devis->id) }}" class="text-pink-600 hover:text-pink-900 bg-pink-50 hover:bg-pink-100 px-3 py-1 rounded-md transition-colors duration-150">
                                Voir
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('devis.edit', $devis->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition-colors duration-150">
                                Modifier
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic bg-gray-50">
                            <p>Aucun devis trouvé.</p>
                            <p class="mt-2 text-sm">Vous n'avez pas encore envoyé de devis à vos clients.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
