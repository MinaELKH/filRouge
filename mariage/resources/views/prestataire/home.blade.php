<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mariages.net - Informations entreprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .editor-button {
            @apply border border-gray-300 p-2 rounded hover:bg-gray-100;
        }
    </style>
</head>
<body class="bg-white">
<!-- Header -->
<header class="container mx-auto px-4 py-6">
    <div class="flex items-center">
        <a href="#" class="flex items-center">
            <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"></path>
            </svg>
            <span class="ml-2 text-gray-800 font-semibold">mariages.net</span>
        </a>
    </div>

    <nav class="mt-8">
        <ul class="flex space-x-8">
            <li><a href="#" class="text-sm text-gray-800 hover:text-gray-600">Accueil</a></li>
            <li><a href="#" class="text-sm text-gray-800 hover:text-gray-600">Ma Vitrine</a></li>
            <li><a href="#" class="text-sm text-gray-800 hover:text-gray-600">Devis</a></li>
        </ul>
    </nav>
</header>

<main class="container mx-auto px-4 py-8">
    <!-- Business Information Section -->
    <section class="mb-12">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Informations entreprise</h1>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Company Card -->
            <div class="w-full md:w-1/4">
                <div class="bg-gray-400 p-8 flex items-center justify-center">
                    <h2 class="text-white font-bold">FARHATKOM</h2>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-sm text-gray-800">Voir ma vitrine</a>
                </div>
            </div>

            <!-- Information Form -->
            <div class="w-full md:w-3/4">
                <div class="mb-8">
                    <div class="flex items-start gap-4">
                        <div class="bg-gray-100 p-3 rounded-md">
                            <i class="fas fa-file-alt text-gray-500"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Ajoutez les informations générales sur votre entreprise</h3>
                            <p class="text-sm text-gray-600">Cette section réunit toutes vos informations. Vous pouvez les modifier à tout moment. N'oubliez pas de les tenir à jour.</p>
                        </div>
                    </div>
                </div>

                <!-- Access Codes -->
                <div class="mb-8">
                    <h3 class="font-semibold text-gray-800 mb-4">Codes d'accès</h3>
                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-600 mb-1">Identifiant</label>
                        <p class="text-sm">yosooo6</p>
                    </div>
                </div>

                <!-- Business Description -->
                <div class="mb-8">
                    <h3 class="font-semibold text-gray-800 mb-4">Décrivez votre entreprise</h3>
                    <div class="border border-gray-300 rounded-md">
                        <div class="flex border-b border-gray-300 p-2">
                            <button class="editor-button mr-1">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button class="editor-button mr-1">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button class="editor-button mr-1">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button class="editor-button mr-1">
                                <i class="fas fa-list-ol"></i>
                            </button>
                            <button class="editor-button mr-1">
                                <i class="fas fa-outdent"></i>
                            </button>
                            <button class="editor-button">
                                <i class="fas fa-indent"></i>
                            </button>
                        </div>
                        <div class="p-4 min-h-[200px]">
                            <!-- Editor content area -->
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mb-8">
                    <h3 class="font-semibold text-gray-800 mb-4">Vos coordonnées</h3>

                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-600 mb-1">Personne à contacter</label>
                        <input type="text" value="mina" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-600 mb-1">E-mail</label>
                        <input type="email" value="mina@gmail.com" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-600 mb-1">Téléphone</label>
                        <div class="flex gap-2">
                            <select class="border border-gray-300 rounded-md p-2 text-sm">
                                <option>Autre</option>
                            </select>
                            <input type="tel" value="0606060606" class="flex-1 border border-gray-300 rounded-md p-2 text-sm">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs uppercase text-gray-600 mb-1">Adresse</label>
                        <input type="text" value="mina@gmail.com" class="w-full border border-gray-300 rounded-md p-2 text-sm">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Footer Links -->
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-4">Informations</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Contact</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Mentions légales</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Protection des données</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Gestion des cookies</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Centre de transparence</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Centre juridique</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Inscription entreprises</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Qui sommes-nous ?</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Équipe Éditoriale</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Careers</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Wedding Awards 2024</a></li>
                    <li><a href="#" class="text-sm text-gray-600 hover:text-gray-800">Site de mariage</a></li>
                </ul>
            </div>

            <!-- City Selection and Social Media -->
            <div>
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-800 mb-2">Sélectionnez la ville</h4>
                    <select class="w-full border border-gray-300 rounded-md p-2 text-sm">
                        <option>CASABLANCA</option>
                    </select>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-2">Suivez-nous sur</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-pinterest"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-600">
            © 2023 Mariages.net
        </div>
    </div>
</footer>

<script>
    // Simple JavaScript to handle the editor functionality
    document.addEventListener('DOMContentLoaded', function() {
        const editorButtons = document.querySelectorAll('.editor-button');
        const editorContent = document.querySelector('.editor-button').parentElement.nextElementSibling;

        editorButtons.forEach(button => {
            button.addEventListener('click', function() {
                // This is a simplified version - in a real implementation,
                // you would apply the formatting to the selected text
                button.classList.toggle('bg-gray-200');
            });
        });
    });
</script>
</body>
</html>
