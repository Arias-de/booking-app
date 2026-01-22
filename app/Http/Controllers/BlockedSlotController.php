<?php

namespace App\Http\Controllers;

use App\Models\BlockedSlot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BlockedSlotController extends Controller
{
    /**
     * Display a listing of the blocked slots.
     */
    public function index()
    {
        $blockedSlots = auth()->user()->blockedSlots()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('blocked-slots.index', compact('blockedSlots'));
    }

    /**
     * Show the form for creating a new blocked slot.
     */
    public function create()
    {
        return view('blocked-slots.create');
    }

    /**
     * Store a newly created blocked slot.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        // ✅ CORRECTION : Extraire uniquement l'heure au format H:i:s
        $startTime = Carbon::parse($validated['start_time'])->format('H:i:s');
        $endTime = Carbon::parse($validated['end_time'])->format('H:i:s');

        // Créer le créneau bloqué avec les heures formatées
        auth()->user()->blockedSlots()->create([
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'reason' => $validated['reason'] ?? null,
        ]);

        \Log::info('✅ Créneau bloqué créé', [
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->route('blocked-slots.index')
            ->with('success', 'Créneau bloqué avec succès !');
    }

    /**
     * Remove the specified blocked slot.
     */
    public function destroy(BlockedSlot $blockedSlot)
    {
        // Vérifier que le blocage appartient à l'utilisateur
        if ($blockedSlot->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        $blockedSlot->delete();

        return redirect()->route('blocked-slots.index')
            ->with('success', 'Créneau débloqué avec succès !');
    }
}
