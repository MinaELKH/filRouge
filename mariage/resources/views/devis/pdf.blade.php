<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis #{{ $devis->id }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 1cm;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #374151;
            line-height: 1.3;
            background-color: #ffffff;
            font-size: 12px;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100%;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 0 150px 0; /* Augmenté l'espace pour inclure les conditions */
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
            width: 50px;
            height: 50px;
            background-color: rgba(247, 108, 111, 0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            color: #f76c6f;
            font-weight: bold;
            font-size: 14px;
        }

        h1 {
            font-size: 20px;
            color: #f76c6f;
            margin-top: 0;
            margin-bottom: 5px;
            font-weight: bold;
        }

        h3 {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 4px;
            margin-top: 0;
            font-weight: 500;
        }

        .info-card {
            padding: 8px;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        .bg-wedding-pink {
            background-color: rgba(247, 108, 111, 0.05);
        }

        .bg-gray {
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th {
            background-color: rgba(247, 108, 111, 0.05);
            padding: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #f76c6f;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
            text-align: center;
        }

        th:first-child, td:first-child {
            text-align: left;
        }

        th:last-child, td:last-child {
            text-align: right;
        }

        tfoot td {
            font-weight: 500;
            padding: 4px 6px;
            font-size: 12px;
        }

        tfoot tr:last-child {
            background-color: rgba(247, 108, 111, 0.05);
        }

        tfoot tr:last-child td {
            color: #f76c6f;
            font-weight: bold;
        }

        .footer {
            position: absolute;
            /*background-color: #f9fafb;*/
            bottom: 0;
            left: 0;
            right: 0;
            padding-top: 10px;
            color: #9ca3af;
            font-size: 11px;
            height: 140px; /* Hauteur augmentée pour inclure les conditions */
        }

        .footer-grid {
            display: table;
            border-top: 1px solid #e5e7eb;
            width: 100%;
            margin-bottom: 8px;
        }

        .footer-column {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
        }

        .footer-column:nth-child(2) {
            text-align: center;
        }

        .footer-column:nth-child(3) {
            text-align: right;
        }

        .total-section {
            padding-top: 10px;
            margin-bottom: 10px;
        }

        .total-container {
            text-align: right;
            width: 100%;
        }

        .total-label {
            color: #9ca3af;
            font-size: 11px;
            margin-bottom: 2px;
        }

        .total-amount {
            font-size: 18px;
            font-weight: 600;
            color: #f76c6f;
            margin-top: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 500;
            margin-left: 5px;
            vertical-align: middle;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .conditions {
            margin-top: 0;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        ul {
            padding-left: 15px;
            margin-top: 4px;
            margin-bottom: 4px;
            /*color: #4b5563;*/
            font-size: 11px;
        }

        li {
            margin-bottom: 2px;
        }

        .page-break {
            page-break-after: always;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .document-reference {
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }

        p {
            margin: 2px 0;
        }

        .compact-table td, .compact-table th {
            padding: 4px 6px;
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
            <h1>Devis #{{ $devis->id }}
                <span class="status-badge {{ $devis->status === 'pending' ? 'status-pending' : 'status-confirmed' }}">
                    {{ $devis->status === 'pending' ? 'En attente' : 'Confirmé' }}
                </span>
            </h1>
            <p style="color: #6b7280; margin-top: 2px; font-size: 11px;">
                Émis le {{ $devis->created_at->format('d/m/Y') }}
            </p>
        </div>
    </div>

    <!-- Informations principales -->
    <div style="margin-bottom: 10px;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 0;">
            <tr>
                <td width="48%" valign="top">
                    <div class="info-card bg-wedding-pink">
                        <h3 style="color: #f76c6f;">Client</h3>
                        <p style="margin-top: 5px; margin-bottom: 2px;"><strong>{{ $client->name }}</strong></p>
                        <p style="margin-top: 0; color: #6b7280; font-size: 11px;">{{ $client->email }}</p>
                    </div>
                </td>
                <td width="4%"></td>
                <td width="48%" valign="top">
                    <div class="info-card bg-gray">
                        <h3>Événement</h3>
                        <p style="margin-top: 5px; margin-bottom: 2px;"><strong>Date:</strong> {{ $reservation->event_date->format('d/m/Y') }}</p>
                        <p style="margin-top: 0; margin-bottom: 0; font-size: 11px;"><strong>Lieu:</strong> {{ $service->ville->name ?? 'Non spécifié' }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info-card bg-gray" style="margin-bottom: 10px;">
        <h3>Service réservé</h3>
        <p style="margin-top: 5px; margin-bottom: 2px;"><strong>{{ $service->title }}</strong></p>
        <p style="margin-top: 0; color: #6b7280; font-size: 11px;">par {{ $service->user->name }}</p>
    </div>

    <!-- Tableau des éléments -->
    <div style="margin-bottom: 10px;">
        <h3>Éléments du devis</h3>
        <table class="compact-table">
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
            <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;">Total HT</td>
                <td>{{ number_format($devis->total_amount / 1.2, 2) }} €</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">TVA (20%)</td>
                <td>{{ number_format($devis->total_amount - ($devis->total_amount / 1.2), 2) }} €</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">Total TTC</td>
                <td>{{ number_format($devis->total_amount, 2) }} €</td>
            </tr>
            </tfoot>
        </table>
    </div>

    <!-- Total -->
    <div class="total-section">
        <div class="total-container">
            <p class="total-label">Total TTC</p>
            <p class="total-amount">{{ number_format($devis->total_amount, 2) }} €</p>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <!-- Conditions dans le footer -->
        <div class="conditions">
            <h3 style="margin-top: 0; color: #f76c6f; font-size: 12px;">Conditions de paiement</h3>
            <ul>
                <li>Ce devis est valable 30 jours à compter de sa date d'émission</li>
                <li>Un acompte de 30% sera demandé à la confirmation</li>
                <li>Le solde devra être réglé 7 jours avant la date de l'événement</li>
            </ul>
        </div>

        <div class="footer-grid">
            <div class="footer-column">
                <p style="font-weight: 500; color: #6b7280; margin-bottom: 3px;">Contact prestataire</p>
                <p style="margin-top: 0; color: #6b7280; font-size: 10px;">
                    Tél: {{ $service->user->phone ?? '01 23 45 67 89' }}<br>
                    Email: {{ $service->user->email ?? 'contact@mariages.net' }}
                </p>
            </div>
            <div class="footer-column">
                <p style="font-size: 10px;">Ce devis est valable 30 jours à compter de sa date d'émission.</p>
                <p style="margin-top: 2px; font-size: 9px;">Tous les prix sont en euros et TTC.</p>
            </div>
            <div class="footer-column">
                <p style="font-size: 10px;">Merci de nous avoir choisis pour votre jour spécial!</p>
                <p style="margin-top: 2px; color: #f76c6f; font-weight: 500; font-size: 11px;">mariages.net</p>
            </div>
        </div>

        <div class="document-reference">
            Devis #{{ $devis->id }} | Généré le {{ now()->format('d/m/Y') }} | mariages.net
        </div>
    </div>
</div>
</body>
</html>
