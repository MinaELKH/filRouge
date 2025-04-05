<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Devis N°{{ $devis->id }}</title>
    <style>
        /* Styles généraux */
        body {
            font-family: 'Georgia', serif;
            background-color: #fdf7f7;
            color: #5a5a5a;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        /* En-tête */
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f3d9df;
        }
        .header h1 {
            font-size: 2.5em;
            color: #d16b86;
            margin: 0;
        }
        .header p {
            font-size: 1.2em;
            color: #a5a5a5;
        }
        /* Détails */
        .details {
            margin: 20px 0;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 10px;
            vertical-align: top;
        }
        .details td:first-child {
            width: 50%;
        }
        /* Articles */
        .items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items th, .items td {
            border: 1px solid #f3d9df;
            padding: 12px;
            text-align: left;
        }
        .items th {
            background-color: #fbeaec;
            color: #d16b86;
        }
        .items tr:nth-child(even) {
            background-color: #fdf2f4;
        }
        /* Pied de page */
        .footer {
            text-align: right;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #f3d9df;
        }
        .footer p {
            font-size: 1.5em;
            color: #d16b86;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- En-tête -->
    <div class="header">
        <h1>Devis N°{{ $devis->id }}</h1>
        <p>Date : {{ $devis->created_at->format('d/m/Y') }}</p>
    </div>
    <!-- Détails du client et du prestataire -->
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
    <!-- Liste des articles -->
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
    <!-- Total -->
    <div class="footer">
        <p><strong>Total :</strong> {{ number_format($totalAmount, 2, ',', ' ') }} €</p>
    </div>
</div>
</body>
</html>
