@extends('layouts.main')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Ajouter un Service</h1>

    <form action="{{ route('service.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Prix (€)</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
        </div>

        <div>
            <label for="cover_image" class="block text-sm font-medium text-gray-700">Image de couverture (URL)</label>
            <input type="text" name="cover_image" id="cover_image" value="{{ old('cover_image') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
            <select name="category_id" id="category_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ville_id" class="block text-sm font-medium text-gray-700">Ville</label>
            <select name="ville_id" id="ville_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" required>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" {{ old('ville_id') == $ville->id ? 'selected' : '' }}>
                        {{ $ville->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-white hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Ajouter
            </button>
        </div>
    </form>
@endsection
