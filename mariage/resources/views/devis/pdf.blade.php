<!DOCTYPE html>
<html>
<head>
    <title>Devis N°{{ $devis->id }}</title>
    <style>
        /* Vos styles CSS ici */
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Devis N°{{ $devis->id }}</h1>
        <p>Date : {{ $devis->created_at->format('d/m/Y') }}</p>
    </div>
    <div class="details">
        <table>
            <tr>
                <td><strong>Client :</strong> {{ $devis->client->name }}</td>
                <td><strong>Prestataire :</strong> {{ $devis->prestataire->name }}</td>
            </tr>
            <tr>
                <td><strong>Service :</strong> {{ $devis->service->title }}</td>
                <td><strong>Catégorie :</strong> {{ $devis->category->name }}</td>
            </tr>
        </table>
    </div>
    <div class="items">
        <table>
            <thead>
            <tr>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Montant</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($devis->devisItems as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2, ',', ' ') }} €</td>
                    <td>{{ number_format($item->amount, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p><strong>Total :</strong> {{ number_format($totalAmount, 2, ',', ' ') }} €</p>
    </div>
</div>
</body>
</html>
