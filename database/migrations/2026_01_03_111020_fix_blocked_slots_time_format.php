<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up()
    {
        // Récupérer tous les blocked_slots
        $blockedSlots = DB::table('blocked_slots')->get();

        foreach ($blockedSlots as $slot) {
            // Extraire uniquement l'heure
            $startTime = Carbon::parse($slot->start_time)->format('H:i:s');
            $endTime = Carbon::parse($slot->end_time)->format('H:i:s');

            // Mettre à jour
            DB::table('blocked_slots')
                ->where('id', $slot->id)
                ->update([
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);
        }
    }

    public function down()
    {
        // Pas de rollback nécessaire
    }
};
