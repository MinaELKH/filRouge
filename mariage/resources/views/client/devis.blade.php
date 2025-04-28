<!-- resources/views/client/devis.blade.php -->
@extends('layouts.main')

@section('title', 'Mes Devis')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <h1 class="text-2xl font-bold mb-6 text-wedding-dark">Mes Devis</h1>

        @if ($reservations->isEmpty())
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <i class="fas fa-file-invoice-dollar text-wedding-pink text-5xl mb-4"></i>
                <p class="text-gray-600">Aucun devis trouvé.</p>

            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="bg-wedding-pink/10">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Statut Devis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Paiement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Devis</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach ($reservations as $reservation)
                            <tr class="hover:bg-gray-50">
                                <!-- Service -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 object-cover rounded-md"
                                                 src="{{ asset('images/services/' . $reservation->service->cover_image) }}"
                                                 alt="{{ $reservation->service->title }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $reservation->service->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $reservation->service->category->name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Date événement -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($reservation->event_date)->format('d/m/Y') }}</div>
                                </td>

                                <!-- Statut du devis -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($reservation->devis)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($reservation->devis->status == 'accepted') bg-green-100 text-green-800
                            @elseif($reservation->devis->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($reservation->devis->status == 'rejected') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($reservation->devis->status) }}
                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">Non disponible</span>
                                    @endif
                                </td>

                                <!-- Montant -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($reservation->devis)
                                        <div class="text-sm text-gray-900 font-medium">{{ number_format($reservation->devis->getTotalAmountAttribute(), 2, ',', ' ') }} €</div>
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>

                                <!-- Paiement -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($reservation->devis && $reservation->devis->status == 'accepted')

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Payé</span>

                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </td>

                                <!-- devis -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if ($reservation->devis)
                                            <!-- Voir devis -->
                                            <a href="{{ route('devis.page', ['id' => $reservation->devis->id]) }}"
                                               class="text-indigo-600 hover:text-indigo-900"
                                               title="Voir le devis">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>


                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        @endif
    </div>
@endsection
