@extends('layouts.main')

@section('title', 'Tâches de mariage')
@section('breadcrumb', 'Tâches')

@section('content')
    <div class="flex">
        <!-- Sidebar des filtres -->
        <div class="w-64 bg-white shadow-md rounded-lg mr-6 h-fit sticky top-24">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-bold text-sm text-gray-700 uppercase">Filtres</h3>
            </div>

            <!-- Filtres par statut -->
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-bold text-sm text-gray-700 mb-3">Statut</h3>

                <div class="space-y-2">
                    <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <label class="flex items-center cursor-pointer w-full">
                            <input type="radio" name="status-filter" value="all" class="mr-2 text-wedding-pink focus:ring-wedding-pink" checked>
                            <span class="text-sm text-gray-700">Toutes les tâches</span>
                        </label>
                        <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">{{ $tasks->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <label class="flex items-center cursor-pointer w-full">
                            <input type="radio" name="status-filter" value="pending" class="mr-2 text-wedding-pink focus:ring-wedding-pink">
                            <span class="text-sm text-gray-700">À faire</span>
                        </label>
                        <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">{{ $tasks->where('status', '!=', 'completed')->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <label class="flex items-center cursor-pointer w-full">
                            <input type="radio" name="status-filter" value="completed" class="mr-2 text-wedding-pink focus:ring-wedding-pink">
                            <span class="text-sm text-gray-700">Terminées</span>
                        </label>
                        <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">{{ $tasks->where('status', 'completed')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Filtres par catégorie -->
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-bold text-sm text-gray-700 mb-3">Catégories</h3>

                <div class="space-y-2 max-h-48 overflow-y-auto">
                    <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-1 rounded">
                        <label class="flex items-center cursor-pointer w-full">
                            <input type="checkbox" name="category-filter[]" value="all" class="mr-2 rounded text-wedding-pink focus:ring-wedding-pink" checked>
                            <span class="text-sm text-gray-700">Toutes les catégories</span>
                        </label>
                    </div>

                    @foreach($categories as $category)
                        <div class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-1 rounded">
                            <label class="flex items-center cursor-pointer w-full">
                                <input type="checkbox" name="category-filter[]" value="{{ $category->name }}" class="mr-2 rounded text-wedding-pink focus:ring-wedding-pink">
                                <span class="text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                            <span class="text-xs text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">
                                {{ $tasks->where('category', $category->name)->count() }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Filtres par budget -->
            <div class="p-4">
                <h3 class="font-bold text-sm text-gray-700 mb-3">Budget</h3>

                <div class="space-y-2">
                    <label class="text-xs text-gray-600">Budget minimum</label>
                    <input type="range" id="min-budget" min="0" max="10000" step="500" value="0"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between">
                        <span class="text-xs text-gray-500">0 €</span>
                        <span id="min-budget-value" class="text-xs font-medium text-wedding-pink">0 €</span>
                    </div>

                    <label class="text-xs text-gray-600 mt-4 block">Budget maximum</label>
                    <input type="range" id="max-budget" min="0" max="10000" step="500" value="10000"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between">
                        <span id="max-budget-value" class="text-xs font-medium text-wedding-pink">10000 €</span>
                        <span class="text-xs text-gray-500">10000 €</span>
                    </div>

                    <button id="apply-budget-filter" class="w-full mt-4 bg-wedding-pink text-white py-2 px-4 rounded-md text-sm hover:bg-pink-600 transition-colors">
                        Appliquer
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-wedding-dark">Planning</h1>
                <button id="addTaskBtn" class="bg-wedding-pink hover:bg-pink-600 text-white py-2 px-4 rounded-md flex items-center">
                    <i class="fas fa-plus mr-2"></i> Ajouter une tâche
                </button>
            </div>

            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="searchTask" placeholder="Rechercher une tâche..." class="w-full border border-gray-300 rounded-md py-2 px-4 pl-10">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm" id="tasks-container">
                <ul class="divide-y divide-gray-200">
                    @foreach($tasks as $task)
                        <li class="task-item px-4 py-3 flex items-center justify-between"
                            data-status="{{ $task->status }}"
                            data-category="{{ $task->category }}"
                            data-budget="{{ $task->budget ?? 0 }}">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    @if($task->status === 'completed')
                                        <button onclick="markAsPending({{ $task->id }})" class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    @else
                                        <button onclick="markAsCompleted({{ $task->id }})" class="w-6 h-6 rounded-full border-2 border-gray-300 hover:border-wedding-pink"></button>
                                    @endif
                                </div>
                                <div>
                                    <span class="{{ $task->status === 'completed' ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </span>
                                    @if($task->reference_number)
                                        <span class="ml-3 text-sm text-gray-500">{{ $task->reference_number }}</span>
                                    @endif
                                    @if($task->budget)
                                        <span class="ml-3 text-sm text-wedding-pink">{{ $task->budget }} €</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center">
                                <a href="{{ route('client.tasks.edit', $task->id) }}" class="text-gray-400 hover:text-wedding-pink mr-4">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('client.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach

                    @if(count($tasks) === 0)
                        <li class="px-4 py-6 text-center text-gray-500">
                            Aucune tâche pour le moment. Commencez à planifier votre mariage en ajoutant des tâches!
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter une tâche (reste inchangé) -->
    <div id="taskModal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <!-- Contenu du modal (inchangé) -->
    </div>

    <!-- Formulaires pour changer le statut (inchangés) -->
    <form id="completeForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <form id="pendingForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <script>
        // Script existant pour le modal et la recherche (inchangé)

        // Gestion des filtres
        document.addEventListener('DOMContentLoaded', function() {
            // Filtres par statut
            const statusFilters = document.querySelectorAll('input[name="status-filter"]');
            statusFilters.forEach(filter => {
                filter.addEventListener('change', applyFilters);
            });

            // Filtres par catégorie
            const categoryFilters = document.querySelectorAll('input[name="category-filter[]"]');
            const allCategoriesCheckbox = document.querySelector('input[value="all"]');

            allCategoriesCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                categoryFilters.forEach(filter => {
                    if (filter.value !== 'all') {
                        filter.checked = false;
                        filter.disabled = isChecked;
                    }
                });
                applyFilters();
            });

            categoryFilters.forEach(filter => {
                if (filter.value !== 'all') {
                    filter.addEventListener('change', function() {
                        const someChecked = Array.from(categoryFilters).some(f => f.value !== 'all' && f.checked);
                        allCategoriesCheckbox.checked = !someChecked;
                        applyFilters();
                    });
                }
            });

            // Budget range slider
            const minBudgetSlider = document.getElementById('min-budget');
            const maxBudgetSlider = document.getElementById('max-budget');
            const minBudgetValue = document.getElementById('min-budget-value');
            const maxBudgetValue = document.getElementById('max-budget-value');

            minBudgetSlider.addEventListener('input', function() {
                minBudgetValue.textContent = this.value + ' €';
                if (parseInt(maxBudgetSlider.value) < parseInt(this.value)) {
                    maxBudgetSlider.value = this.value;
                    maxBudgetValue.textContent = this.value + ' €';
                }
            });

            maxBudgetSlider.addEventListener('input', function() {
                maxBudgetValue.textContent = this.value + ' €';
                if (parseInt(minBudgetSlider.value) > parseInt(this.value)) {
                    minBudgetSlider.value = this.value;
                    minBudgetValue.textContent = this.value + ' €';
                }
            });

            document.getElementById('apply-budget-filter').addEventListener('click', applyFilters);

            // Fonction pour appliquer tous les filtres
            function applyFilters() {
                const taskItems = document.querySelectorAll('.task-item');
                const statusFilter = document.querySelector('input[name="status-filter"]:checked').value;
                const categoryFilters = Array.from(document.querySelectorAll('input[name="category-filter[]"]:checked:not(:disabled)'))
                    .map(filter => filter.value);
                const minBudget = parseInt(minBudgetSlider.value);
                const maxBudget = parseInt(maxBudgetSlider.value);

                taskItems.forEach(item => {
                    const taskStatus = item.getAttribute('data-status');
                    const taskCategory = item.getAttribute('data-category');
                    const taskBudget = parseInt(item.getAttribute('data-budget') || 0);

                    // Filtrage par statut
                    const statusMatch = statusFilter === 'all' ||
                        (statusFilter === 'completed' && taskStatus === 'completed') ||
                        (statusFilter === 'pending' && taskStatus !== 'completed');

                    // Filtrage par catégorie
                    const categoryMatch = categoryFilters.includes('all') || categoryFilters.includes(taskCategory);

                    // Filtrage par budget
                    const budgetMatch = taskBudget >= minBudget && taskBudget <= maxBudget;

                    // Appliquer tous les filtres
                    if (statusMatch && categoryMatch && budgetMatch) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Afficher un message si aucune tâche ne correspond aux filtres
                const hasVisibleTasks = Array.from(taskItems).some(item => item.style.display !== 'none');
                const noTasksMessage = document.querySelector('#tasks-container .no-tasks-message');

                if (!hasVisibleTasks && taskItems.length > 0) {
                    if (!noTasksMessage) {
                        const message = document.createElement('li');
                        message.className = 'no-tasks-message px-4 py-6 text-center text-gray-500';
                        message.textContent = 'Aucune tâche ne correspond à vos filtres.';
                        document.querySelector('#tasks-container ul').appendChild(message);
                    }
                } else if (noTasksMessage) {
                    noTasksMessage.remove();
                }
            }
        });
    </script>
@endsection
