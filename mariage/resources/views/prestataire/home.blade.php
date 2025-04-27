@extends('layouts.main')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Bienvenue dans votre espace prestataire</h1>

    <main class="container mx-auto px-4 py-6">
        <!-- Business Information Section -->
        <section class="mb-12">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-building mr-2 text-wedding-pink"></i>
                {{ isset($entreprise) ? 'Informations de votre entreprise' : 'Créer votre entreprise' }}
            </h1>

            <form action="{{ route('entreprise.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Company Card -->
                    <div class="w-full  md:w-1/4">
                        <div class="bg-white p-8 flex items-center justify-center rounded-full border border-gray-300 h-48 w-48">
                            @if(isset($entreprise) && $entreprise->logo)
                                <img src="{{ asset('/storage/' . $entreprise->logo) }}" alt="{{ $entreprise->nom ?? 'Votre entreprise' }}"  class="h-full object-contain">
                            @else

                            <div class="text-center text-gray-500">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <p>{{ isset($entreprise) ? $entreprise->nom : 'Ajoutez votre logo' }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm text-gray-800 mb-2">Logo de l'entreprise</label>
                            <input type="file" name="logo" class="w-full text-sm border border-gray-300 rounded p-2">
                            @error('logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Information Form -->
                    <div class="w-full md:w-3/4">
                        <div class="mb-8">
                            <div class="flex items-start gap-4 bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <div class="bg-white p-3 rounded-md text-blue-500 shadow-sm">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-blue-700">Informations générales</h3>
                                    <p class="text-sm text-blue-600">Complétez les informations de votre entreprise pour améliorer votre visibilité. Ces informations pourront être modifiées à tout moment.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informations de base -->
                        <div class="bg-white p-5 rounded-lg border border-gray-200 mb-6 shadow-sm">
                            <!-- Nom de l'entreprise -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'entreprise*</label>
                                <input type="text" name="nom" value="{{ $entreprise->nom ?? old('nom') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-wedding-pink focus:border-wedding-pink" required>
                                @error('nom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Business Description -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description de l'entreprise</label>
                                <div class="border border-gray-300 rounded-lg overflow-hidden">
                                    <div class="flex border-b border-gray-300 p-2 bg-gray-50">
                                        <button type="button" class="editor-button mr-1 p-1 hover:bg-gray-200 rounded" onclick="formatText('bold')">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button type="button" class="editor-button mr-1 p-1 hover:bg-gray-200 rounded" onclick="formatText('italic')">
                                            <i class="fas fa-italic"></i>
                                        </button>
                                        <button type="button" class="editor-button mr-1 p-1 hover:bg-gray-200 rounded" onclick="formatText('insertUnorderedList')">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                        <button type="button" class="editor-button mr-1 p-1 hover:bg-gray-200 rounded" onclick="formatText('insertOrderedList')">
                                            <i class="fas fa-list-ol"></i>
                                        </button>
                                        <button type="button" class="editor-button mr-1 p-1 hover:bg-gray-200 rounded" onclick="formatText('outdent')">
                                            <i class="fas fa-outdent"></i>
                                        </button>
                                        <button type="button" class="editor-button p-1 hover:bg-gray-200 rounded" onclick="formatText('indent')">
                                            <i class="fas fa-indent"></i>
                                        </button>
                                    </div>
                                    <div id="editor" class="p-4 min-h-[150px]" contenteditable="true">
                                        {!! $entreprise->description ?? old('description') !!}
                                    </div>
                                    <input type="hidden" name="description" id="description-input">
                                </div>
                                @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-white p-5 rounded-lg border border-gray-200 mb-6 shadow-sm">
                            <h3 class="font-medium text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-address-card text-wedding-pink mr-2"></i>
                                Coordonnées
                            </h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Personne à contacter</label>
                                <input type="text" name="personne_contact" value="{{ $entreprise->personne_contact ?? old('personne_contact') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-wedding-pink focus:border-wedding-pink">
                                @error('personne_contact')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                                <input type="email" name="email" value="{{ $entreprise->email ?? old('email') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-wedding-pink focus:border-wedding-pink">
                                @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <div class="flex gap-2">
                                    <select name="type_telephone" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-wedding-pink focus:border-wedding-pink">
                                        <option value="Autre" {{ ($entreprise->type_telephone ?? old('type_telephone')) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                        <option value="Mobile" {{ ($entreprise->type_telephone ?? old('type_telephone')) == 'Mobile' ? 'selected' : '' }}>Mobile</option>
                                        <option value="Fixe" {{ ($entreprise->type_telephone ?? old('type_telephone')) == 'Fixe' ? 'selected' : '' }}>Fixe</option>
                                    </select>
                                    <input type="tel" name="telephone" value="{{ $entreprise->telephone ?? old('telephone') }}" class="flex-1 border border-gray-300 rounded-lg p-2 text-sm focus:ring-wedding-pink focus:border-wedding-pink">
                                </div>
                                @error('telephone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                <input type="text" name="adresse" value="{{ $entreprise->adresse ?? old('adresse') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-wedding-pink focus:border-wedding-pink">
                                @error('adresse')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-wedding-pink text-white px-5 py-2 rounded-lg hover:bg-opacity-90 transition-colors shadow-sm font-medium">
                                {{ isset($entreprise) ? 'Mettre à jour' : 'Enregistrer' }}
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
