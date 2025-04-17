<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Connexion - MariageDream</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-blur {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat relative"
      style="background-image: url('https://images.unsplash.com/photo-1504208434309-cb69f4fe52b0?auto=format&fit=crop&w=1950&q=80');">

<!-- Overlay -->
<div class="absolute inset-0 bg-black bg-opacity-50"></div>

<!-- Form Container -->
<div class="relative z-10 w-full max-w-sm p-4 bg-white bg-opacity-20 rounded-xl shadow-lg bg-blur">
    <div class="text-center mb-3">
        <h1 class="text-2xl font-bold text-white">MariageDream</h1>
        <p class="text-xs text-gray-200">Bienvenue ! Connectez-vous</p>
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
                class="w-full text-sm px-3 py-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold rounded-lg transition">
            Se connecter
        </button>
    </form>

    <p class="text-center text-xs text-white mt-3">
        Vous n’avez pas encore de compte ? <a href="{{ route('register') }}" class="text-pink-300 hover:text-pink-400 font-semibold">Inscription</a>
    </p>
</div>

</body>
</html>
