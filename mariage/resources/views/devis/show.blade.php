@extends('layouts.main')

@section('content')
    <!-- Style moderne et épuré pour devis - Version améliorée -->
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-xl my-8 border border-gray-100 relative print:shadow-none print:border-0">
            <!-- Actions rapides - Non imprimables -->
            <div class="absolute top-4 right-4 flex space-x-2 print:hidden">
                <button onclick="window.print()" class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-full transition-colors duration-200" title="Imprimer le devis">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </button>
                <a href="{{ route('devis.pdf', $devis->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-full transition-colors duration-200" title="Télécharger en PDF">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </a>
            </div>

            <!-- En-tête du devis -->
            <div class="border-b border-gray-100 pb-6 mb-8 flex justify-between items-center">
                <div>
                    <div class="flex items-center">
                        <h1 class="text-3xl font-bold text-wedding-pink">Devis   </h1>

                        <span class="ml-3 px-3 py-1 text-xs font-semibold uppercase rounded-full {{ $devis->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                            {{ $devis->status === 'pending' ? 'En attente' : 'Confirmé' }}
                        </span>
                    </div>
                    <div class="  text-xl text-wedding-pink">Réf: #{{ $devis->id }}</div>
                    <p class="text-gray-500 mt-1">Émis le {{ $devis->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="h-20 w-20">
                    <!-- Emplacement pour logo -->

                </div>
            </div>

            <!-- Informations principales -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div class="bg-wedding-pink bg-opacity-5 p-5 rounded-xl">
                    <h3 class="text-lg font-medium text-wedding-pink mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informations client
                    </h3>
                    <div class="space-y-1">
                        <p class="text-gray-700 font-medium">{{ $client->name }}</p>
                        <p class="text-gray-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $client->email }}
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Événement
                    </h3>
                    <div class="space-y-1">
                        <p class="text-gray-700">
                            <span class="font-medium">Date:</span> {{ $reservation->event_date->format('d/m/Y') }}
                        </p>
                        <p class="text-gray-700 flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $service->ville->name ?? 'Non spécifié' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-8 bg-gray-50 p-5 rounded-xl border border-gray-100">
                <h3 class="text-lg font-medium text-gray-700 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Service réservé
                </h3>
                <div class="mt-2 flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 bg-wedding-pink bg-opacity-10 rounded-full flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-700 font-medium">{{ $service->title }}</p>
                        <p class="text-gray-500 text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $service->user->name }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tableau des éléments -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-700 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Éléments du devis
                </h3>

                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full">
                        <thead>
                        <tr class="bg-wedding-pink bg-opacity-5">
                            <th class="py-3 px-4 text-left text-sm font-medium text-wedding-pink rounded-tl-lg">Service</th>
                            <th class="py-3 px-4 text-center text-sm font-medium text-wedding-pink">Quantité</th>
                            <th class="py-3 px-4 text-right text-sm font-medium text-wedding-pink">Prix unitaire</th>
                            <th class="py-3 px-4 text-right text-sm font-medium text-wedding-pink rounded-tr-lg">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($devis->devisItems as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 text-gray-700">{{ $item->service_name }}</td>
                                <td class="py-3 px-4 text-center text-gray-700">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-right text-gray-700">{{ number_format($item->unit_price, 2) }} DH</td>
                                <td class="py-3 px-4 text-right font-medium text-gray-700">{{ number_format($item->quantity * $item->unit_price, 2) }} DH</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="py-3 px-4 text-right font-medium text-gray-600">Total HT</td>
                            <td class="py-3 px-4 text-right font-medium text-gray-700">{{ number_format($devis->total_amount / 1.2, 2) }} DH</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="py-3 px-4 text-right font-medium text-gray-600">TVA (20%)</td>
                            <td class="py-3 px-4 text-right font-medium text-gray-700">{{ number_format($devis->total_amount - ($devis->total_amount / 1.2), 2) }} DH</td>
                        </tr>
                        <tr class="bg-wedding-pink bg-opacity-5">
                            <td colspan="3" class="py-3 px-4 text-right font-semibold text-wedding-pink">Total TTC</td>
                            <td class="py-3 px-4 text-right font-bold text-wedding-pink">{{ number_format($devis->total_amount, 2) }} DH</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Total et actions -->
            <div class="flex flex-col md:flex-row justify-between items-center pt-6 border-t border-gray-100">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 w-full md:w-auto mb-4 md:mb-0">
                    <p class="text-gray-500 text-sm font-medium">Conditions de paiement</p>
                    <p class="text-gray-700 text-sm">Acompte de 30% à la confirmation</p>
                    <p class="text-gray-700 text-sm">Solde dû 7 jours avant l'événement</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 print:hidden">
                    <a href="{{ route('devis.pdf', $devis->id) }}"
                       class="inline-block bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 shadow transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Télécharger le PDF
                    </a>
                    @if($devis->status === 'pending')
                        <form action="{{ route('devis.confirm', $devis->id) }}" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            <button type="submit" class="w-full bg-wedding-pink hover:bg-opacity-90 text-white py-2 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Confirmer et payer
                            </button>
                        </form>
                    @else
                        <div class="bg-green-100 text-green-700 py-2 px-6 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Devis confirmé
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pied de page -->
            <div class="mt-12 pt-6 border-t border-gray-100">
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Contact prestataire</h4>
                        <p class="text-sm text-gray-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $service->user->phone ?? '01 23 45 67 89' }}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $service->user->email ?? 'contact@mariages.net' }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Ce devis est valable 30 jours à compter de sa date d'émission.</p>
                        <p class="text-xs text-gray-400 mt-1">Tous les prix sont en euros et TTC.</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Merci de nous avoir choisis pour votre jour spécial!</p>
                        <p class="text-sm text-wedding-pink font-medium mt-1">mariages.net</p>
                    </div>
                </div>
            </div>

            <!-- Référence du document - Pour impression -->
            <div class="mt-8 text-xs text-gray-400 text-center">
                Devis #{{ $devis->id }} | Généré le {{ now()->format('d/m/Y') }} | mariages.net
            </div>
        </div>
    </div>

    <style type="text/css" media="print">
        @page {
            size: A4;
            margin: 10mm;
        }
        body {
            background-color: white;
        }
    </style>
@endsection
