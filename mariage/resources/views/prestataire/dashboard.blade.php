@extends('layouts.main')

@section('title', 'Statistiques Prestataire')

@section('breadcrumb', 'Statistiques')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-pro-gray mb-6 flex items-center">
            <i class="fas fa-chart-line text-pro-blue mr-3"></i>Tableau de bord statistique
        </h1>

        <!-- Cartes de résumé -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Services -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-concierge-bell text-pro-blue text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Services</p>
                        <p class="text-xl font-bold text-pro-gray">
                            {{ $stats['services_by_category']->sum('nbservice') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Réservations -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Réservations</p>
                        <p class="text-xl font-bold text-pro-gray">
                            {{ $stats['reservations_by_status']->sum('nbreservation') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Devis -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 mr-4">
                        <i class="fas fa-file-invoice-dollar text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Devis</p>
                        <p class="text-xl font-bold text-pro-gray">
                            {{ $stats['devis_by_status']->sum('nbdevis') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Revenu Total -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Revenu Estimé</p>
                        <p class="text-xl font-bold text-pro-gray">
                            {{ number_format($stats['revenu_par_devis']->sum('revenuestime'), 2) }} MAD
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques détaillées -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Services par catégorie -->
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-pro-gray mb-4 flex items-center">
                    <i class="fas fa-tags text-pro-blue mr-2"></i>Services par catégorie
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catégorie
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stats['services_by_category'] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->categorie }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $item->nbservice }}
                                        </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Réservations par statut -->
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-pro-gray mb-4 flex items-center">
                    <i class="fas fa-clipboard-list text-pro-blue mr-2"></i>Réservations par statut
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stats['reservations_by_status'] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ucfirst($item->status) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        <span class="
                                            @if($item->status == 'confirmé') bg-green-100 text-green-800
                                            @elseif($item->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($item->status == 'annulé') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                            text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $item->nbreservation }}
                                        </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Devis par statut -->
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-pro-gray mb-4 flex items-center">
                    <i class="fas fa-file-invoice text-pro-blue mr-2"></i>Devis par statut
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stats['devis_by_status'] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ucfirst($item->status) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        <span class="
                                            @if($item->status == 'accepté') bg-green-100 text-green-800
                                            @elseif($item->status == 'en attente') bg-yellow-100 text-yellow-800
                                            @elseif($item->status == 'refusé') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                            text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $item->nbdevis }}
                                        </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Revenu estimé par devis -->
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h2 class="text-lg font-bold text-pro-gray mb-4 flex items-center">
                    <i class="fas fa-money-bill-wave text-pro-blue mr-2"></i>Revenus estimés
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Devis
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stats['revenu_par_devis'] as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $item->devis_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="
                                            @if($item->status == 'accepté') bg-green-100 text-green-800
                                            @elseif($item->status == 'en attente') bg-yellow-100 text-yellow-800
                                            @elseif($item->status == 'refusé') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                            text-xs font-medium px-2.5 py-0.5 rounded">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                    {{ number_format($item->revenuestime, 2) }} MAD
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="2" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                Total
                            </td>
                            <td class="px-6 py-3 text-right text-sm font-bold text-green-600">
                                {{ number_format($stats['revenu_par_devis']->sum('revenuestime'), 2) }} MAD
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration des couleurs
            const colors = {
                blue: '#4e73df',
                green: '#1cc88a',
                red: '#e74a3b',
                yellow: '#f6c23e',
                purple: '#6f42c1',
                gray: '#858796'
            };

            // Graphique des réservations
            const reservationCtx = document.getElementById('reservationsChart').getContext('2d');
            const reservationData = @json($stats['reservations_by_status']->pluck('nbreservation', 'status'));
            const reservationLabels = Object.keys(reservationData).map(status => status.charAt(0).toUpperCase() + status.slice(1));
            const reservationValues = Object.values(reservationData);
            const reservationColors = Object.keys(reservationData).map(status => {
                if (status === 'confirmé') return colors.green;
                if (status === 'pending') return colors.yellow;
                if (status === 'annulé') return colors.red;
                return colors.gray;
            });

            new Chart(reservationCtx, {
                type: 'doughnut',
                data: {
                    labels: reservationLabels,
                    datasets: [{
                        data: reservationValues,
                        backgroundColor: reservationColors,
                        hoverBackgroundColor: reservationColors,
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    cutoutPercentage: 70
                }
            });

            // Graphique des devis
            const devisCtx = document.getElementById('devisChart').getContext('2d');
            const devisData = @json($stats['devis_by_status']->pluck('nbdevis', 'status'));
            const devisLabels = Object.keys(devisData).map(status => status.charAt(0).toUpperCase() + status.slice(1));
            const devisValues = Object.values(devisData);
            const devisColors = Object.keys(devisData).map(status => {
                if (status === 'accepté') return colors.green;
                if (status === 'en attente') return colors.yellow;
                if (status === 'refusé') return colors.red;
                return colors.gray;
            });

            new Chart(devisCtx, {
                type: 'doughnut',
                data: {
                    labels: devisLabels,
                    datasets: [{
                        data: devisValues,
                        backgroundColor: devisColors,
                        hoverBackgroundColor: devisColors,
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    cutoutPercentage: 70
                }
            });
        });
    </script>
@endpush
