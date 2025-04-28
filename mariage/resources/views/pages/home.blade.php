@extends('layouts.app')

@section('title', 'Mariages.net - Accueil')

@section('content')

    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                Choisissez-vous les meilleur prestataires
            </h2>
            <p class="text-gray-600 mb-8">
                Commencez à planifier votre mariage avec nous, c'est gratuit !
            </p>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ url('/categories/' . $category->id . '/services') }}" class="block">
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="relative h-48">
                                <img
                                    src="{{ $category->image ? asset('images/categories/' . $category->image) : 'https://placehold.co/400x300' }}"
                                    alt="{{ $category->name }}"
                                    class="absolute inset-0 w-full h-full object-cover"
                                />
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium mb-1">{{ ucfirst($category->name) }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $category->services_count }} {{ Str::plural('prestataire', $category->services_count) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>


            <div class="flex justify-center mt-10">
                <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Plus de prestation
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

@endsection
