<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Pour grouper les réservations multiples
            $table->string('booking_group_id')->nullable()->after('id');
            $table->index('booking_group_id');

            // Pour stocker le prix au moment de la réservation
            $table->decimal('service_price', 8, 2)->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['booking_group_id', 'service_price']);
        });
    }
};
