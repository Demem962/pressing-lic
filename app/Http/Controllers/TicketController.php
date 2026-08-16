<?php

namespace App\Http\Controllers;

use App\Mail\TicketReadyMail;
use App\Mail\NewTicketNotificationMail;
use App\Mail\TicketConfirmationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with('services')
            ->where('client_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($tickets);
    }

    public function indexAll(Request $request)
    {
        $this->authorizeGestionnaire($request);

        $tickets = Ticket::with(['services', 'client'])->latest()->get();

        return response()->json($tickets);
    }

    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if ($ticket->client_id !== $user->id && !$user->isGestionnaire()) {
            abort(403, 'Accès non autorisé à ce ticket.');
        }

        $ticket->load(['services', 'client']);

        return response()->json($ticket);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'services' => 'required|array|min:1',
            'services.*.id' => 'required|exists:services,id',
            'services.*.quantite' => 'required|integer|min:1',
        ]);

        $serviceIds = collect($validated['services'])->pluck('id');
        $servicesActifs = Service::whereIn('id', $serviceIds)->where('active', true)->get()->keyBy('id');

        foreach ($serviceIds as $id) {
            if (!$servicesActifs->has($id)) {
                abort(422, "Le service #{$id} n'est pas disponible.");
            }
        }

        $ticket = Ticket::create([
            'client_id' => $request->user()->id,
            'status' => 'recu',
        ]);

        foreach ($validated['services'] as $item) {
            $service = $servicesActifs[$item['id']];
            $ticket->services()->attach($service->id, [
                'quantite' => $item['quantite'],
                'prix_unitaire' => $service->prix,
            ]);
        }

        $ticket->load(['services', 'client']);

        // Email de confirmation au client
        Mail::to($ticket->client->email)->send(new TicketConfirmationMail($ticket));

        // Notification au(x) gestionnaire(s)
        $gestionnaires = User::where('role', 'gestionnaire')->get();
        foreach ($gestionnaires as $gestionnaire) {
            Mail::to($gestionnaire->email)->send(new NewTicketNotificationMail($ticket));
        }

        return response()->json($ticket, 201);
    }

    public function updateStatut(Request $request, Ticket $ticket)
    {
        $this->authorizeGestionnaire($request);

        $validated = $request->validate([
            'status' => 'required|in:en_traitement,pret,recupere',
        ]);

        $ordreStatuts = ['recu', 'en_traitement', 'pret', 'recupere'];
        $indexActuel = array_search($ticket->status, $ordreStatuts);
        $indexDemande = array_search($validated['status'], $ordreStatuts);

        if ($indexDemande !== $indexActuel + 1) {
            abort(422, 'Transition de statut invalide. Le ticket est actuellement : ' . $ticket->status);
        }

        $ticket->update(['status' => $validated['status']]);

        if ($validated['status'] === 'pret') {
            $ticket->load(['services', 'client']);
            Mail::to($ticket->client->email)->send(new TicketReadyMail($ticket));
        }

        return response()->json($ticket);
    }

    public function cancel(Request $request, Ticket $ticket)
    {
        $this->authorizeGestionnaire($request);

        if (in_array($ticket->status, ['pret', 'recupere'])) {
            abort(422, 'Impossible d\'annuler un ticket déjà prêt ou récupéré.');
        }

        $ticket->update(['status' => 'annule']);

        return response()->json($ticket);
    }

    private function authorizeGestionnaire(Request $request): void
    {
        if (!$request->user() || !$request->user()->isGestionnaire()) {
            abort(403, 'Accès réservé au gestionnaire.');
        }
    }
}
