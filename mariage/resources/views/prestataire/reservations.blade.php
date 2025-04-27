{{-- resources/views/prestataire/reservations.blade.php --}}
@extends('layouts.main')

@section('content')
    <div class="max-w-6xl mx-auto mt-8 p-6 bg-white shadow-lg rounded-xl border border-pink-100">
        <h1 class="text-3xl font-bold mb-8 text-[#f76c6f] border-b pb-4 border-pink-200">Mes Services Réservés</h1>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead>
                <tr class="bg-[rgba(247,108,111,0.6)]">
                    <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Service</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Date de l'événement</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Statut Réservation</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Devis</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-100">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-pink-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reservation->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reservation->service->title ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reservation->user->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $reservation->event_date->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $reservation->status == 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($reservation->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reservation->devis)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $reservation->devis->status == 'accepté' ? 'bg-green-100 text-green-800' :
                                       ($reservation->devis->status == 'refusé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($reservation->devis->status) }}
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Sans devis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                @if($reservation->devis)
                                    <a href="{{ route('devis.show', $reservation->devis->id) }}"
                                       class="text-pink-600 hover:text-pink-900 bg-pink-50 hover:bg-pink-100 px-3 py-1 rounded-md transition-colors duration-150">
                                        Voir devis
                                    </a>
                                @else

                                    <a href="{{ route('devis.create',$reservation->id) }}"
                                       class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-md transition-colors duration-150">
                                        Créer devis
                                    </a>
                                @endif

                                <a href="{{ route('messages.index',  $reservation->user_id) }}"
                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition-colors duration-150">
                                    Messages
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500 italic bg-gray-50">
                            <p>Aucune réservation trouvée.</p>
                            <p class="mt-2 text-sm">Vous n'avez pas encore de services réservés.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
