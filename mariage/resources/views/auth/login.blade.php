<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Connexion - Mariage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative"
      style="background-image: url('https://images.unsplash.com/photo-1504208434309-cb69f4fe52b0?auto=format&fit=crop&w=1950&q=80');">

<!-- Overlay -->
<div class="absolute inset-0 bg-black bg-opacity-50"></div>

<!-- Form Container -->
<div class="relative z-10 w-full max-w-sm p-4 bg-white bg-opacity-20 rounded-xl shadow-lg bg-blur">
    <div class="text-center mb-3">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
            <img src="/images/img/logo.jpg" class="h-10 mr-2">
            <span class="text-xl font-medium text-gray-700">mariages</span>
        </a>
        <p class="text-white">Votre plateforme d’organisation de mariage</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        @if ($errors->any())
            <div class="text-red-300 text-xs mb-2">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>
            <label class="text-white text-xs block mb-1" for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-2 py-1.5 rounded bg-white bg-opacity-20 border border-gray-300 text-white text-sm placeholder-gray-300 focus:ring-1 focus:ring-pink-300"
                   placeholder="exemple@mail.com">
            @error('email')
            <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-white text-xs block mb-1" for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-2 py-1.5 rounded bg-white bg-opacity-20 border border-gray-300 text-white text-sm placeholder-gray-300 focus:ring-1 focus:ring-pink-300"
                   placeholder="••••••••">
            @error('password')
            <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full text-sm px-3 py-2 bg-wedding-pink hover:bg-pink-700 text-white font-semibold rounded-lg transition">
            Se connecter
        </button>
    </form>

    <p class="text-center text-xs text-white mt-3">
        Vous n’avez pas encore de compte ? <a href="{{ route('register') }}" class="text-wedding hover:text-wedding-pink font-semibold">Inscription</a>
    </p>
</div>

</body>
</html>
