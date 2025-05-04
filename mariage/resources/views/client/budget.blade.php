@extends('layouts.main')

@section('title', 'Mon Budget')
@section('breadcrumb', 'Budget')

@section('content')
    <div class="max-w-full">
        <!-- En-tête avec résumé du budget -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-wedding-dark">Budget de mariage</h1>

            <button id="updateBudgetBtn" class="bg-wedding-pink hover:bg-pink-600 text-white py-2 px-4 rounded-md flex items-center justify-center">
                <i class="fas fa-edit mr-2"></i> Modifier le budget
            </button>
        </div>

        <!-- Résumé du budget -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex flex-col">
                    <h3 class="text-gray-500 text-sm font-medium">Budget total</h3>
                    <div class="text-2xl font-bold text-wedding-dark">{{ number_format($profil->budget ?? 0, 2, ',', ' ') }} €</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex flex-col">
                    <h3 class="text-gray-500 text-sm font-medium">Dépensé</h3>
                    <div class="text-2xl font-bold text-wedding-dark">{{ number_format($totalSpent ?? 0, 2, ',', ' ') }} €</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="flex flex-col">
                    <h3 class="text-gray-500 text-sm font-medium">Restant</h3>
                    <div class="text-2xl font-bold {{ $budgetRemaining > 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ number_format($budgetRemaining ?? 0, 2, ',', ' ') }} €
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des dépenses par service -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Dépenses par service</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Service
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pourcentage du budget
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Réservation
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($serviceExpenses as $expense)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $expense->service_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($expense->total_spent, 2, ',', ' ') }} €</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($profil->budget > 0)
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-900 mr-2">
                                            {{ number_format(($expense->total_spent / $profil->budget) * 100, 1) }}%
                                        </div>
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-wedding-pink h-2 rounded-full" style="width: {{ min(100, ($expense->total_spent / $profil->budget) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">Aucun budget défini</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('client.devis', $expense->reservation_id) }}" class="text-wedding-pink hover:text-pink-600">
                                    <i class="fas fa-eye mr-1"></i> Détails
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucune dépense enregistrée
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    @if(count($serviceExpenses) > 0)
                        <tfoot class="bg-gray-50">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                Total
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                {{ number_format($totalSpent, 2, ',', ' ') }} €
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($profil->budget > 0)
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900 mr-2">
                                            {{ number_format(($totalSpent / $profil->budget) * 100, 1) }}%
                                        </div>
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="{{ ($totalSpent > $profil->budget) ? 'bg-red-500' : 'bg-wedding-pink' }} h-2 rounded-full"
                                                 style="width: {{ min(100, ($totalSpent / $profil->budget) * 100) }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Modal pour modifier le budget -->
    <div id="budgetModal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg max-w-md w-full mx-4 p-6 relative">
            <button type="button" class="close-modal absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Modifier votre budget</h3>

            <form method="POST" action="{{ route('client.budget.update') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget total (€)</label>
                        <input type="number" name="budget" id="budget" min="0" step="100" value="{{ $profil->budget ?? 0 }}"
                               class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Entrez le montant total que vous souhaitez consacrer à votre mariage.</p>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full bg-wedding-pink hover:bg-pink-600 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du modal pour modifier le budget
            const updateBudgetBtn = document.getElementById('updateBudgetBtn');
            const budgetModal = document.getElementById('budgetModal');

            if (updateBudgetBtn && budgetModal) {
                updateBudgetBtn.addEventListener('click', function() {
                    budgetModal.classList.remove('hidden');
                });

                // Fermer le modal lorsqu'on clique en dehors du contenu du modal
                budgetModal.addEventListener('click', function(event) {
                    if (event.target === budgetModal) {
                        budgetModal.classList.add('hidden');
                    }
                });

                // Ajouter un bouton de fermeture dans le modal
                const closeButtons = budgetModal.querySelectorAll('.close-modal');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        budgetModal.classList.add('hidden');
                    });
                });

                // Fermer le modal avec la touche Escape
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape' && budgetModal && !budgetModal.classList.contains('hidden')) {
                        budgetModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endsection
