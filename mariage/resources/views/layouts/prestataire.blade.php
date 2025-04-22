<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Prestataire')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">

{{-- Header commun --}}
<header class="container mx-auto px-4 py-6">
    <div class="flex items-center">
        <a href="#" class="flex items-center">

            <span class="ml-2 text-gray-800 font-semibold">mariages.net</span>
        </a>
    </div>
    <nav class="mt-8">
        <ul class="flex space-x-8">
            <li><a href="#" class="text-sm text-gray-800 hover:text-gray-600">Accueil</a></li>
            <li><a href="{{route('prestataire.services')}}" class="text-sm text-gray-800 hover:text-gray-600">Ma Vitrine</a></li>
            <li><a href="{{ route('devisPrestataire') }}"  class="text-sm text-gray-800 hover:text-gray-600">Devis</a></li>
            <li><a href="{{ route('messages.index') }}" class="text-sm text-gray-800 hover:text-gray-600">Message</a></li>
        </ul>
    </nav>
</header>

{{-- Contenu dynamique --}}
<main class="container mx-auto px-4 py-8">
    @yield('content')
</main>

{{-- Footer commun --}}
<footer class="bg-gray-100 py-8">
    <div class="container mx-auto px-4 text-center text-sm text-gray-600">
        © 2023 Mariages.net
    </div>
</footer>


@yield('scripts')
</body>
</html>
