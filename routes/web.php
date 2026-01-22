<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BlockedSlotController;  // ← VÉRIFIE QUE CETTE LIGNE EST LÀ
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil (publique)
Route::get('/', function () {
    return view('welcome');
});

// ✅ AJOUTEZ CETTE LIGNE
Route::post('/contact/specialization', [ContactController::class, 'store'])->name('contact.specialization');

// Routes publiques de réservation
Route::get('/booking/{slug}', [BookingController::class, 'show'])->name('booking.show');
Route::post('/booking/{slug}', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{slug}/success', [BookingController::class, 'success'])->name('booking.success');


// Dashboard (protégé)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes profil (protégées)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/logo', [ProfileController::class, 'updateLogo'])->name('profile.update.logo');  // ← AJOUTE
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes services, rendez-vous ET blocages (protégées)
Route::middleware(['auth'])->group(function () {
    // Services
    Route::resource('services', ServiceController::class);

    // Rendez-vous
    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
        ->name('appointments.updateStatus');

    // Créneaux bloqués
    Route::resource('blocked-slots', BlockedSlotController::class)->only(['index', 'create', 'store', 'destroy']);

     // Demandes de contact
    Route::get('/admin/contact-requests', [ContactController::class, 'index'])
        ->name('admin.contact-requests');
    Route::patch('/admin/contact-requests/{id}/read', [ContactController::class, 'markAsRead'])
        ->name('admin.contact-requests.read');
    Route::delete('/admin/contact-requests/{id}', [ContactController::class, 'destroy'])
        ->name('admin.contact-requests.destroy');

});

// Route de debug (à retirer en production)
Route::get('/debug-appointments', function () {
    return view('debug-appointments');
})->middleware('auth');

// Routes d'authentification
require __DIR__.'/auth.php';
