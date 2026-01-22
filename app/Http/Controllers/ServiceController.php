<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les services de l'utilisateur connecté
        $services = auth()->user()->services;

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $validated['image'] = $imagePath;
        }

        // Créer le service pour l'utilisateur connecté
        auth()->user()->services()->create($validated);

        // Rediriger avec un message de succès
        return redirect()->route('services.index')
            ->with('success', 'Service créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // Vérifier que le service appartient à l'utilisateur connecté
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // Vérifier que le service appartient à l'utilisateur connecté
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Vérifier que le service appartient à l'utilisateur connecté
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $imagePath = $request->file('image')->store('services', 'public');
            $validated['image'] = $imagePath;
        }

        // Mettre à jour le service
        $service->update($validated);

        // Rediriger avec un message de succès
        return redirect()->route('services.index')
            ->with('success', 'Service modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Vérifier que le service appartient à l'utilisateur connecté
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        // Supprimer l'image si elle existe
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        // Supprimer le service
        $service->delete();

        // Rediriger avec un message de succès
        return redirect()->route('services.index')
            ->with('success', 'Service supprimé avec succès !');
    }
}
