@extends('layouts.admin')

@section('content')
    <!-- Messages de succès -->
    @if(session('success'))
        <div id="success-message" class="mt-4 p-4 bg-green-100 text-green-800 rounded-md transition-opacity duration-500">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const message = document.getElementById('success-message');
                if (message) {
                    message.classList.add('opacity-0');
                    setTimeout(() => message.remove(), 500); // retire le message après animation
                }
            }, 3000); // 3 secondes d'affichage
        </script>
    @endif

    <!--  ajout-->
    <div class="mt-6 mb-8">
        <h2 class="text-lg font-medium text-gray-700 mb-4">Catégorie</h2>
        <div class="space-y-4">
            <!-- Formulaire pour ajouter une catégorie -->
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div>
                    <p class="text-sm mb-1">Ajouter un Service</p>
                    <p class="text-xs text-gray-500 mb-2">Nom du service</p>
                    <input type="text" name="name" placeholder="Entrez le nom" class="w-full max-w-md px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <p class="text-sm mb-1">Description</p>
                    <textarea name="description" placeholder="Entrez la description" class="w-full max-w-md px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3"></textarea>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div>
        <h2 class="text-lg font-medium text-gray-700 mb-4">Liste de Catégories</h2>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">REF</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NOM</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DESCRIPTION</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $category->description ?? 'Pas de description' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 text-right flex justify-end gap-2">

                        <!-- Bouton Modifier -->
                        <button type="button" data-modal-target="modal-{{ $category->id }}" data-modal-toggle="modal-{{ $category->id }}" class="text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L5 21l1.414-4.586L15 9z" />
                            </svg>
                        </button>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M10 11V17M14 11V17M5 7L6 19a2 2 0 002 2h8a2 2 0 002-2L19 7M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Modifier -->
                <div id="modal-{{ $category->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[100vh] bg-black/30 backdrop-blur-sm">
                    <div class="relative w-full max-w-md mx-auto mt-24 bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Modifier Catégorie</h3>
                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Nom</label>
                                <input type="text" name="name" value="{{ $category->name }}" class="w-full border rounded-md px-3 py-2 mt-1">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Description</label>
                                <textarea name="description" class="w-full border rounded-md px-3 py-2 mt-1">{{ $category->description }}</textarea>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-hide="modal-{{ $category->id }}" class="px-4 py-2 bg-gray-300 rounded-md">Annuler</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>



    <!-- JS pour activer/fermer les modales -->
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.getAttribute('data-modal-target'));
                target.classList.remove('hidden');
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
            btn.addEventListener('click', () => {
                const target = document.getElementById(btn.getAttribute('data-modal-hide'));
                target.classList.add('hidden');
            });
        });
    </script>
@endsection
