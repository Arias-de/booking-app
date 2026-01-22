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
        Schema::create('services', function (Blueprint $table) {
            $table->id();                              // Colonne id (auto-increment)
            $table->foreignId('user_id')               // Colonne user_id (lien vers users)
                  ->constrained()                      // Crée la contrainte de clé étrangère
                  ->onDelete('cascade');               // Si on supprime le user, supprimer ses services
            $table->string('name');                    // Nom du service (ex: "Coupe homme")
            $table->text('description')->nullable();   // Description (optionnel)
            $table->integer('duration');               // Durée en minutes
            $table->decimal('price', 8, 2);           // Prix (8 chiffres, 2 décimales) ex: 999999.99
            $table->timestamps();                      // created_at + updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
