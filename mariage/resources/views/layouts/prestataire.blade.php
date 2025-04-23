<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Prestataire')</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

{{-- Header avec navigation améliorée --}}
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <a href="#" class="flex items-center">
                <span class="text-wedding-pink font-bold text-xl">mariages.net</span>
                <span class="ml-2 text-xs px-2 py-1 bg-wedding-pink text-white rounded-md">Espace Pro</span>
            </a>

            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Bonjour, {{ Auth::user()->name ?? 'Prestataire' }}</span>
                <div class="relative group">
                    <button class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                        <i class="fas fa-user text-gray-600"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                        <div class="border-t border-gray-100"></div>
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Déconnexion</a>
                    </div>
                </div>
            </div>
        </div>

        <nav class="flex border-t border-gray-200">
            <ul class="flex space-x-1 -mb-px">
                <li>
                    <a href="{{route('prestataire.home')}}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('prestataire.home') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                </li>
                <li>
                    <a href="{{route('prestataire.services')}}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('prestataire.services') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                        <i class="fas fa-store mr-2"></i>Ma Vitrine
                    </a>
                </li>
                <li>
                    <a href="{{ route('devisPrestataire') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('devisPrestataire') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>Devis
                    </a>
                </li>
                <li>
                    <a href="{{ route('messages.index') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('messages.index') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                        <i class="fas fa-envelope mr-2"></i>Messages
                        <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-wedding-pink text-white">3</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="inline-block px-4 py-3 text-sm font-medium text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink">
                        <i class="fas fa-chart-bar mr-2"></i>Statistiques
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

{{-- Contenu dynamique avec fil d'ariane --}}
<main class="flex-grow container mx-auto px-4 py-8">
    <div class="text-sm breadcrumbs mb-6 text-gray-500">
        <a href="#" class="hover:text-wedding-pink">Tableau de bord</a>
        <span class="mx-2">›</span>
        <span>@yield('breadcrumb', 'Accueil')</span>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @yield('content')
</main>

{{-- Footer modernisé --}}
<footer class="bg-wedding-dark text-white py-10 mt-auto">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-bold text-lg mb-4">mariages.net</h3>
                <p class="text-sm text-gray-300">La meilleure plateforme pour les professionnels du mariage.</p>
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
                    <li><a href="#" class="text-gray-300 hover:text-white">Guide du prestataire</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white">Blog professionnel</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-4">Contact</h3>
                <ul class="text-sm space-y-2">
                    <li class="flex items-center"><i class="fas fa-envelope w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">support@mariages.net</span></li>
                    <li class="flex items-center"><i class="fas fa-phone w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">01 23 45 67 89</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
            © 2023 Mariages.net - Tous droits réservés
        </div>
    </div>
</footer>

@stack('script')
</body>
</html>
