@extends('layouts.prestataire')

@section('content')
    <!-- Ce design est à intégrer à votre page blade existante -->
    <div class=" min-h-screen">
        <div class="max-w-4xl mx-auto p-8 bg-white shadow-xl rounded-lg my-8">
            <!-- En-tête du devis -->
            <div class="border-b border-gray-200 pb-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-serif text-gray-800">Devis #{{ $devis->id }}</h1>
                        <p class="text-gray-500 italic mt-1">{{ $devis->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="h-20 w-20">
                        <!-- Emplacement pour logo -->
                        <div class="bg-rose-100 h-full w-full rounded-full flex items-center justify-center">
                            <span class="text-rose-500 font-serif text-xl">LOGO</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations principales -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="bg-rose-50 p-5 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Client
                    </h3>
                    <p class="text-gray-600">{{ $client->name }}</p>
                    <p class="text-gray-600">{{ $client->email }}</p>
                </div>

                <div class="bg-blue-50 p-5 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Date de l'événement
                    </h3>
                    <p class="text-gray-600">{{ $reservation->event_date->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="mb-8 bg-slate-50 p-5 rounded-lg">
                <h3 class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Service réservé
                </h3>
                <p class="text-gray-600">{{ $service->title }}</p>
                <p class="text-gray-500 text-sm italic">par {{ $service->user->name }}</p>
            </div>

            <!-- Tableau des éléments -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Éléments du devis
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 rounded-tl-lg">Service</th>
                            <th class="py-3 px-4 text-center text-sm font-semibold text-gray-700">Quantité</th>
                            <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Prix unitaire</th>
                            <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700 rounded-tr-lg">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($devis->devisItems as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-4 text-gray-700">{{ $item->service_name }}</td>
                                <td class="py-3 px-4 text-center text-gray-700">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-right text-gray-700">{{ number_format($item->unit_price, 2) }} €</td>
                                <td class="py-3 px-4 text-right font-medium text-gray-700">{{ number_format($item->quantity * $item->unit_price, 2) }} €</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total et actions -->
            <div class="flex flex-col md:flex-row justify-between items-center pt-6 border-t border-gray-200">
                <div class="text-right mb-4 md:mb-0">
                    <p class="text-gray-500 text-sm">Total TTC</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($devis->total_amount, 2) }} €</p>
                </div>
                <a href="{{ route('devis.pdf', $devis->id) }}"
                   class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                    📄 Télécharger le PDF
                </a>
                @if($devis->status === 'pending')
                    <form action="{{ route('devis.confirm', $devis->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white py-3 px-6 rounded-lg transition-colors duration-200 flex items-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Confirmer et passer au paiement
                        </button>
                    </form>
                @else
                    <div class="bg-green-100 text-green-700 py-3 px-6 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Devis déjà confirmé
                    </div>
                @endif
            </div>

            <!-- Pied de page -->
            <div class="mt-12 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
                <p>Ce devis est valable 30 jours à compter de sa date d'émission.</p>
                <p class="mt-2">Merci de nous avoir choisis pour votre jour spécial!</p>
            </div>
        </div>
    </div>
@endsection
