@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <!-- Logo and User -->
        <div class="bg-white rounded-lg p-4 mb-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="fas fa-heart text-wedding-primary"></i>
                <span class="text-xl font-serif italic">mariages</span>
            </div>
            <div class="h-8 w-8 rounded-full bg-gray-300 overflow-hidden">
                <img src="https://randomuser.me/api/portraits/thumb/men/75.jpg" alt="User" class="h-full w-full object-cover">
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="bg-white rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-medium text-gray-700">Tableau de bord</h2>
                <div class="text-sm text-gray-500 last-update-time">Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}</div>
            </div>

            <!-- Stats Cards -->
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4 text-center">
                        <div class="text-gray-600 mb-2">Nombre de Clients</div>
                        <div class="text-3xl font-bold">{{ $totalClients }}</div>
                    </div>
                </div>
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4 text-center">
                        <div class="text-gray-600 mb-2">Nombre de Prestataires</div>
                        <div class="text-3xl font-bold">{{ $totalPrestataires }}</div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards for Pending Reservations and Offers -->
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4 text-center">
                        <div class="text-gray-600 mb-2">Demandes en attente</div>
                        <div class="text-3xl font-bold">{{ $pendingReservations }}</div>
                    </div>
                </div>
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4 text-center">
                        <div class="text-gray-600 mb-2">Offres en attente</div>
                        <div class="text-3xl font-bold">{{ $pendingOffers }}</div>
                    </div>
                </div>
            </div>

            <!-- Three Columns for Top Prestataires, Categories, and Services -->
            <div class="grid md:grid-cols-3 gap-6">

                <!-- Top Prestataires Actifs -->
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-700 mb-4">Top Prestataires Actifs</h3>
                        <div class="space-y-3">
                            @foreach ($topPrestataires as $prestataire)
                                <div class="flex justify-between items-center">
                                    <div>{{ $prestataire->name }}</div>
                                    <div class="text-gray-500">{{ $prestataire->services_count }} Services</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                <!-- Top Catégories -->
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-700 mb-4">Top Catégories</h3>
                        <div class="space-y-3">
                            @foreach ($topCategories as $category)
                                <div class="flex justify-between items-center">
                                    <div>{{ $category->category_name }}</div>
                                    <div class="text-gray-500">{{ $category->total }} Offres</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Top Services -->
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-700 mb-4">Top Offres</h3>
                        <div class="space-y-3">
                            @foreach ($topServices as $service)
                                <div class="flex justify-between items-center">
                                    <div>{{ $service->title }}</div>
                                    <div class="text-gray-500">{{ $service->reservations_count }} Réservations</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("Dashboard loaded");
        });
    </script>
@endsection
