@extends('layouts.main')

@section('title', $service->title)

@section('breadcrumb', 'Détail du service')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Colonne principale -->
            <div class="md:w-2/3">
                <!-- Galerie d'images style mariages.net adaptative -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($service->gallery)
                        @php
                            $gallery = is_string($service->gallery) ? json_decode($service->gallery, true) : $service->gallery;
                            $galleryImages = is_array($gallery) ? array_slice($gallery, 0, 4) : [];
                            $totalImages = count($galleryImages);
                        @endphp

                        @if($totalImages == 0)
                            <!-- Seulement l'image de couverture -->
                            <div class="relative">
                                <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                     alt="{{ $service->title }}"
                                     class="w-full h-[400px] object-cover">
                            </div>
                        @elseif($totalImages == 1)
                            <!-- Image de couverture + 1 image -->
                            <div class="grid grid-cols-2 gap-0.5">
                                <div class="relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[0]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                            </div>
                        @elseif($totalImages == 2)
                            <!-- Image de couverture + 2 images -->
                            <div class="grid grid-cols-3 gap-0.5">
                                <div class="col-span-2 relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                <div class="grid grid-rows-2 gap-0.5">
                                    @foreach($galleryImages as $image)
                                        <div class="relative">
                                            <img src="{{ asset('images/services/gallery/' . $image) }}"
                                                 alt="Galerie - {{ $service->title }}"
                                                 class="w-full h-[200px] object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($totalImages == 3)
                            <!-- Image de couverture + 3 images -->
                            <div class="grid grid-cols-4 gap-0.5">
                                <div class="col-span-2 row-span-2 relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                <div class="col-span-2 relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[0]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[200px] object-cover">
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[1]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[200px] object-cover">
                                </div>
                                <div class="relative">
                                    <img src="{{ asset('images/services/gallery/' . $galleryImages[2]) }}"
                                         alt="Galerie - {{ $service->title }}"
                                         class="w-full h-[200px] object-cover">
                                </div>
                            </div>
                        @else
                            <!-- Image de couverture + 4 images -->
                            <div class="grid grid-cols-3 gap-0.5">
                                <div class="col-span-2 row-span-2 relative">
                                    <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                         alt="{{ $service->title }}"
                                         class="w-full h-[400px] object-cover">
                                </div>
                                @foreach($galleryImages as $index => $image)
                                    <div class="relative">
                                        <img src="{{ asset('images/services/gallery/' . $image) }}"
                                             alt="Galerie - {{ $service->title }}"
                                             class="w-full h-[200px] object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <!-- Seulement l'image de couverture si pas de galerie -->
                        <div class="relative">
                            <img src="{{ asset('images/services/' . $service->cover_image) }}"
                                 alt="{{ $service->title }}"
                                 class="w-full h-[400px] object-cover">
                        </div>
                    @endif
                </div>

                <!-- Informations importantes -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <h2 class="text-xl font-bold mb-4">Informations</h2>
                    <div class="flex items-start mb-4">

                        <p class="text-gray-700">{!! $service->description !!}</p>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-calendar-alt w-6 text-gray-500"></i>
                        <span>Créé le {{ $service->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-tag w-6 text-gray-500"></i>
                        <span>{{ $service->category->name }}</span>
                    </div>
                </div>



                @if($service->user->description)
                    <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                        <h2 class="text-xl font-bold mb-4">À propos de {{ $service->user->nom ?? $service->user->name }}</h2>
                        <p class="text-gray-700">{!! $service->user->description !!}</p>
                    </div>
                @endif

                <!-- Avis -->
{{--                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">--}}
{{--                    <h2 class="text-xl font-bold mb-6">Avis de {{ $service->title }}</h2>--}}

{{--                    <div class="text-center mb-8">--}}
{{--                        <div class="flex justify-center items-center mb-2">--}}
{{--                            @for($i = 1; $i <= 5; $i++)--}}
{{--                                <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>--}}
{{--                            @endfor--}}
{{--                        </div>--}}
{{--                        <p class="text-lg font-medium">Ce prestataire n'a pas encore d'avis, donnez le vôtre !</p>--}}
{{--                        <p class="text-gray-600 mt-2">Votre opinion peut aider les futurs couples à prendre la bonne décision pour leur grand jour</p>--}}
{{--                        <button class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg mt-4 hover:bg-gray-50 transition-colors">--}}
{{--                            Écrivez une recommandation--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}


                <!-- Commentaires -->
                <div class="bg-white rounded-lg shadow-lg mt-6 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">Commentaires sur {{ $service->title }}</h2>
                        <span class="text-gray-500">({{ $service->reviews_count }} commentaires)</span>
                    </div>

                    <!-- Liste des commentaires -->
                    <div id="reviews-container" class="space-y-4 mb-8">
                        @foreach($service->reviews()->with('user')->latest()->get() as $review)
                            @include('partials.review-item', ['review' => $review])
                        @endforeach
                    </div>

                    <!-- Formulaire pour ajouter un commentaire (sur la même page) -->
                    @auth
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-4">Ajouter un commentaire</h3>
                            <form id="review-form" class="space-y-4">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <div>
                                    <label for="comment" class="block text-gray-700 font-medium mb-2">Votre commentaire</label>
                                    <textarea id="comment" name="comment" rows="4"
                                              class="w-full border-gray-300 rounded-lg focus:ring-wedding-pink focus:border-wedding-pink"
                                              placeholder="Partagez votre expérience..."></textarea>
                                    <p class="text-sm text-gray-500 mt-1">Minimum 3 caractères</p>
                                    <p class="text-red-500 text-sm mt-1 comment-error" style="display: none;"></p>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="bg-wedding-pink hover:bg-pink-600 text-white px-6 py-2 rounded-lg transition-colors">
                                        Publier
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="text-center bg-gray-50 p-4 rounded-lg">
                            <p class="text-lg font-medium mb-2">Connectez-vous pour commenter</p>
                            <a href="{{ route('login') }}" class="bg-wedding-pink text-white px-6 py-2 rounded-lg inline-block hover:bg-pink-600 transition-colors">
                                Se connecter
                            </a>
                        </div>
                    @endauth
                </div>

            </div>

















            <!-- Sidebar fixée à droite -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-2">{{ $service->title }}</h2>

                    <!-- Étoiles et recommandation -->
                    <div class="flex items-center mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                        @endfor
                        <span class="ml-2 text-sm text-gray-600">0 avis Écrire une recommandation</span>
                    </div>

                    <!-- Localisation -->
                    <div class="flex items-center text-gray-600 mb-6">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $service->ville->name }}</span>
                    </div>

                    <!-- Prix -->
                    <div class="flex items-center mb-6">
                        <i class="fas fa-euro-sign mr-2 text-gray-600"></i>
                        <span class="text-gray-700">à partir de {{ number_format($service->price, 0, ',', ' ') }}DH</span>
                    </div>

                    <!-- Capacité -->
                    <div class="flex items-center mb-6">
                        <i class="fas fa-users mr-2 text-gray-600"></i>
                        <span class="text-gray-700">80 - 490 invité(s)</span>
                    </div>

                    <!-- Bouton de contact -->

                    <button
                        class="openModalBtn w-full bg-gradient-to-r from-wedding-pink to-wedding-pink text-white py-3 rounded-lg font-medium hover:from-from-wedding-pink hover:to-rose-500 transition-colors mb-4"
                        data-receiver-id="{{ $service->user_id }}"
                        data-service-id="{{ $service->id }}"
                    >
                        Nous contacter
                    </button>

                    <!-- Actions favorites -->

                    <button class="toggle-favorite w-full bg-white border border-gray-300 py-2 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center {{ auth()->check() && auth()->user()->isFavorite($service->id) ? 'text-wedding-pink border-wedding-pink' : 'text-gray-700 border-gray-300' }}"
                            data-service-id="{{ $service->id }}">
                        <i class="{{ auth()->check() && auth()->user()->isFavorite($service->id) ? 'fas' : 'far' }} fa-heart mr-2"></i>
                        <span>{{ auth()->check() && auth()->user()->isFavorite($service->id) ? 'Retirer des favoris' : 'Ajouter aux favoris' }}</span>
                    </button>
                    <!-- Script pour la fonctionnalité favoris -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const favButtons = document.querySelectorAll('.toggle-favorite');

                            favButtons.forEach(btn => {
                                btn.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const serviceId = this.getAttribute('data-service-id');
                                    const isFavorite = this.classList.contains('text-wedding-pink');
                                    const buttonText = this.querySelector('span');
                                    const icon = this.querySelector('i');

                                    const method = isFavorite ? 'DELETE' : 'POST';
                                    const url = `/client/favorites/${serviceId}`;

                                    fetch(url, {
                                        method: method,
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        }
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                // Mettre à jour l'icône
                                                icon.classList.toggle('far');
                                                icon.classList.toggle('fas');

                                                // Mettre à jour le style et le texte du bouton
                                                if (method === 'POST') {
                                                    this.classList.add('text-wedding-pink', 'border-wedding-pink');
                                                    this.classList.remove('text-gray-700', 'border-gray-300');
                                                    buttonText.textContent = 'Retirer des favoris';
                                                } else {
                                                    this.classList.add('text-gray-700', 'border-gray-300');
                                                    this.classList.remove('text-wedding-pink', 'border-wedding-pink');
                                                    buttonText.textContent = 'Ajouter aux favoris';
                                                }
                                            }
                                        })
                                        .catch(error => console.error('Erreur:', error));
                                });
                            });
                        });
                    </script>


















                    <!-- Très sollicité à Paris -->
                    <div class="mt-4 text-sm text-gray-600">
                        <i class="fas fa-chart-line mr-1"></i>
                        Très sollicité à {{ $service->ville->name }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section informations de l'entreprise -->
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-6">A propos</h2>

                @if($service->entreprise && $service->entreprise->description)
                    <div class ="flex items-center">
                        @if(isset($service->entreprise->logo))
                            <img src="{{ asset('/storage/' . $service->entreprise->logo) }}" alt="{{ $service->entreprise->nom ?? 'Votre entreprise' }}" class="h-32 w-32 object-contain">
                        @endif

                        <p class="text-gray-600">   <span class="font-medium text-wedding-pink mb-1">{{ $service->entreprise->nom }}</span>{!! $service->entreprise->description !!}</p>
                    </div>

                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @if($service->entreprise->email)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Contact</h3>
                            <p class="text-gray-600">{{ $service->entreprise->email }}</p>
                        </div>
                    @endif

                    @if($service->entreprise->telephone)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Téléphone</h3>
                            <p class="text-gray-600">{{ $service->entreprise->telephone }}</p>
                        </div>
                    @endif

                    @if($service->entreprise->adresse)
                        <div>
                            <h3 class="font-medium text-gray-900 mb-1">Adresse</h3>
                            <p class="text-gray-600">{{ $service->entreprise->adresse }}</p>
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </div>
    <x-contact-modal :receiverId="$service->user_id ?? null" :serviceId="$service->id ?? null" />
@endsection

@push('script')
    <script>
        // Script pour ouvrir la galerie en mode lightbox (optionnel)
        document.addEventListener('DOMContentLoaded', function() {
            const galleryButtons = document.querySelectorAll('.cursor-pointer');

            galleryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ici vous pouvez ajouter la fonctionnalité pour ouvrir une lightbox
                    // ou une modale pour afficher toutes les images
                    console.log('Ouvrir la galerie complète');
                });
            });
        });
    </script>

