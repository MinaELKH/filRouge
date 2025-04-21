@extends('layouts.admin')

@section('content')
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
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">REF</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NOM</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DESCRIPTION</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $category->id }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $category->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $category->description ?? 'Pas de description' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500 text-right">
                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Messages de succès -->
@if(session('success'))
    <div class="mt-4 p-4 bg-green-100 text-green-800 rounded-md">
        {{ session('success') }}
    </div>
@endif
@endsection
