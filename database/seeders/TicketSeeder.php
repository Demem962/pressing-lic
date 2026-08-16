<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::where('email', 'client.demo@pressinglic.com')->first();
        $services = Service::where('active', true)->get();

        if (!$client || $services->isEmpty()) {
            return;
        }

        $exemples = [
            ['statut' => 'recu', 'items' => [[0, 2]]],
            ['statut' => 'en_traitement', 'items' => [[1, 1], [2, 3]]],
            ['statut' => 'pret', 'items' => [[3, 1]]],
        ];

        foreach ($exemples as $exemple) {
            $ticket = Ticket::create([
                'client_id' => $client->id,
                'status' => $exemple['statut'],
            ]);

            foreach ($exemple['items'] as [$index, $quantite]) {
                $service = $services[$index] ?? $services->first();
                $ticket->services()->attach($service->id, [
                    'quantite' => $quantite,
                    'prix_unitaire' => $service->prix,
                ]);
            }
        }
    }
}
