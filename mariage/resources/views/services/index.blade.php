<!DOCTYPE html>
<html>
<head>
    <title>Liste des Services</title>
    <!-- Inclure vos fichiers CSS ici -->
</head>
<body>
<h1>Liste des Services</h1>
<ul>
    @foreach ($services as $service)
        <li>{{ $service['title'] }} - {{ $service['price'] }} €</li>
        <!-- Ajoutez d'autres détails si nécessaire -->
    @endforeach
</ul>
</body>
</html>
