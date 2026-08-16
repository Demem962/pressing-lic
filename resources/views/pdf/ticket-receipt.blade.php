<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        .total { font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>
<h1>Pressing LIC — Reçu</h1>
<p>Ticket n° {{ $ticket->id }}</p>
<p>Client : {{ $ticket->client->name }} ({{ $ticket->client->email }})</p>
<p>Date : {{ $ticket->created_at->format('d/m/Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>Service</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
        <th>Sous-total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($ticket->services as $service)
        <tr>
            <td>{{ $service->libelle }}</td>
            <td>{{ $service->pivot->quantite }}</td>
            <td>{{ $service->pivot->prix_unitaire }} €</td>
            <td>{{ $service->pivot->prix_unitaire * $service->pivot->quantite }} €</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p class="total">Total : {{ $ticket->montant_total }} €</p>

<p>Merci de votre confiance — Pressing LIC</p>
</body>
</html>
