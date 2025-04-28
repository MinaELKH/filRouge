@extends('layouts.main')

@section('title', 'Modifier la tâche')
@section('breadcrumb', 'Modifier la tâche')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-wedding-dark">Modifier la tâche</h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('client.tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nom de la tâche</label>
                <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $task->title }}" required>
                @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description de la tâche</label>
                <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2">{{ $task->description }}</textarea>
                @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ $category->name == $task->$category ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        <option value="Autre" {{ $task->category === 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('category')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                    <input type="text" name="budget" id="budget" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $task->budget }}">
                    @error('budget')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro de référence</label>
                <input type="text" name="reference_number" id="reference_number" class="w-full border border-gray-300 rounded-md px-3 py-2" value="{{ $task->reference_number }}">
                @error('reference_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="radio" name="status" id="status_pending" value="pending" {{ $task->status === 'pending' ? 'checked' : '' }} class="h-4 w-4 text-wedding-pink focus:ring-wedding-pink border-gray-300">
                        <label for="status_pending" class="ml-2 text-sm text-gray-700">En attente</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="status" id="status_completed" value="completed" {{ $task->status === 'completed' ? 'checked' : '' }} class="h-4 w-4 text-wedding-pink focus:ring-wedding-pink border-gray-300">
                        <label for="status_completed" class="ml-2 text-sm text-gray-700">Terminée</label>
                    </div>
                </div>
                @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('client.tasks') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-wedding-pink hover:bg-pink-600 rounded-md">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection
