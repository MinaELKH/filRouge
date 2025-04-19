@extends('layouts.prestataire')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800">Bienvenue dans votre espace prestataire</h1>

    <main class="container mx-auto px-4 py-8">
        <!-- Business Information Section -->
        <section class="mb-12">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Informations entreprise</h1>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Company Card -->
                <div class="w-full md:w-1/4">
                    <div class="bg-gray-400 p-8 flex items-center justify-center">
                        <h2 class="text-white font-bold">FARHATKOM</h2>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm text-gray-800">Voir ma vitrine</a>
                    </div>
                </div>

                <!-- Information Form -->
                <div class="w-full md:w-3/4">
                    <div class="mb-8">
                        <div class="flex items-start gap-4">
                            <div class="bg-gray-100 p-3 rounded-md">
                                <i class="fas fa-file-alt text-gray-500"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Ajoutez les informations générales sur votre entreprise</h3>
                                <p class="text-sm text-gray-600">Cette section réunit toutes vos informations. Vous pouvez les modifier à tout moment. N'oubliez pas de les tenir à jour.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Access Codes -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Codes d'accès</h3>
                        <div class="mb-4">
                            <label class="block text-xs uppercase text-gray-600 mb-1">Identifiant</label>
                            <p class="text-sm">yosooo6</p>
                        </div>
                    </div>

                    <!-- Business Description -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Décrivez votre entreprise</h3>
                        <div class="border border-gray-300 rounded-md">
                            <div class="flex border-b border-gray-300 p-2">
                                <button class="editor-button mr-1">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button class="editor-button mr-1">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button class="editor-button mr-1">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <button class="editor-button mr-1">
                                    <i class="fas fa-list-ol"></i>
                                </button>
                                <button class="editor-button mr-1">
                                    <i class="fas fa-outdent"></i>
                                </button>
                                <button class="editor-button">
                                    <i class="fas fa-indent"></i>
                                </button>
                            </div>
                            <div class="p-4 min-h-[200px]">
                                <!-- Editor content area -->
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Vos coordonnées</h3>

                        <div class="mb-4">
                            <label class="block text-xs uppercase text-gray-600 mb-1">Personne à contacter</label>
                            <input type="text" value="mina" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs uppercase text-gray-600 mb-1">E-mail</label>
                            <input type="email" value="mina@gmail.com" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs uppercase text-gray-600 mb-1">Téléphone</label>
                            <div class="flex gap-2">
                                <select class="border border-gray-300 rounded-md p-2 text-sm">
                                    <option>Autre</option>
                                </select>
                                <input type="tel" value="0606060606" class="flex-1 border border-gray-300 rounded-md p-2 text-sm">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs uppercase text-gray-600 mb-1">Adresse</label>
                            <input type="text" value="mina@gmail.com" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
