@extends('layouts.app')

@section('content')
    <h1>Modifier le Service</h1>

    <form action="{{ route('service.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" required>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description">{{ old('description', $service->description) }}</textarea>
        </div>

        <div>
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" value="{{ old('price', $service->price) }}" required>
        </div>

        <div>
            <label for="cover_image">Image de couverture</label>
            <input type="text" name="cover_image" id="cover_image" value="{{ old('cover_image', $service->cover_image) }}" required>
        </div>

        <div>
            <label for="category_id">Catégorie</label>
            <select name="category_id" id="category_id" required>
                <!-- Liste des catégories -->
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $service->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ville_id">Ville</label>
            <select name="ville_id" id="ville_id" required>
                <!-- Liste des villes -->
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" {{ $ville->id == $service->ville_id ? 'selected' : '' }}>
                        {{ $ville->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit">Mettre à jour</button>
        </div>
    </form>
@endsection
