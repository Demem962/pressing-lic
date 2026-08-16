<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Pressing LIC — Confirmation de commande</h2>
<p>Bonjour {{ $ticket->client->name }},</p>
<p>Votre commande #{{ $ticket->id }} a bien été reçue et est en cours de traitement.</p>

<table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse;">
    <thead>
    <tr>
        <th>Service</th>
        <th>Quantité</th>
        <th>Prix unitaire</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($ticket->services as $service)
        <tr>
            <td>{{ $service->libelle }}</td>
            <td>{{ $service->pivot->quantite }}</td>
            <td>{{ $service->pivot->prix_unitaire }} €</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p>Merci de votre confiance.</p>
<p>Pressing LIC</p>
</body>
</html>
