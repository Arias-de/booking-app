<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
         'booking_group_id',      // ← NOUVEAU
        'user_id',
        'service_id',
        'client_name',
        'client_phone',
        'client_email',
        'appointment_date',
        'appointment_time',
        'service_price',         // ← NOUVEAU
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     */
   protected $casts = [
    'appointment_date' => 'date',
    // PAS de cast pour appointment_time - on le laisse comme string TIME
];

    /**
     * Get the user (professional) that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service for this appointment.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope a query to only include pending appointments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appointments.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include today's appointments.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    /**
     * Scope a query to only include upcoming appointments.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today())
                     ->orderBy('appointment_date')
                     ->orderBy('appointment_time');
    }
}
