@extends('layouts.app')

@section('title', 'Tâches de mariage')
@section('breadcrumb', 'Tâches')

@section('content')
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

    <div class="bg-white rounded-lg shadow-sm">
        <ul class="divide-y divide-gray-200">
            @foreach($tasks as $task)
                <li class="px-4 py-3 flex items-center justify-between">
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

    <!-- Modal pour ajouter une tâche -->
    <div id="taskModal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-medium">Ajouter une tâche</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('client.tasks.store') }}" method="POST">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nom de la tâche</label>
                        <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description de la tâche</label>
                        <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                <option value="">Sélectionner</option>
                                <option value="Lieu">Lieu</option>
                                <option value="Traiteur">Traiteur</option>
                                <option value="Décoration">Décoration</option>
                                <option value="Tenue">Tenue</option>
                                <option value="Beauté">Beauté</option>
                                <option value="Photo/Vidéo">Photo/Vidéo</option>
                                <option value="Musique">Musique</option>
                                <option value="Transport">Transport</option>
                                <option value="Administration">Administration</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                            <input type="text" name="budget" id="budget" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end rounded-b-lg">
                    <button type="button" id="cancelBtn" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md mr-2">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-wedding-pink hover:bg-pink-600 rounded-md">
                        Créer
                    </button>
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
        // Gestion du modal
        const modal = document.getElementById('taskModal');
        const addTaskBtn = document.getElementById('addTaskBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');

        addTaskBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Fermer la modal si on clique en dehors
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // Fonction de recherche
        const searchInput = document.getElementById('searchTask');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const taskItems = document.querySelectorAll('li');

            taskItems.forEach(item => {
                const taskText = item.textContent.toLowerCase();
                if (taskText.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Fonctions pour changer le statut des tâches
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
    </script>
@endsection
