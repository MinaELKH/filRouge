@extends('layout.admin')

@section('title', 'Dashboard Admin')

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
                        <div class="text-gray-600 mb-2">Demandes en attente</div>
                        <div class="text-3xl font-bold">9</div>
                    </div>
                </div>
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4 text-center">
                        <div class="text-gray-600 mb-2">Offres en attente</div>
                        <div class="text-3xl font-bold">8</div>
                    </div>
                </div>
            </div>

            <!-- Three Columns -->
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Top Prestataires Actifs -->
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-700 mb-4">Top Prestataires Actifs</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <div>Ines Ouss</div>
                                <div class="text-gray-500">10 Offres</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Evelyn Walker</div>
                                <div class="text-gray-500">4 Offres</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Benjamin Robinson</div>
                                <div class="text-gray-500">4 Offres</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Catégories -->
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-700 mb-4">Top Catégories</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <div>Negafa</div>
                                <div class="text-gray-500">5</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Make up</div>
                                <div class="text-gray-500">4</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Salle de fête</div>
                                <div class="text-gray-500">3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Offres -->
                <div class="border rounded-lg shadow-sm">
                    <div class="p-4">
                        <h3 class="font-medium text-gray-700 mb-4">Top Offres</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <div>Salle de fête de rêve</div>
                                <div class="text-gray-500">5</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Robe de Noce mode Caftan</div>
                                <div class="text-gray-500">4</div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>Les meilleurs plats</div>
                                <div class="text-gray-500">3</div>
                            </div>
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
