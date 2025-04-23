<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis #{{ $devis->id }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #374151;
            line-height: 1.4;
            background-color: #ffffff;
            font-size: 13px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            position: relative;
        }

        .header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header-content {
            position: relative;
        }

        .logo-container {
            position: absolute;
            top: 0;
            right: 0;
        }

        .logo {
            width: 60px;
            height: 60px;
            background-color: #fce7f3;
            border-radius: 50%;
            text-align: center;
            line-height: 60px;
            color: #db2777;
            font-family: 'Georgia', serif;
            font-size: 16px;
        }

        h1 {
            font-family: 'Georgia', serif;
            font-size: 22px;
            color: #1f2937;
            margin-top: 0;
            margin-bottom: 5px;
        }

        h3 {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 5px;
        }

        .info-card {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .bg-rose {
            background-color: #fff1f2;
        }

        .bg-blue {
            background-color: #eff6ff;
        }

        .bg-slate {
            background-color: #f8fafc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th {
            background-color: #f3f4f6;
            padding: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            text-align: left;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        th:first-child, td:first-child {
            text-align: left;
        }

        th:last-child, td:last-child {
            text-align: right;
        }

        td:nth-child(2) {
            text-align: center;
        }

        td:nth-child(3) {
            text-align: right;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            margin-top: 15px;
            padding-top: 10px;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        }

        .total-section {
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            margin-bottom: 10px;
        }

        .total-container {
            float: right;
            text-align: right;
        }

        .status-container {
            margin-top: 10px;
        }

        .total-label {
            color: #9ca3af;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .total-amount {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }

        .status-confirmed {
            display: inline-block;
            background-color: #d1fae5;
            color: #065f46;
            padding: 6px 14px;
            border-radius: 8px;
        }

        .badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 9999px;
            color: #ffffff;
            background-color: #db2777;
            display: inline-block;
        }

        .conditions-section {
            margin-top: 20px;
            clear: both;
        }

        .contact-section {
            margin-top: 15px;
        }

        .text-small {
            font-size: 13px;
        }

        .text-italic {
            font-style: italic;
        }

        ul {
            padding-left: 18px;
            margin-top: 5px;
            color: #4b5563;
            font-size: 13px;
        }

        .page-break {
            page-break-after: always;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- En-tête du devis -->
    <div class="header">
        <div class="header-content">
            <div class="logo-container">
                <div class="logo">LOGO</div>
            </div>
            <h1>Devis #{{ $devis->id }}</h1>
            <p class="text-italic" style="color: #9ca3af; margin-top: 5px;">
                {{ $devis->created_at->format('d/m/Y') }}
            </p>
        </div>
    </div>

    <!-- Informations principales -->
    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
        <div class="info-card bg-rose" style="flex: 1 1 48%;">
            <h3>Client</h3>
            <p>{{ $client->name }}</p>
            <p>{{ $client->email }}</p>
        </div>

        <div class="info-card bg-blue" style="flex: 1 1 48%;">
            <h3>Date de l'événement</h3>
            <p>{{ $reservation->event_date->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="info-card bg-slate">
        <h3>Service réservé</h3>
        <p>{{ $service->title }}</p>
        <p class="text-small text-italic" style="color: #6b7280;">par {{ $service->user->name }}</p>
    </div>

    <!-- Tableau des éléments -->
    <div style="margin-bottom: 15px;">
        <h3>Éléments du devis</h3>
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
            @foreach($devis->devisItems as $item)
                <tr>
                    <td>{{ $item->service_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} €</td>
                    <td>{{ number_format($item->quantity * $item->unit_price, 2) }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Total et statut -->
    <div class="total-section clearfix">
        <div class="total-container">
            <p class="total-label">Total TTC</p>
            <p class="total-amount">{{ number_format($devis->total_amount, 2) }} €</p>
        </div>

        <div class="status-container">
            @if($devis->status === 'pending')
                <div class="badge">En attente de confirmation</div>
            @else
                <div class="status-confirmed">Devis confirmé</div>
            @endif
        </div>
    </div>

    <!-- Conditions et mentions -->
    <div class="conditions-section">
        <h3>Conditions</h3>
        <ul>
            <li>Ce devis est valable 30 jours à compter de sa date d'émission</li>
            <li>Un acompte de 30% sera demandé à la confirmation</li>
            <li>Le solde devra être réglé 15 jours avant la date de l'événement</li>
        </ul>
    </div>

    <div class="contact-section">
        <h3>Contact</h3>
        <p style="color: #4b5563; font-size: 13px;">
            contact@votreentreprise.com<br>
            +33 (0)1 23 45 67 89<br>
            www.votreentreprise.com
        </p>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Ce devis est valable 30 jours à compter de sa date d'émission.</p>
        <p style="margin-top: 5px; font-family: 'Georgia', serif;">Merci de nous avoir choisis pour votre jour spécial!</p>
    </div>
</div>
</body>
</html>
