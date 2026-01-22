<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the user's appointments.
     */
    public function index()
{
    // Récupérer TOUS les RDV du professionnel (sans filtre)
    $appointments = auth()->user()
        ->appointments()
        ->with('service')
        ->orderBy('appointment_date', 'desc')
        ->orderBy('appointment_time', 'desc')
        ->get();

               // DEBUG TEMPORAIRE
    \Log::info('📅 Affichage page appointments', [
        'user_id' => auth()->id(),
        'nombre_rdv' => $appointments->count(),
        'rdv' => $appointments->map(function($apt) {
            return [
                'id' => $apt->id,
                'client' => $apt->client_name,
                'date' => $apt->appointment_date,
            ];
        })->toArray()
    ]);

    return view('appointments.index', compact('appointments'));
}

    /**
     * Show the form for creating a new appointment (admin side).
     */
    public function create()
    {
        $services = auth()->user()->services;
        return view('appointments.create', compact('services'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        // Vérifier que le service appartient au professionnel connecté
        $service = Service::findOrFail($validated['service_id']);
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        // Ajouter l'user_id
        $validated['user_id'] = auth()->id();

        // Créer le rendez-vous
        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous créé avec succès !');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        // Vérifier que le RDV appartient au professionnel
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Update the appointment status (confirm/cancel).
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Vérifier que le RDV appartient au professionnel
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Statut mis à jour avec succès !');
    }

    /**
     * Remove the specified appointment.
     */
    public function destroy(Appointment $appointment)
    {
        // Vérifier que le RDV appartient au professionnel
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous supprimé avec succès !');
    }
}
