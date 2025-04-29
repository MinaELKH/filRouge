@extends('layouts.main')

@section('title', 'Tâches de mariage')
@section('breadcrumb', 'Tâches')

@section('content')
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar des filtres - responsive sur mobile -->
        <div class="lg:w-64 w-full bg-white shadow-md rounded-lg lg:mr-6 h-fit lg:sticky lg:top-24">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="font-bold text-sm text-gray-700 uppercase">Filtres</h3>
                <!-- Bouton pour afficher/masquer les filtres sur mobile -->
                <button class="lg:hidden text-wedding-pink" id="toggleFilters">
                    <i class="fas fa-chevron-down" id="filterIcon"></i>
                </button>
            </div>

            <div id="filtersContainer" class="lg:block">
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

                    <div class="space-y-2 max-h-36 lg:max-h-48 overflow-y-auto">
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
        </div>

        <!-- Contenu principal -->
        <div class="flex-1">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                <h1 class="text-xl sm:text-2xl font-semibold text-wedding-dark">Planning</h1>
                <button id="addTaskBtn" class="bg-wedding-pink hover:bg-pink-600 text-white py-2 px-4 rounded-md flex items-center justify-center sm:justify-start">
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
                        <li class="task-item px-3 sm:px-4 py-3 flex flex-wrap sm:flex-nowrap items-center justify-between"
                            data-status="{{ $task->status }}"
                            data-category="{{ $task->category }}"
                            data-budget="{{ $task->budget ?? 0 }}">
                            <div class="flex items-center w-full sm:w-auto">
                                <div class="mr-3">
                                    @if($task->status === 'completed')
                                        <button onclick="markAsPending({{ $task->id }})" class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    @else
                                        <button onclick="markAsCompleted({{ $task->id }})" class="w-6 h-6 rounded-full border-2 border-gray-300 hover:border-wedding-pink"></button>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <span class="{{ $task->status === 'completed' ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </span>
                                    <div class="flex flex-wrap text-sm mt-1 sm:mt-0">
                                        @if($task->reference_number)
                                            <span class="mr-3 text-gray-500">{{ $task->reference_number }}</span>
                                        @endif
                                        @if($task->budget)
                                            <span class="text-wedding-pink">{{ $task->budget }} €</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center mt-2 sm:mt-0 ml-auto sm:ml-0">
                                <a href="{{ route('client.tasks.edit', $task->id) }}" class="text-gray-400 hover:text-wedding-pink mr-4 p-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('client.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 p-1">
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

    <!-- Modal pour ajouter une tâche -->
    <div id="taskModal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg max-w-md w-full mx-3 sm:mx-0 p-6 relative">
            <button type="button" class="close-modal absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter une tâche</h3>

            <form method="POST" action="{{ route('client.tasks.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre de la tâche</label>
                        <input type="text" name="title" id="title" required
                               class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent">
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="category" id="category"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget (€)</label>
                        <input type="number" name="budget" id="budget" min="0" step="50"
                               class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent">
                    </div>

                    <div>
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro de référence</label>
                        <input type="text" name="reference_number" id="reference_number"
                               class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent">
                    </div>

                    <div>


                    <div class="pt-3">
                        <button type="submit" class="w-full bg-wedding-pink hover:bg-pink-600 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            Ajouter la tâche
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Formulaires pour changer le statut -->
    <form id="completeForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <form id="pendingForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <script>
        // Fonctions pour marquer les tâches comme complètes ou en attente
        function markAsCompleted(taskId) {
            const form = document.getElementById('completeForm');
            form.action = `/client/tasks/${taskId}/complete`;
            form.submit();
        }

        function markAsPending(taskId) {
            const form = document.getElementById('pendingForm');
            form.action = `/client/tasks/${taskId}/pending`;
            form.submit();
        }

        // Gestion de la recherche
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchTask');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase().trim();
                    const taskItems = document.querySelectorAll('.task-item');

                    taskItems.forEach(item => {
                        const taskTitle = item.querySelector('span').textContent.toLowerCase();
                        if (taskTitle.includes(searchValue)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Afficher un message si aucune tâche ne correspond à la recherche
                    const hasVisibleTasks = Array.from(taskItems).some(item => item.style.display !== 'none');
                    const noTasksMessage = document.querySelector('#tasks-container .no-tasks-message');

                    if (!hasVisibleTasks && taskItems.length > 0) {
                        if (!noTasksMessage) {
                            const message = document.createElement('li');
                            message.className = 'no-tasks-message px-4 py-6 text-center text-gray-500';
                            message.textContent = 'Aucune tâche ne correspond à votre recherche.';
                            document.querySelector('#tasks-container ul').appendChild(message);
                        }
                    } else if (noTasksMessage) {
                        noTasksMessage.remove();
                    }
                });
            }

            // Toggle pour les filtres sur mobile
            const toggleFilters = document.getElementById('toggleFilters');
            const filtersContainer = document.getElementById('filtersContainer');
            const filterIcon = document.getElementById('filterIcon');

            if (toggleFilters) {
                toggleFilters.addEventListener('click', function() {
                    if (filtersContainer.classList.contains('hidden')) {
                        filtersContainer.classList.remove('hidden');
                        filterIcon.classList.remove('fa-chevron-down');
                        filterIcon.classList.add('fa-chevron-up');
                    } else {
                        filtersContainer.classList.add('hidden');
                        filterIcon.classList.remove('fa-chevron-up');
                        filterIcon.classList.add('fa-chevron-down');
                    }
                });
            }

            // Cacher les filtres par défaut sur mobile
            if (window.innerWidth < 1024) {
                filtersContainer.classList.add('hidden');
            }

            // Ajuster la visibilité des filtres lors du redimensionnement
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    filtersContainer.classList.remove('hidden');
                } else if (!filtersContainer.classList.contains('hidden') && !toggleFilters.classList.contains('active')) {
                    filtersContainer.classList.add('hidden');
                }
            });

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

            // Gestion du modal pour ajouter une tâche
            const addTaskBtn = document.getElementById('addTaskBtn');
            const taskModal = document.getElementById('taskModal');

            if (addTaskBtn && taskModal) {
                // Ouvrir le modal lorsqu'on clique sur le bouton "Ajouter une tâche"
                addTaskBtn.addEventListener('click', function() {
                    taskModal.classList.remove('hidden');
                });

                // Fermer le modal lorsqu'on clique en dehors du contenu du modal
                taskModal.addEventListener('click', function(event) {
                    if (event.target === taskModal) {
                        taskModal.classList.add('hidden');
                    }
                });

                // Ajouter un bouton de fermeture dans le modal
                const closeButtons = taskModal.querySelectorAll('.close-modal');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        taskModal.classList.add('hidden');
                    });
                });
            }

            // Fermer le modal avec la touche Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && taskModal && !taskModal.classList.contains('hidden')) {
                    taskModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
