<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon espace client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.24/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-white shadow p-4">
    <div class="container mx-auto">
        <h1 class="text-xl font-semibold text-gray-800">Bienvenue dans votre espace client</h1>
    </div>
</header>

<!-- Contenu principal -->
<main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Menu client -->
        <aside class="bg-white p-4 rounded shadow">
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('client.dashboard') }}" class="text-blue-600 hover:underline">Mon espace</a></li>
                <li><a href="{{ route('client.profile') }}" class="text-blue-600 hover:underline">Mes informations</a></li>
                <li><a href="{{ route('client.tasks') }}" class="text-blue-600 hover:underline">Tâches</a></li>
                <li><a href="{{ route('client.favorites') }}" class="text-blue-600 hover:underline">Favoris</a></li>
                <li><a href="{{ route('client.devis') }}" class="text-blue-600 hover:underline">Devis</a></li>
                <li><a href="{{ route('client.reservations') }}" class="text-blue-600 hover:underline">Services réservés</a></li>
            </ul>
        </aside>

        <!-- Contenu dynamique -->
        <section class="md:col-span-3 bg-white p-6 rounded shadow">
            @yield('content')
        </section>
    </div>
</main>

</body>
</html>
