<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mariages.net - Tout pour organiser votre mariage')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coral: {
                            500: '#ff6b6b',
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="min-h-screen bg-gray-100">

<!-- Header -->
<header class="border-b border-gray-200">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <img src="https://placehold.co/40x40" alt="Mariages.net" class="h-10 w-auto">
                <div class="text-xl font-semibold text-pink-500">mariages<span class="text-gray-500">.net</span></div>
            </div>

            <nav class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-sm font-medium uppercase hover:text-pink-500">Mon Mariage</a>
                <a href="#" class="text-sm font-medium uppercase hover:text-pink-500">Lieux de Mariage</a>
                <a href="#" class="text-sm font-medium uppercase hover:text-pink-500">Prestataires</a>
                <a href="#" class="text-sm font-medium uppercase hover:text-pink-500">Mariée</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="#" class="hidden md:block text-sm font-medium text-gray-600 hover:text-gray-800">Accès Entreprises</a>
                <a href="#" class="text-sm font-medium text-pink-500 hover:text-pink-600">CONNEXION</a>
                <a href="#" class="text-sm font-medium text-pink-500 hover:text-pink-600">INSCRIPTION</a>
            </div>
        </div>
    </div>
</header>


<!-- Hero Section -->
<section class="relative">
    <div class="container mx-auto px-4 py-12 md:py-16">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Tout pour organiser votre mariage
                </h1>
                <p class="text-gray-600 mb-6">
                    Plus de 67.000 prestataires pour faire votre choix !
                </p>

                <div class="flex w-full max-w-md">
                    <div class="relative flex-grow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            placeholder="Nom ou catégorie de prestataire"
                            class="w-full pl-10 pr-4 py-2 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        >
                    </div>
                    <button class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-r-md">
                        Rechercher
                    </button>
                </div>
            </div>

            <div class="relative h-64 md:h-80">
                <img
                    src="https://placehold.co/600x400"
                    alt="Couple de mariés en hiver"
                    class="absolute inset-0 w-full h-full object-cover rounded-lg"
                >
            </div>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-8">
    @yield('content')
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-6">
    <div class="container mx-auto text-center">
        <p>&copy; 2025 Mariages.net - Tous droits réservés</p>
    </div>
</footer>



<script  src="{{ asset('js/modalContact.js') }}"></script>

</body>
</html>
