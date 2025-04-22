@extends('layouts.prestataire')

@section('content')

    <h1>Mes Services</h1>

    @foreach($services as $service)

        <div class="service-item">
            <h2>{{ $service->title }}</h2>
            <p>{{ $service->description }}</p>
            <p>Catégorie: {{ $service->category->name }}</p>
            <p>Ville: {{ $service->ville->name }}</p>
            <p>Prix: {{ $service->price }} €</p>

            <div class="actions">
                <!-- Bouton Modifier -->
                <a href="{{ route('edite_service', $service->id) }}" class="btn btn-primary">Modifier</a>


                <!-- Bouton Archiver -->
                @if($service->status != 'archived')

                @else
                    <p class="text-gray-500">Service archivé</p>
                @endif
            </div>
        </div>

    @endforeach

@endsection
