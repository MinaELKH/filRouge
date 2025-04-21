@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-medium text-gray-700">Tableau de bord</h2>
            <div class="text-sm text-gray-500">Dernière mise à jour: 11/02/2023 20:22</div>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="border rounded-lg shadow-sm">
                <div class="p-4 text-center">
                    <div class="text-gray-600 mb-2">Demande en attente</div>
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

        <!-- Other Sections -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Top Prestateur Actifs -->
            <div class="border rounded-lg shadow-sm">
                <div class="p-4">
                    <h3 class="font-medium text-gray-700 mb-4">Top Prestateur Actifs</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <div>Ines ouss</div>
                            <div class="text-gray-500">10 Offres</div>
                        </div>
                        <!-- Other Entries -->
                    </div>
                </div>
            </div>
            <!-- More Sections -->
        </div>
    </div>
@endsection
