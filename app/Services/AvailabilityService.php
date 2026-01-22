<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\BlockedSlot;
use Carbon\Carbon;

class AvailabilityService
{
    /**
     * Vérifier si un créneau est disponible.
     */
    public function isSlotAvailable($userId, $date, $time, $duration, $excludeAppointmentId = null)
    {
        // Convertir en objets Carbon
        $requestedStart = Carbon::parse($date . ' ' . $time);
        $requestedEnd = $requestedStart->copy()->addMinutes($duration);

        \Log::info('🔎 Vérification disponibilité', [
            'date' => $date,
            'time' => $time,
            'requested_start' => $requestedStart->toDateTimeString(),
            'requested_end' => $requestedEnd->toDateTimeString(),
        ]);

        // 1. Vérifier les rendez-vous existants
        $existingAppointments = Appointment::where('user_id', $userId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->when($excludeAppointmentId, function($query) use ($excludeAppointmentId) {
                return $query->where('id', '!=', $excludeAppointmentId);
            })
            ->with('service')
            ->get();

        \Log::info('📊 RDV trouvés', ['nombre' => $existingAppointments->count()]);

        foreach ($existingAppointments as $appointment) {
            // Construire le datetime complet
            $aptDate = $appointment->appointment_date instanceof Carbon
                ? $appointment->appointment_date->format('Y-m-d')
                : Carbon::parse($appointment->appointment_date)->format('Y-m-d');

            $aptTime = is_string($appointment->appointment_time)
                ? $appointment->appointment_time
                : Carbon::parse($appointment->appointment_time)->format('H:i:s');

            $appointmentStart = Carbon::parse($aptDate . ' ' . $aptTime);
            $appointmentEnd = $appointmentStart->copy()->addMinutes($appointment->service->duration);

            // Vérifier le chevauchement
            if ($this->timesOverlap($requestedStart, $requestedEnd, $appointmentStart, $appointmentEnd)) {
                \Log::warning('❌ CONFLIT DÉTECTÉ avec RDV #' . $appointment->id);

                return [
                    'available' => false,
                    'reason' => '⚠️ Ce créneau est déjà réservé par ' . $appointment->client_name .
                                ' de ' . $appointmentStart->format('H:i') . ' à ' . $appointmentEnd->format('H:i'),
                    'conflict_type' => 'appointment',
                    'conflicting_appointment' => $appointment,
                    'alternative_slots' => $this->getNextAvailableSlots($userId, $date, $duration, 3)
                ];
            }
        }

        // 2. Vérifier les créneaux bloqués
        $blockedSlots = BlockedSlot::where('user_id', $userId)
            ->whereDate('date', $date)
            ->get();

        \Log::info('🚫 Créneaux bloqués', ['nombre' => $blockedSlots->count()]);

        foreach ($blockedSlots as $blocked) {
            // ✅ CORRECTION : Extraire proprement la date et les heures
            $blockedDate = $blocked->date instanceof Carbon
                ? $blocked->date->format('Y-m-d')
                : Carbon::parse($blocked->date)->format('Y-m-d');

            // Extraire uniquement l'heure (même si c'est un datetime complet)
            $startTimeOnly = $blocked->start_time instanceof Carbon
                ? $blocked->start_time->format('H:i:s')
                : Carbon::parse($blocked->start_time)->format('H:i:s');

            $endTimeOnly = $blocked->end_time instanceof Carbon
                ? $blocked->end_time->format('H:i:s')
                : Carbon::parse($blocked->end_time)->format('H:i:s');

            // Construire les Carbon avec date + heure séparées
            $blockedStart = Carbon::parse($blockedDate . ' ' . $startTimeOnly);
            $blockedEnd = Carbon::parse($blockedDate . ' ' . $endTimeOnly);

            \Log::info('🔍 Vérification créneau bloqué', [
                'blocked_start' => $blockedStart->toDateTimeString(),
                'blocked_end' => $blockedEnd->toDateTimeString(),
            ]);

            if ($this->timesOverlap($requestedStart, $requestedEnd, $blockedStart, $blockedEnd)) {
                $reason = $blocked->reason
                    ? '🚫 Indisponible : ' . $blocked->reason
                    : '🚫 Le professionnel n\'est pas disponible à ce créneau';

                return [
                    'available' => false,
                    'reason' => $reason . ' (de ' . $blockedStart->format('H:i') . ' à ' . $blockedEnd->format('H:i') . ')',
                    'conflict_type' => 'blocked',
                    'alternative_slots' => $this->getNextAvailableSlots($userId, $date, $duration, 3)
                ];
            }
        }

        // 3. Créneau disponible !
        \Log::info('✅ CRÉNEAU DISPONIBLE - Aucun conflit');
        return [
            'available' => true,
            'reason' => null
        ];
    }

    /**
     * Vérifier si deux créneaux horaires se chevauchent.
     */
    private function timesOverlap($start1, $end1, $start2, $end2)
    {
        return $start1->lt($end2) && $end1->gt($start2);
    }

    /**
     * Obtenir les prochains créneaux disponibles.
     */
    public function getNextAvailableSlots($userId, $date, $duration, $count = 3)
    {
        $availableSlots = [];
        $currentTime = Carbon::parse($date . ' 09:00');
        $endOfDay = Carbon::parse($date . ' 19:00');
        $interval = 30;

        while ($currentTime->lt($endOfDay) && count($availableSlots) < $count) {
            $check = $this->isSlotAvailable(
                $userId,
                $date,
                $currentTime->format('H:i'),
                $duration
            );

            if ($check['available']) {
                $availableSlots[] = [
                    'time' => $currentTime->format('H:i'),
                    'formatted' => $currentTime->format('H:i')
                ];
            }

            $currentTime->addMinutes($interval);
        }

        return $availableSlots;
    }

    /**
     * Obtenir les prochains jours disponibles.
     */
    public function getNextAvailableDays($userId, $startDate, $duration, $daysToCheck = 7)
    {
        $availableDays = [];
        $currentDate = Carbon::parse($startDate)->addDay();

        for ($i = 0; $i < $daysToCheck; $i++) {
            $slots = $this->getNextAvailableSlots($userId, $currentDate->format('Y-m-d'), $duration, 1);

            if (!empty($slots)) {
                $availableDays[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'formatted' => $currentDate->locale('fr')->translatedFormat('l j F'),
                    'first_slot' => $slots[0]['time']
                ];
            }

            $currentDate->addDay();
        }

        return $availableDays;
    }
}
