<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Mariages</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        wedding: {
                            primary: '#f87171',
                            secondary: '#ef5350',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap');
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Header -->
<header class="bg-white p-2 border-b flex justify-between items-center">
    <div class="text-lg font-semibold">Dashboard Admin</div>
</header>

<div class="flex">
    <!-- Sidebar -->
    <div class="hidden md:flex flex-col bg-wedding-primary text-white w-16 min-h-[calc(100vh-48px)] fixed">
        <div class="flex flex-col items-center gap-8 py-6">
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-home w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-users w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-building w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-bell w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-graduation-cap w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-chart-pie w-6 h-6 flex items-center justify-center"></i>
            </div>
            <div class="p-2 rounded-md hover:bg-wedding-secondary cursor-pointer">
                <i class="fas fa-sign-out-alt w-6 h-6 flex items-center justify-center"></i>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full md:ml-16 p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Content will be injected here -->
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
