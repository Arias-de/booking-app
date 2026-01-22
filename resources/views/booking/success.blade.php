<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation confirmée</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">

    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-2xl w-full">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

                <!-- Header avec gradient -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 text-center">
                    <!-- Icône de succès -->
                    <div class="mb-4">
                        <div class="mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>

                    <h1 class="text-4xl font-bold text-white mb-2">
                        @if($isMultiple)
                            🎉 {{ count($appointments) }} services réservés !
                        @else
                            🎉 Réservation envoyée !
                        @endif
                    </h1>

                    <p class="text-green-100">
                        @if($isMultiple)
                            Vos rendez-vous ont bien été enregistrés
                        @else
                            Votre demande de rendez-vous a bien été envoyée
                        @endif
                    </p>
                </div>

                <div class="p-8">

                    @if($isMultiple)
                        <!-- RÉSERVATION MULTIPLE -->
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Vos {{ count($appointments) }} services réservés
                            </h3>

                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-5 space-y-3 mb-6">
                                @foreach($appointments as $index => $apt)
                                    <div class="bg-white rounded-lg p-4 shadow-sm {{ $index > 0 ? 'border-l-4 border-purple-400' : '' }}">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                        Service {{ $index + 1 }}
                                                    </span>
                                                    @if($index > 0)
                                                        <span class="text-xs text-gray-500">↳ Enchaîné après</span>
                                                    @endif
                                                </div>
                                                <h4 class="font-bold text-lg text-gray-800 mb-2">{{ $apt->service->name }}</h4>
                                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                                    <span>🕐 {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}</span>
                                                    <span>⏱️ {{ $apt->service->duration }} min</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-purple-600">
                                                    {{ number_format($apt->service_price, 0, ',', ' ') }} FCFA
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Total -->
                                <div class="border-t-2 border-purple-300 pt-4 mt-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-600">Durée totale</p>
                                            <p class="text-xl font-bold text-purple-800">
                                                {{ $appointments->sum(fn($a) => $a->service->duration) }} minutes
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Prix total</p>
                                            <p class="text-2xl font-bold text-pink-600">
                                                {{ number_format($totalPrice, 0, ',', ' ') }} FCFA
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Timeline -->
                                <div class="mt-4 bg-white/50 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-gray-700 mb-2">📍 Déroulement :</p>
                                    <div class="flex items-center gap-2 text-sm overflow-x-auto">
                                        @foreach($appointments as $index => $apt)
                                            <div class="flex items-center gap-2">
                                                <div class="bg-purple-600 text-white px-3 py-1 rounded-full whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}
                                                </div>
                                                @if($index < count($appointments) - 1)
                                                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="bg-green-600 text-white px-3 py-1 rounded-full">✓ Fin</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informations client -->
                        <div class="bg-gray-50 rounded-xl p-5 mb-6">
                            <h3 class="font-bold text-gray-800 mb-3">📋 Vos informations</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-semibold">Nom :</span> {{ $appointments->first()->client_name }}</p>
                                <p><span class="font-semibold">Téléphone :</span> {{ $appointments->first()->client_phone }}</p>
                                @if($appointments->first()->client_email)
                                    <p><span class="font-semibold">Email :</span> {{ $appointments->first()->client_email }}</p>
                                @endif
                                <p><span class="font-semibold">Date :</span> {{ \Carbon\Carbon::parse($appointments->first()->appointment_date)->locale('fr')->translatedFormat('l j F Y') }}</p>
                            </div>
                        </div>

                    @else
                        <!-- RÉSERVATION SIMPLE -->
                        @if($appointment)
                            <div class="mb-6">
                                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 mb-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-4">📅 Votre rendez-vous</h3>

                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">💼</span>
                                            <div>
                                                <p class="text-sm text-gray-600">Service</p>
                                                <p class="font-bold text-gray-800">{{ $appointment->service->name }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">📅</span>
                                            <div>
                                                <p class="text-sm text-gray-600">Date</p>
                                                <p class="font-bold text-gray-800">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->locale('fr')->translatedFormat('l j F Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">🕐</span>
                                            <div>
                                                <p class="text-sm text-gray-600">Heure</p>
                                                <p class="font-bold text-gray-800">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">💰</span>
                                            <div>
                                                <p class="text-sm text-gray-600">Prix</p>
                                                <p class="text-xl font-bold text-purple-600">
                                                    {{ number_format($appointment->service_price, 0, ',', ' ') }} FCFA
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations client -->
                                <div class="bg-gray-50 rounded-xl p-5 mb-6">
                                    <h3 class="font-bold text-gray-800 mb-3">📋 Vos informations</h3>
                                    <div class="space-y-2 text-sm">
                                        <p><span class="font-semibold">Nom :</span> {{ $appointment->client_name }}</p>
                                        <p><span class="font-semibold">Téléphone :</span> {{ $appointment->client_phone }}</p>
                                        @if($appointment->client_email)
                                            <p><span class="font-semibold">Email :</span> {{ $appointment->client_email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Message important -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
                        <p class="text-blue-800 text-sm">
                            <strong>📞 Prochaine étape :</strong><br>
                            <strong>{{ $user->name }}</strong> va confirmer
                            @if($isMultiple)
                                vos {{ count($appointments) }} rendez-vous
                            @else
                                votre rendez-vous
                            @endif
                            et vous contacter par téléphone.
                        </p>
                    </div>

                    @if($isMultiple)
                        <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg p-4 mb-6">
                            <p class="text-amber-800 text-sm">
                                <strong>💡 Info importante :</strong><br>
                                Vos services seront effectués l'un après l'autre sans interruption. Merci d'arriver à l'heure pour profiter pleinement de votre session !
                            </p>
                        </div>
                    @endif

                    <!-- Boutons d'action -->
                    <div class="flex gap-4">
                        <a href="{{ route('booking.show', $user->slug) }}"
                           class="flex-1 text-center bg-gradient-to-r from-purple-500 to-pink-600 text-white py-3 rounded-xl font-bold hover:from-purple-600 hover:to-pink-700 transition">
                            Nouvelle réservation
                        </a>
                        <button onclick="window.print()"
                                class="flex-1 bg-gray-600 text-white py-3 rounded-xl font-bold hover:bg-gray-700 transition">
                            📄 Imprimer
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500">
                            Vous pouvez fermer cette page en toute sécurité.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { background: white; }
            button, .no-print { display: none !important; }
        }
    </style>

</body>
</html>
