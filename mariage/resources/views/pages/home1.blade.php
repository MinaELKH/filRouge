<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mariages.net - Tout pour organiser votre mariage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pink: {
                            500: '#f74f78',
                            600: '#e63e67',
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="min-h-screen bg-white">
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

<!-- Features Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            Amusez-vous en organisant votre mariage
        </h2>
        <p class="text-gray-600 mb-8">
            Commencez à planifier votre mariage avec nous, c'est gratuit !
        </p>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden flex">
                <div class="p-6 flex-1">
                    <h3 class="text-xl font-semibold mb-2">Lieux de réception</h3>
                    <p class="text-gray-600 mb-4">Photos, avis et bien plus... Contactez-les en un clin d'œil !</p>
                    <a href="#" class="text-pink-500 hover:text-pink-600 text-sm font-medium">
                        Découvrez les espaces
                    </a>
                </div>
                <div class="relative w-40 md:w-48">
                    <img
                        src="https://placehold.co/200x200"
                        alt="Lieux de réception"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden flex">
                <div class="p-6 flex-1">
                    <h3 class="text-xl font-semibold mb-2">Prestataires</h3>
                    <p class="text-gray-600 mb-4">Trouvez les meilleurs professionnels près de chez vous dans chaque catégorie.</p>
                    <a href="#" class="text-pink-500 hover:text-pink-600 text-sm font-medium">
                        Formez votre équipe
                    </a>
                </div>
                <div class="relative w-40 md:w-48">
                    <img
                        src="https://placehold.co/200x200"
                        alt="Prestataires"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-2 md:gap-4">
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">🍽️</div>
                <span class="text-sm text-center">Traiteur</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">📸</div>
                <span class="text-sm text-center">Photographe</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">🎵</div>
                <span class="text-sm text-center">Musique</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">💇</div>
                <span class="text-sm text-center">Esthétique coiffure</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">🚗</div>
                <span class="text-sm text-center">Voiture mariage</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">👰</div>
                <span class="text-sm text-center">Negafa</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">🎨</div>
                <span class="text-sm text-center">Décoration</span>
            </a>
            <a href="#" class="flex flex-col items-center p-3 hover:bg-gray-50 rounded-md transition-colors">
                <div class="text-gray-700 mb-1">🏛️</div>
                <span class="text-sm text-center">Salle de fête</span>
            </a>
        </div>
    </div>
</section>

<!-- Service Providers -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            Choisissez-vous les meilleur prestataires
        </h2>
        <p class="text-gray-600 mb-8">
            Commencez à planifier votre mariage avec nous, c'est gratuit !
        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Provider 1 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Traiteur"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">traiteur</h3>
                    <p class="text-sm text-gray-500">47 traiteurs</p>
                </div>
            </div>

            <!-- Provider 2 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Musique mariage"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">Musique mariage</h3>
                    <p class="text-sm text-gray-500">53 groupes</p>
                </div>
            </div>

            <!-- Provider 3 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Esthétique coiffure"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">Esthétique coiffure</h3>
                    <p class="text-sm text-gray-500">39 esthéticien</p>
                </div>
            </div>

            <!-- Provider 4 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Decoration"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">Decoration</h3>
                    <p class="text-sm text-gray-500">44 entreprises de decoration</p>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <!-- Provider 5 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Voiture de mariage"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">voiture de mariage</h3>
                    <p class="text-sm text-gray-500">47 voitures disponible</p>
                </div>
            </div>

            <!-- Provider 6 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Salle de fête"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">Salle de fête</h3>
                    <p class="text-sm text-gray-500">53 salle de fêtes</p>
                </div>
            </div>

            <!-- Provider 7 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Photographie"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">Photographie</h3>
                    <p class="text-sm text-gray-500">39 photographe</p>
                </div>
            </div>

            <!-- Provider 8 -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="relative h-48">
                    <img
                        src="https://placehold.co/400x300"
                        alt="Negafa"
                        class="absolute inset-0 w-full h-full object-cover"
                    >
                </div>
                <div class="p-4">
                    <h3 class="font-medium mb-1">Negafa</h3>
                    <p class="text-sm text-gray-500">44 Negafa</p>
                </div>
            </div>
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
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
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

</body>
</html>