{{--    POUR l ajout du commentaires--}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la soumission du formulaire
            const reviewForm = document.getElementById('review-form');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');

                    // Désactiver le bouton pendant la soumission
                    submitButton.disabled = true;
                    submitButton.innerText = 'Publication...';

                    // Masquer les messages d'erreur précédents
                    document.querySelector('.comment-error').style.display = 'none';

                    // Soumettre le formulaire via AJAX
                    fetch('{{ route('reviews.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Ajouter le nouveau commentaire au début de la liste
                                const reviewsContainer = document.getElementById('reviews-container');
                                reviewsContainer.innerHTML = data.html + reviewsContainer.innerHTML;

                                // Réinitialiser le formulaire
                                reviewForm.reset();

                                // Mise à jour du compteur de commentaires
                                const countElement = document.querySelector('span.text-gray-500');
                                const currentCount = parseInt(countElement.innerText.match(/\d+/)[0]) + 1;
                                countElement.innerText = `(${currentCount} commentaires)`;

                                // Ajouter les gestionnaires d'événements au nouveau commentaire
                                setupDeleteHandlers();
                            } else if (data.status === 'error') {
                                // Afficher les erreurs
                                const commentError = document.querySelector('.comment-error');
                                commentError.textContent = data.errors.comment[0] || 'Une erreur est survenue';
                                commentError.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                        })
                        .finally(() => {
                            // Réactiver le bouton
                            submitButton.disabled = false;
                            submitButton.innerText = 'Publier';
                        });
                });
            }

            // Configurer les gestionnaires pour la suppression
            function setupDeleteHandlers() {
                document.querySelectorAll('.delete-review').forEach(button => {
                    button.addEventListener('click', function() {
                        const reviewId = this.getAttribute('data-review-id');
                        if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')) {
                            deleteReview(reviewId);
                        }
                    });
                });
            }

            // Fonction pour supprimer un commentaire
            function deleteReview(reviewId) {
                fetch(`/reviews/${reviewId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Supprimer l'élément du DOM
                            const reviewElement = document.getElementById(`review-${reviewId}`);
                            reviewElement.remove();

                            // Mise à jour du compteur de commentaires
                            const countElement = document.querySelector('span.text-gray-500');
                            const currentCount = parseInt(countElement.innerText.match(/\d+/)[0]) - 1;
                            countElement.innerText = `(${currentCount} commentaires)`;
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la suppression du commentaire.');
                    });
            }

            // Initialiser les gestionnaires d'événements
            setupDeleteHandlers();
        });
    </script>
@endpush
