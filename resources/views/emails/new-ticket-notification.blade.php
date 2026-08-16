<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Nouvelle commande reçue</h2>
<p>Le client {{ $ticket->client->name }} ({{ $ticket->client->email }}) vient de déposer la commande #{{ $ticket->id }}.</p>
<p>Connectez-vous à l'espace gestionnaire pour la traiter.</p>
</body>
</html>
