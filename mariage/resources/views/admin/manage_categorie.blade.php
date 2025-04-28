@extends('layouts.admin')

@section('content')
    <!-- Messages de succès avec animation de disparition -->
    @if(session('success'))
        <div id="success-message" class="mt-4 p-4 bg-green-100 text-green-800 rounded-md transition-opacity duration-500">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const message = document.getElementById('success-message');
                if (message) {
                    message.classList.add('opacity-0');
                    setTimeout(() => message.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <!-- Conteneur Catégorie -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-8">
        <h2 class="text-xl font-medium text-gray-800 mb-6">Catégorie</h2>

        <!-- Formulaire pour ajouter une catégorie -->
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <p class="text-base font-medium text-gray-700 mb-1">Ajouter un Service</p>
                <p class="text-sm text-gray-500 mb-2">Nom du service</p>
                <input type="text" name="name" placeholder="Entrez le nom"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-6">
                <p class="text-base font-medium text-gray-700 mb-1">Description</p>
                <textarea name="description" placeholder="Entrez la description"
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                          rows="4"></textarea>
            </div>

            <div>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md focus:outline-none">
                    Ajouter
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des catégories -->
    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-xl font-medium text-gray-800 mb-6">Liste de Catégories</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RÉF</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NOM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DESCRIPTION</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($categories as $category)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $category->id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $category->description ?? 'Explorez vos passions...' }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end">
                                <!-- Bouton Supprimer avec poubelle rouge -->
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-7 7-7-7" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Modifier caché par défaut -->
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
                                    <textarea name="description" class="w-full border rounded-md px-3 py-2 mt-1" rows="3">{{ $category->description }}</textarea>
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
