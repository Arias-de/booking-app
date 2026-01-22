<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('user_id')                    // Le professionnel
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('service_id')                 // Le service
                  ->constrained()
                  ->onDelete('cascade');

            // Informations du client
            $table->string('client_name');                  // Nom du client
            $table->string('client_phone');                 // Téléphone
            $table->string('client_email')->nullable();     // Email (optionnel)

            // Date et heure du rendez-vous
            $table->date('appointment_date');               // Date (ex: 2025-12-30)
            $table->time('appointment_time');               // Heure (ex: 14:30)

            // Statut du rendez-vous
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                  ->default('pending');                     // Par défaut : en attente

            // Notes optionnelles
            $table->text('notes')->nullable();              // Notes du client

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
