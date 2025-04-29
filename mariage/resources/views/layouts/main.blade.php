<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/images/img/logo.jpg" type="image/png">
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
        <div class="container mx-auto px-2 sm:px-4">
            <div class="flex items-center justify-between py-3 sm:py-5">
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                        <img src="/images/img/logo.jpg" class="h-8 sm:h-10 mr-2">
                        <span class="text-lg sm:text-xl font-medium text-gray-200">mariages</span>
                    </a>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="hidden sm:inline text-sm text-gray-200">Bonjour, {{ Auth::user()->name ?? 'prestataire' }}</span>
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <img src="{{ asset('images/img/avatar-prestataire.jpg') }}" alt="Avatar prestataire" class="h-8 w-8 sm:h-12 sm:w-12 rounded-full object-cover border-2 border-white shadow">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 rounded-md hover:bg-wedding-pink/20 cursor-pointer" title="Déconnexion">
                                <i class="fas fa-sign-out-alt w-5 sm:w-6 h-5 sm:h-6 flex items-center justify-center text-wedding-pink"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <nav class="border-t border-gray-700 overflow-x-auto scrollbar-hide">
                <ul class="flex space-x-1 sm:space-x-2 -mb-px py-1 sm:py-2 whitespace-nowrap">
                    <li>
                        <a href="{{route('prestataire.home')}}" class="inline-flex items-center px-2 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-medium rounded-t-lg {{ request()->routeIs('prestataire.home') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-tachometer-alt mr-1 sm:mr-2"></i><span class="hidden xs:inline">Tableau de bord</span><span class="inline xs:hidden">Tableau</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('prestataire.services')}}" class="inline-flex items-center px-2 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-medium rounded-t-lg {{ request()->routeIs('prestataire.services') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-store mr-1 sm:mr-2"></i><span>Ma Vitrine</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('prestataire.reservations') }}" class="inline-flex items-center px-2 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-medium rounded-t-lg {{ request()->routeIs('prestataire.reservations') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-file-invoice-dollar mr-1 sm:mr-2"></i><span>Réservations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('devisPrestataire') }}" class="inline-flex items-center px-2 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-medium rounded-t-lg {{ request()->routeIs('devisPrestataire') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-file-invoice-dollar mr-1 sm:mr-2"></i><span>Devis</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('messages.index') }}" class="relative inline-flex items-center px-2 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-medium rounded-t-lg {{ request()->routeIs('messages.index') ? 'bg-pro-blue text-white' : 'text-gray-300 hover:bg-pro-blue/10 hover:text-white' }} transition-colors">
                            <i class="fas fa-envelope mr-1 sm:mr-2"></i><span>Messages</span>
                            <span class="absolute top-0 right-0 px-1.5 py-0.5 text-xs rounded-full bg-red-500 text-white">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('prestataire.dashboard')}}" class="inline-flex items-center px-2 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-medium rounded-t-lg text-gray-300 hover:bg-pro-blue/10 hover:text-white transition-colors">
                            <i class="fas fa-chart-bar mr-1 sm:mr-2"></i><span class="hidden sm:inline">Statistiques</span><span class="inline sm:hidden">Stats</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    {{-- Contenu dynamique avec fil d'ariane --}}
    <main class="flex-grow">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="container mx-auto px-4 py-3 sm:py-4">
                <div class="text-xs sm:text-sm breadcrumbs text-gray-500">
                    <a href="#" class="hover:text-pro-blue">Tableau de bord</a>
                    <span class="mx-2">›</span>
                    <span class="text-pro-blue font-medium">@yield('breadcrumb', 'Accueil')</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-6 sm:py-8 md:px-8 lg:px-16 xl:px-32">
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 mb-6 rounded-r-lg">
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
                <div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 mb-6 rounded-r-lg">
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
    <footer class="bg-pro-gray text-white py-8 sm:py-12 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4 text-pro-blue">mariages.net PRO</h3>
                    <p class="text-xs sm:text-sm text-gray-400">La plateforme professionnelle pour développer votre activité dans le secteur du mariage.</p>
                    <div class="mt-4 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pro-blue transition-colors"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pro-blue transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pro-blue transition-colors"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4">Services Pro</h3>
                    <ul class="text-xs sm:text-sm space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Analytiques avancées</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Outils marketing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Formation Pro</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4">Support</h3>
                    <ul class="text-xs sm:text-sm space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog professionnel</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4">Contact Pro</h3>
                    <ul class="text-xs sm:text-sm space-y-2">
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
            <div class="border-t border-gray-700 mt-6 sm:mt-8 pt-4 sm:pt-6 text-center text-xs sm:text-sm text-gray-500">
                © 2023 Mariages.net Pro - Tous droits réservés
            </div>
        </div>
    </footer>

@elseif(Auth::user() && Auth::user()->role == 'client')
    {{-- LAYOUT CLIENT --}}

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-2 sm:px-4">
            <div class="flex items-center justify-between py-3 sm:py-4">
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                        <img src="/images/img/logo.jpg" class="h-8 sm:h-10 mr-1 sm:mr-2">
                        <span class="text-lg sm:text-xl font-medium text-gray-700">mariages</span>
                    </a>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="hidden sm:inline text-sm text-gray-600">Bonjour, {{ Auth::user()->name ?? 'Client' }}</span>
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                            <img src="{{ asset('images/img/avatarMarie.jpg') }}" alt="Avatar marie" class="h-6 w-6 sm:h-8 sm:w-8 rounded-full object-cover border-2 border-white shadow">
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 rounded-md hover:bg-wedding-pink/20 cursor-pointer" title="Déconnexion">
                                <i class="fas fa-sign-out-alt w-5 sm:w-6 h-5 sm:h-6 flex items-center justify-center text-wedding-pink"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <nav class="flex border-t border-gray-200 overflow-x-auto scrollbar-hide">
                <ul class="flex space-x-1 -mb-px py-1 whitespace-nowrap">
                    <li>
                        <a href="{{ route('home') }}" class="inline-block px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium {{ request()->routeIs('client.dashboard') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-home mr-1 sm:mr-2"></i><span>Accueil</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.tasks') }}" class="inline-block px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium {{ request()->routeIs('client.tasks') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-check-square mr-1 sm:mr-2"></i><span>Tâches</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('messages.index') }}" class="inline-block px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium {{ request()->routeIs('messages.index') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-envelope mr-1 sm:mr-2"></i><span>Messages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.favorites') }}" class="inline-block px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium {{ request()->routeIs('client.favorites') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-heart mr-1 sm:mr-2"></i><span>Favoris</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.devis') }}" class="inline-block px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium {{ request()->routeIs('client.devis') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-file-invoice-dollar mr-1 sm:mr-2"></i><span class="hidden sm:inline">Réservation & Devis</span><span class="inline sm:hidden">Devis</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.reservations') }}" class="inline-block px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm font-medium {{ request()->routeIs('client.reservations') ? 'text-wedding-pink border-b-2 border-wedding-pink' : 'text-gray-600 hover:text-wedding-pink hover:border-b-2 hover:border-wedding-pink' }}">
                            <i class="fas fa-calendar-check mr-1 sm:mr-2"></i><span class="hidden sm:inline">Services réservés</span><span class="inline sm:hidden">Réservés</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="flex-grow container mx-auto px-4 py-4 sm:py-8">
        <div class="text-xs sm:text-sm breadcrumbs mb-4 sm:mb-6 text-gray-500">
            <a href="{{ route('client.dashboard') }}" class="hover:text-wedding-pink">Tableau de bord</a>
            <span class="mx-2">›</span>
            <span>@yield('breadcrumb', 'Accueil')</span>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded shadow">
            @yield('content')
        </div>
    </main>

    {{-- Footer pour client --}}
    <footer class="bg-wedding-dark text-white py-8 sm:py-10 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4">mariages.net</h3>
                    <p class="text-xs sm:text-sm text-gray-300">Planifiez votre mariage parfait avec nos outils et services professionnels.</p>
                    <div class="mt-4 flex space-x-3">
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-300 hover:text-white"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4">Liens utiles</h3>
                    <ul class="text-xs sm:text-sm space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Guide de planification</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Idées et inspiration</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-3 sm:mb-4">Contact</h3>
                    <ul class="text-xs sm:text-sm space-y-2">
                        <li class="flex items-center"><i class="fas fa-envelope w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">clients@mariages.net</span></li>
                        <li class="flex items-center"><i class="fas fa-phone w-5 text-wedding-pink"></i> <span class="ml-2 text-gray-300">01 23 45 67 89</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-6 sm:mt-8 pt-4 sm:pt-6 text-center text-xs sm:text-sm text-gray-400">
                © 2023 Mariages.net - Tous droits réservés
            </div>
        </div>
    </footer>
@endif

<!-- Custom scrollbar style for overflow-x-auto -->
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Add screens for extra small devices */
    @media (min-width: 480px) {
        .xs\:inline {
            display: inline;
        }
        .xs\:hidden {
            display: none;
        }
    }
</style>

@stack('script')
<script>
    window.isAuthenticated = @json(Auth::check());
</script>
<script src="{{ asset('js/modalContact.js') }}"></script>
</body>
</html>
