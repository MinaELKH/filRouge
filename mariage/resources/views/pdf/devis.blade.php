<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis #{{ $devis->id }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
<h1>Devis #{{ $devis->id }}</h1>
<p>Date : {{ $devis->created_at->format('d/m/Y') }}</p>
<p>Total : {{ number_format($devis->total_amount, 2) }} €</p>

<h3>Éléments :</h3>
<table>
    <thead>
    <tr>
        <th>Service</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($devis->items as $item)
        <tr>
            <td>{{ $item->service_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->unit_price, 2) }} €</td>
            <td>{{ number_format($item->quantity * $item->unit_price, 2) }} €</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
