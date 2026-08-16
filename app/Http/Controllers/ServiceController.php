<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('active', true)->get();

        return response()->json($services);
    }

    public function indexAll(Request $request)
    {
        $this->authorizeGestionnaire($request);

        $services = Service::all();

        return response()->json($services);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function store(Request $request)
    {
        $this->authorizeGestionnaire($request);

        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'active' => 'boolean',
        ]);

        $service = Service::create($validated);

        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $this->authorizeGestionnaire($request);

        $validated = $request->validate([
            'libelle' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'sometimes|required|numeric|min:0',
            'active' => 'boolean',
        ]);

        $service->update($validated);

        return response()->json($service);
    }

    public function archive(Request $request, Service $service)
    {
        $this->authorizeGestionnaire($request);

        $service->update(['active' => false]);

        return response()->json($service);
    }

    public function destroy(Request $request, Service $service)
    {
        $this->authorizeGestionnaire($request);

        $service->delete();

        return response()->json(['message' => 'Service supprimé']);
    }

    private function authorizeGestionnaire(Request $request): void
    {
        if (!$request->user() || !$request->user()->isGestionnaire()) {
            abort(403, 'Accès réservé au gestionnaire.');
        }
    }
}
