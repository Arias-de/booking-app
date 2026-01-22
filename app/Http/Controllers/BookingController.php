<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AvailabilityService;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Show the public booking page for a professional.
     */
    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $services = $user->services;

        if ($services->isEmpty()) {
            abort(404, 'Ce professionnel n\'a pas encore de services disponibles.');
        }

        return view('booking.show', compact('user', 'services'));
    }

    /**
     * Store a new booking from the public page.
     */
    public function store(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'service_ids' => 'required_without:service_id|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'service_id' => 'required_without:service_ids|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $serviceIds = $request->has('service_ids')
            ? $validated['service_ids']
            : [$validated['service_id']];

        $services = $user->services()
            ->whereIn('id', $serviceIds)
            ->orderBy('id')
            ->get();

        if ($services->count() !== count($serviceIds)) {
            return back()
                ->withInput()
                ->withErrors(['service_ids' => 'Certains services sont invalides.']);
        }

        $totalDuration = $services->sum('duration');

        $availabilityService = new AvailabilityService();

        $check = $availabilityService->isSlotAvailable(
            $user->id,
            $validated['appointment_date'],
            $validated['appointment_time'],
            $totalDuration
        );

        if (!$check['available']) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => $check['reason']
                ]);
        }

        try {

            // ✅ RÉSERVATION SIMPLE
            if ($services->count() === 1) {
                $appointment = $this->createSingleAppointment(
                    $user,
                    $services->first(),
                    $validated
                );

                return redirect()
                    ->route('booking.success', $slug)
                    ->with('appointment_id', $appointment->id)
                    ->with('is_multiple', false);
            }

            // ✅ RÉSERVATION MULTIPLE (CORRIGÉE)
            $appointments = $this->createMultipleAppointments(
                $user,
                $services,
                $validated
            );

            $bookingGroupId = $appointments->first()->booking_group_id;

            return redirect()
                ->route('booking.success', $slug)
                ->with('booking_group_id', $bookingGroupId)
                ->with('is_multiple', true)
                ->with('total_price', $appointments->sum('service_price'));

        } catch (\Exception $e) {

            \Log::error('❌ Erreur réservation multiple', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' => 'Erreur lors de la création du rendez-vous. Veuillez réessayer.'
                ]);
        }
    }

    /**
     * Créer une réservation simple
     */
    private function createSingleAppointment($user, $service, $validated)
    {
        return Appointment::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'client_name' => $validated['client_name'],
            'client_phone' => $validated['client_phone'],
            'client_email' => $validated['client_email'] ?? null,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'service_price' => $service->price,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);
    }

    /**
     * Créer une réservation multiple (CORRIGÉE)
     */
    private function createMultipleAppointments($user, $services, $validated)
    {
        $bookingGroupId = Str::uuid()->toString();

        DB::beginTransaction();

        try {
            $currentTime = Carbon::parse(
                $validated['appointment_date'] . ' ' . $validated['appointment_time']
            );

            $appointments = collect();

            foreach ($services as $index => $service) {
                $appointment = Appointment::create([
                    'booking_group_id' => $bookingGroupId,
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'client_name' => $validated['client_name'],
                    'client_phone' => $validated['client_phone'],
                    'client_email' => $validated['client_email'] ?? null,
                    'appointment_date' => $validated['appointment_date'],
                    'appointment_time' => $currentTime->format('H:i:s'),
                    'service_price' => $service->price,
                    'status' => 'pending',
                    'notes' => $index === 0 ? ($validated['notes'] ?? null) : null,
                ]);

                $appointments->push($appointment);

                $currentTime->addMinutes($service->duration);
            }

            DB::commit();

            // 🔥 CORRECTION CLÉ : on retourne la collection brute
            return $appointments;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Success page
     */
    public function success($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $isMultiple = session('is_multiple', false);

        if ($isMultiple) {
            $bookingGroupId = session('booking_group_id');

            if (!$bookingGroupId) {
                abort(404, 'Réservation introuvable');
            }

            $appointments = Appointment::where('booking_group_id', $bookingGroupId)
                ->with('service')
                ->orderBy('appointment_time')
                ->get();

            $appointment = null;
            $totalPrice = session('total_price', $appointments->sum('service_price'));

        } else {
            $appointmentId = session('appointment_id');

            if (!$appointmentId) {
                abort(404, 'Réservation introuvable');
            }

            $appointment = Appointment::with('service')->findOrFail($appointmentId);
            $appointments = null;
            $totalPrice = 0;
        }

        return view(
            'booking.success',
            compact('user', 'isMultiple', 'appointment', 'appointments', 'totalPrice')
        );
    }
}
