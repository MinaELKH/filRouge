<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', (Auth::user() && Auth::user()->role == 'prestataire') ? 'Espace Prestataire' : 'Espace Client')</title>
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
<body class="{{ (Auth::user() && Auth::user()->role == 'prestataire') ? 'bg-pro-light' : 'bg-gray-100' }} flex flex-col min-h-screen">

@if(Auth::user() && Auth::user()->role == 'prestataire')
    {{-- LAYOUT PRESTATAIRE --}}

    {{-- Header avec navigation améliorée --}}
    <header class="bg-pro-gray shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-5">
                <a href="#" class="flex items-center">
                    <span class="text-pro-blue font-bold text-2xl">mariages.net</span>
                    <span class="ml-2 text-xs px-3 py-1 bg-pro-blue text-white rounded-full">PRO</span>
                </a>

                <div class="flex items-center space-x-6">
                    <span class="text-sm text-gray-300">Bonjour, {{ Auth::user()->name ?? 'Prestataire' }}</span>
                    <div class="relative group">
                        <button class="w-12 h-12 rounded-full bg-pro-blue/10 flex items-center justify-center hover:bg-pro-blue/20 transition-colors">
                            <i class="fas fa-user text-pro-blue"></i>
                        </button>
                        <div class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block">
                            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-pro-blue/10 transition-colors">
                                <i class="fas fa-user-circle w-5 text-pro-blue"></i>
                                <span class="ml-3">Mon profil</span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-pro-blue/10 transition-colors">
                                <i class="fas fa-cog w-5 text-pro-blue"></i>
                                <span class="ml-3">Paramètres</span>
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5"></i>
                                    <span class="ml-3">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="flex border-t border-gray-700">
                <ul class="flex space-x-2 -mb-px py-2">
                    <li>
                        <a href="{{route('prestataire.home')}}" class="inline-flex items-center px-5 py-3 text-sm font-medium rounded-t-lg {{ request()->routeIs('prestataire.home') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-tachometer-alt mr-2"></i>Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{route('prestataire.services')}}" class="inline-flex items-center px-5 py-3 text-sm font-medium rounded-t-lg {{ request()->routeIs('prestataire.services') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-store mr-2"></i>Ma Vitrine
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('devisPrestataire') }}" class="inline-flex items-center px-5 py-3 text-sm font-medium rounded-t-lg {{ request()->routeIs('devisPrestataire') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-file-invoice-dollar mr-2"></i>Devis
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('messages.index') }}" class="relative inline-flex items-center px-5 py-3 text-sm font-medium rounded-t-lg {{ request()->routeIs('messages.index') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-envelope mr-2"></i>Messages
                            <span class="absolute top-2 right-2 px-2 py-0.5 text-xs rounded-full bg-red-500 text-white">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="inline-flex items-center px-5 py-3 text-sm font-medium rounded-t-lg text-gray-300 hover:bg-pro-blue/10 hover:text-white transition-colors">
                            <i class="fas fa-chart-bar mr-2"></i>Statistiques
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    {{-- Contenu dynamique avec fil d'ariane --}}
    <main class="flex-grow">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="container mx-auto px-4 py-4">
                <div class="text-sm breadcrumbs text-gray-500">
                    <a href="#" class="hover:text-pro-blue">Tableau de bord</a>
                    <span class="mx-2">›</span>
                    <span class="text-pro-blue font-medium">@yield('breadcrumb', 'Accueil')</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
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
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
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
        </div>
    </main>

    {{-- Footer modernisé pour prestataire --}}
    <footer class="bg-pro-gray text-white py-12 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-4 text-pro-blue">mariages.net PRO</h3>
                    <p class="text-sm text-gray-400">La plateforme professionnelle pour développer votre activité dans le secteur du mariage.</p>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pro-blue transition-colors"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pro-blue transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pro-blue transition-colors"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Services Pro</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Analytiques avancées</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Outils marketing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Formation Pro</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Support</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog professionnel</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Contact Pro</h3>
                    <ul class="text-sm space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-envelope w-5 text-pro-blue"></i>
                            <span class="ml-2 text-gray-400">pro@mariages.net</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone w-5 text-pro-blue"></i>
                            <span class="ml-2 text-gray-400">01 23 45 67 89</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock w-5 text-pro-blue"></i>
                            <span class="ml-2 text-gray-400">9h-18h (Lun-Ven)</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-500">
                © 2023 Mariages.net Pro - Tous droits réservés
            </div>
        </div>
    </footer>

@elseif(Auth::user() && Auth::user()->role == 'client')
    {{-- LAYOUT CLIENT --}}

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-wedding-pink font-bold text-xl">mariages.net</span>
                    <span class="ml-2 text-xs px-2 py-1 bg-wedding-pink text-white rounded-md">Espace Client</span>
                </a>

                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Bonjour, {{ Auth::user()->name ?? 'Client' }}</span>
                    <div class="relative group">
                        <button class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                            <i class="fas fa-user text-gray-600"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                            <a href="{{ route('client.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="flex border-t border-gray-200">
                <ul class="flex space-x-1 -mb-px overflow-x-auto">
                    <li>
                        <a href="{{ route('client.dashboard') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('client.dashboard') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-home mr-2"></i>Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.profile') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('client.profile') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-user-circle mr-2"></i>Mes informations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.tasks') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('client.tasks') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-check-square mr-2"></i>Tâches
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.favorites') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('client.favorites') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-heart mr-2"></i>Favoris
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.devis') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('client.devis') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-file-invoice-dollar mr-2"></i>Devis
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.reservations') }}" class="inline-block px-4 py-3 text-sm font-medium {{ request()->routeIs('client.reservations') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-calendar-check mr-2"></i>Services réservés
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="text-sm breadcrumbs mb-6 text-gray-500">
            <a href="{{ route('client.dashboard') }}" class="hover:text-wedding-pink">Tableau de bord</a>
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

        <div class="bg-white p-6 rounded shadow">
            @yield('content')
        </div>
    </main>

    {{-- Footer pour client --}}
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
                        <li class="flex items-center"><i class="fas fa-envelope w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">clients@mariages.net</span></li>
                        <li class="flex items-center"><i class="fas fa-phone w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">01 23 45 67 89</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-400">
                © 2023 Mariages.net - Tous droits réservés
            </div>
        </div>
    </footer>
@endif

@stack('script')
</body>
</html>
