<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mariages.net - Tout pour organiser votre mariage')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wedding-pink': '#f76c6f',
                        'wedding-dark': '#454545',
                        'pro-blue': '#2563eb',
                        'pro-light': '#f8fafc',
                        'pro-gray': '#1e293b',
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center">
                <div class="text-wedding-pink mr-1">
                    <i class="fas fa-heart text-2xl"></i>
                </div>
                <span class="text-xl font-medium text-gray-700">mariages</span>
            </a>

            <!-- Navigation principale -->
            <nav class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-wedding-pink uppercase">Mon Mariage</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-wedding-pink uppercase">Lieux de Mariage</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-wedding-pink uppercase">Prestataires</a>
                <a href="#" class="text-sm font-medium text-gray-700 hover:text-wedding-pink uppercase">Mariée</a>
            </nav>

            <div class="flex items-center space-x-6">

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-wedding-pink hover:text-pink-600 uppercase">Connexion</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-wedding-pink hover:text-pink-600 uppercase">Inscription</a>
                @else
                    @if(Auth::user()->role === 'client')
                        <a href="{{ route('client.dashboard') }}" class="text-sm font-medium text-wedding-pink hover:text-pink-600">
                            <i class="fas fa-home mr-1"></i>
                            Espace client
                        </a>
                    @elseif(Auth::user()->role === 'prestataire')
                        <a href="{{ route('prestataire.home') }}" class="text-sm font-medium text-pro-blue hover:text-blue-700">
                            <i class="fas fa-briefcase mr-1"></i>
                            Espace prestataire
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="inline">
                        @csrf
                        <a href="#" onclick="document.getElementById('logoutForm').submit();" class="text-sm font-medium text-gray-600 hover:text-wedding-pink">
                            <i class="fas fa-sign-out-alt mr-1"></i>

                        </a>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2 pr-4 md:pr-12 flex flex-col justify-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Tout pour organiser votre mariage
                </h1>
                <p class="text-gray-600 mb-6">
                    Plus de 67.000 prestataires pour faire votre choix !
                </p>

                <div class="flex w-full max-w-md border border-gray-300 rounded-md overflow-hidden">
                    <form action="{{ route('services.search') }}" method="GET" class="flex w-full">
                        <div class="relative flex-grow flex">
                            <select name="category_id" class="w-1/2 pl-3 py-2 border-0 border-r border-gray-300 focus:outline-none focus:ring-0">
                                <option value="">Catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select name="ville_id" class="w-1/2 pl-3 py-2 border-0 focus:outline-none focus:ring-0">
                                <option value="">Ville</option>
                                @foreach($villes as $ville)
                                    <option value="{{ $ville->id }}">{{ $ville->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-wedding-pink hover:bg-pink-600 text-white px-6 py-2 transition-colors">
                            Rechercher
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:w-1/2 mt-8 md:mt-0">
                <img
                    src="/images/img/img.jpg"
                    alt="Couple de mariés en hiver"
                    class="h-64 w-full rounded-lg object-contain"
                >
            </div>
        </div>
    </div>
</section>


<!-- Contenu principal -->
<main class="flex-grow bg-white">
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>
</main>

<!-- Footer -->
<!-- Section catégories -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Amusez-vous en organisant votre mariage</h2>
        <p class="text-gray-600 mb-10">Commencez à planifier votre mariage avec nous, c'est gratuit !</p>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Lieux de réception -->
            <div class="flex">
                <div class="w-1/2 pr-4">
                    <h3 class="text-xl font-semibold mb-2">Lieux de réception</h3>
                    <p class="text-gray-600 mb-4">Photos, avis et bien plus... Contactez-les en un clin d'œil !</p>
                    <a href="#" class="text-wedding-pink hover:underline">Découvrez les espaces</a>
                </div>
                <div class="w-1/2">
                    <img src="/images/img/lieu.jpg" alt="Prestataires" class="w-64 h-32 rounded-lg object-cover object-center">


                </div>
            </div>

            <!-- Prestataires -->
            <div class="flex">
                <div class="w-1/2 pr-4">
                    <h3 class="text-xl font-semibold mb-2">Prestataires</h3>
                    <p class="text-gray-600 mb-4">Trouvez les meilleurs professionnels près de chez vous dans chaque catégorie.</p>
                    <a href="#" class="text-wedding-pink hover:underline">Formez votre équipe</a>
                </div>
                <div class="w-1/2">
                    <img src="/images/img/prestataire.jpg" alt="Prestataires" class="w-64 h-32 rounded-lg object-cover object-top">


                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-wedding-dark text-white py-10 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-bold text-lg mb-4">mariages.net</h3>
                <p class="text-sm text-gray-300">Planifiez votre mariage parfait avec nos outils et services professionnels.</p>
                <div class="mt-4 flex space-x-3">
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-4">Liens utiles</h3>
                <ul class="text-sm space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white">Centre d'aide</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Guide de planification</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Idées et inspiration</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-4">Contact</h3>
                <ul class="text-sm space-y-2">
                    <li class="flex items-center"><i class="fas fa-envelope w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">contact@mariages.net</span></li>
                    <li class="flex items-center"><i class="fas fa-phone w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">01 23 45 67 89</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
            © 2025 Mariages.net - Tous droits réservés
        </div>
    </div>
</footer>

@stack('script')
<script>
    window.isAuthenticated = @json(Auth::check());
</script>
<script src="{{ asset('js/modalContact.js') }}"></script>

</body>
</html>
