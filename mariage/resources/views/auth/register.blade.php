<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Inscription </title>
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
      style="background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), url('/images/img/login.jpg');">


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

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf

        @if ($errors->any())
            <div class="text-red-300 text-xs">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>
            <label class="text-white text-xs block mb-1" for="name">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full px-2 py-1.5 rounded bg-white bg-opacity-20 border border-gray-300 text-white text-sm placeholder-gray-300 focus:ring-1 focus:ring-pink-300"
                   placeholder="Votre nom">
            @error('name')
            <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
            @enderror
        </div>

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

        <div>
            <label class="text-white text-xs block mb-1" for="confirm_password">Confirmer</label>
            <input type="password" id="confirm_password" name="password_confirmation" required
                   class="w-full px-2 py-1.5 rounded bg-white bg-opacity-20 border border-gray-300 text-white text-sm placeholder-gray-300 focus:ring-1 focus:ring-pink-300"
                   placeholder="••••••••">
        </div>

        <div>
            <span class="block text-white text-xs mb-1">Vous êtes :</span>
            <div class="flex gap-4 text-sm">
                <label class="inline-flex items-center text-white">
                    <input type="radio" name="role" value="client" {{ old('role') == 'client' ? 'checked' : '' }} required class="form-radio text-pink-500">
                    <span class="ml-1">Client</span>
                </label>
                <label class="inline-flex items-center text-white">
                    <input type="radio" name="role" value="prestataire" {{ old('role') == 'prestataire' ? 'checked' : '' }} required class="form-radio text-pink-500">
                    <span class="ml-1">Prestataire</span>
                </label>
            </div>
            @error('role')
            <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-white text-xs block mb-1" for="avatar">Photo (optionnel)</label>
            <input type="file" id="avatar" name="avatar" accept="image/*"
                   class="w-full text-sm text-white px-2 py-1.5 rounded bg-white bg-opacity-20 border border-gray-300">
            @error('avatar')
            <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full text-sm px-3 py-2 bg-wedding-pink hover:bg-pink-700 text-white font-semibold rounded-lg transition">
            S'inscrire
        </button>
    </form>

    <p class="text-center text-xs text-white mt-3">
        Déjà inscrit ? <a href="{{ route('login') }}" class="text-pink-300 hover:text-pink-400 font-semibold">Connexion</a>
    </p>
</div>

</body>
</html>
