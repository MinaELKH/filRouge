@extends('layouts.prestataire')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800">Bienvenue dans votre espace prestataire</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded my-4">
            {{ session('success') }}
        </div>
    @endif

    <main class="container mx-auto px-4 py-8">
        <!-- Business Information Section -->
        <section class="mb-12">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6">Informations entreprise</h1>

            <form action="{{ route('entreprise.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Company Card -->
                    <div class="w-full md:w-1/4">
                        <div class="bg-gray-400 p-8 flex items-center justify-center">
                            @if(isset($entreprise) && $entreprise->logo)
                                <img src="{{ asset('storage/' . $entreprise->logo) }}" alt="{{ $entreprise->nom ?? 'FARHATKOM' }}" class="max-w-full max-h-32">
                            @else
                                <h2 class="text-white font-bold">{{ $entreprise->nom ?? 'FARHATKOM' }}</h2>
                            @endif
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm text-gray-800 mb-2">Changer le logo</label>
                            <input type="file" name="logo" class="w-full text-sm">
                            <a href="#" class="text-sm text-gray-800 mt-2 inline-block">Voir ma vitrine</a>
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
                                <p class="text-sm">{{ Auth::user()->name }}</p>
                            </div>
                        </div>

                        <!-- Nom de l'entreprise -->
                        <div class="mb-4">
                            <label class="block text-xs uppercase text-gray-600 mb-1">Nom de l'entreprise</label>
                            <input type="text" name="nom" value="{{ $entreprise->nom ?? '' }}" class="w-full border border-gray-300 rounded-md p-2 text-sm" required>
                        </div>

                        <!-- Business Description -->
                        <div class="mb-8">
                            <h3 class="font-semibold text-gray-800 mb-4">Décrivez votre entreprise</h3>
                            <div class="border border-gray-300 rounded-md">
                                <div class="flex border-b border-gray-300 p-2">
                                    <button type="button" class="editor-button mr-1" onclick="formatText('bold')">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="editor-button mr-1" onclick="formatText('italic')">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="editor-button mr-1" onclick="formatText('insertUnorderedList')">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="editor-button mr-1" onclick="formatText('insertOrderedList')">
                                        <i class="fas fa-list-ol"></i>
                                    </button>
                                    <button type="button" class="editor-button mr-1" onclick="formatText('outdent')">
                                        <i class="fas fa-outdent"></i>
                                    </button>
                                    <button type="button" class="editor-button" onclick="formatText('indent')">
                                        <i class="fas fa-indent"></i>
                                    </button>
                                </div>
                                <div id="editor" class="p-4 min-h-[200px]" contenteditable="true">
                                    {!! $entreprise->description ?? '' !!}
                                </div>
                                <input type="hidden" name="description" id="description-input">
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="mb-8">
                            <h3 class="font-semibold text-gray-800 mb-4">Vos coordonnées</h3>

                            <div class="mb-4">
                                <label class="block text-xs uppercase text-gray-600 mb-1">Personne à contacter</label>
                                <input type="text" name="personne_contact" value="{{ $entreprise->personne_contact ?? '' }}" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs uppercase text-gray-600 mb-1">E-mail</label>
                                <input type="email" name="email" value="{{ $entreprise->email ?? '' }}" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs uppercase text-gray-600 mb-1">Téléphone</label>
                                <div class="flex gap-2">
                                    <select name="type_telephone" class="border border-gray-300 rounded-md p-2 text-sm">
                                        <option value="Autre" {{ ($entreprise->type_telephone ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                        <option value="Mobile" {{ ($entreprise->type_telephone ?? '') == 'Mobile' ? 'selected' : '' }}>Mobile</option>
                                        <option value="Fixe" {{ ($entreprise->type_telephone ?? '') == 'Fixe' ? 'selected' : '' }}>Fixe</option>
                                    </select>
                                    <input type="tel" name="telephone" value="{{ $entreprise->telephone ?? '' }}" class="flex-1 border border-gray-300 rounded-md p-2 text-sm">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs uppercase text-gray-600 mb-1">Adresse</label>
                                <input type="text" name="adresse" value="{{ $entreprise->adresse ?? '' }}" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-wedding-pink text-white px-4 py-2 rounded hover:bg-opacity-90 transition-colors">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const editorContent = document.getElementById('editor');
            const descriptionInput = document.getElementById('description-input');

            // Mettre à jour le champ caché lors de la soumission du formulaire
            form.addEventListener('submit', function() {
                descriptionInput.value = editorContent.innerHTML;
            });
        });

        function formatText(command, value = null) {
            document.execCommand(command, false, value);
            document.getElementById('editor').focus();
        }
    </script>
@endpush
