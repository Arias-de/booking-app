<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réserver avec {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .delay-100 { animation-delay: 0.1s; opacity: 0; }
        .delay-200 { animation-delay: 0.2s; opacity: 0; }
        .delay-300 { animation-delay: 0.3s; opacity: 0; }

        .service-card-selected {
            border-color: #8b5cf6 !important;
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            transform: scale(1.03);
        }

        .service-checkbox:checked + .service-card {
            border-width: 3px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">

    <!-- Navigation sticky -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($user->logo)
                        <img src="{{ asset('storage/' . $user->logo) }}"
                             alt="{{ $user->name }}"
                             class="w-12 h-12 object-contain rounded-lg">
                    @else
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <span class="text-xl font-bold text-gray-800">{{ $user->name }}</span>
                </div>
                <a href="#reservation" class="bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-2 rounded-full font-bold hover:from-purple-600 hover:to-pink-700 transform hover:scale-105 transition shadow-lg">
                    📅 Réserver
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Hero Section -->
        <div class="text-center mb-16 animate-fade-in-up">
            @if($user->logo)
                <img src="{{ asset('storage/' . $user->logo) }}"
                     alt="{{ $user->name }}"
                     class="w-32 h-32 object-contain mx-auto mb-6 rounded-2xl shadow-2xl">
            @else
                <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl mx-auto mb-6 flex items-center justify-center text-white font-bold text-6xl shadow-2xl">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
            <h1 class="text-5xl md:text-6xl font-bold text-gray-800 mb-4">
                {{ $user->name }}
            </h1>
            <p class="text-2xl text-gray-600">
                ✨ Réservez un ou plusieurs services en ligne
            </p>
        </div>

        <!-- Formulaire de réservation -->
        <div id="reservation" class="max-w-6xl mx-auto animate-fade-in-up delay-100">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-t-8 border-purple-500">

                <!-- Header du formulaire -->
                <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-indigo-600 p-8 text-white text-center">
                    <h2 class="text-4xl font-bold mb-2">📅 Réserver vos services</h2>
                    <p class="text-purple-100">Sélectionnez un ou plusieurs services, puis remplissez vos informations</p>
                </div>

                <div class="p-8">

                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div class="bg-gradient-to-r from-red-100 to-pink-100 border-l-4 border-red-500 rounded-xl p-6 mb-6 shadow-lg" role="alert">
                            <div class="flex items-start">
                                <span class="text-4xl mr-4">⚠️</span>
                                <div class="flex-1">
                                    <p class="font-bold text-xl text-red-800 mb-3">Impossible de réserver</p>
                                    @foreach ($errors->all() as $error)
                                        <div class="text-red-700 mb-2 whitespace-pre-line">{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="bookingForm" action="{{ route('booking.store', $user->slug) }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Sélection des services -->
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                                    <span>💼</span>
                                    Sélectionnez vos services
                                </h3>
                                <span class="text-sm text-gray-500">
                                    <span id="selectedCount">0</span> service(s) sélectionné(s)
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                @foreach($services as $service)
                                    <label class="cursor-pointer">
                                        <input type="checkbox"
                                               name="service_ids[]"
                                               value="{{ $service->id }}"
                                               data-duration="{{ $service->duration }}"
                                               data-price="{{ $service->price }}"
                                               data-name="{{ $service->name }}"
                                               class="service-checkbox hidden"
                                               {{ old('service_ids') && in_array($service->id, old('service_ids')) ? 'checked' : '' }}>

                                        <div class="service-card bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 border-2 border-gray-200">
                                            @if($service->image)
                                                <div class="h-40 overflow-hidden relative">
                                                    <img src="{{ asset('storage/' . $service->image) }}"
                                                         alt="{{ $service->name }}"
                                                         class="w-full h-full object-cover">
                                                    <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow-lg">
                                                        <svg class="w-6 h-6 text-gray-400 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="h-40 bg-gradient-to-br from-purple-400 via-pink-500 to-indigo-600 flex items-center justify-center relative">
                                                    <span class="text-5xl">✂️</span>
                                                    <div class="absolute top-2 right-2 bg-white rounded-full p-2 shadow-lg">
                                                        <svg class="w-6 h-6 text-gray-400 checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="p-5">
                                                <h4 class="font-bold text-lg mb-2 text-gray-800">{{ $service->name }}</h4>
                                                @if($service->description)
                                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $service->description }}</p>
                                                @endif
                                                <div class="flex justify-between items-center bg-gradient-to-r from-purple-50 to-pink-50 p-3 rounded-xl">
                                                    <div class="text-center">
                                                        <p class="text-xs text-gray-500 font-semibold">Prix</p>
                                                        <p class="text-xl font-bold text-purple-600">{{ number_format($service->price, 0, ',', ' ') }}<span class="text-xs">F</span></p>
                                                    </div>
                                                    <div class="w-px h-8 bg-gray-300"></div>
                                                    <div class="text-center">
                                                        <p class="text-xs text-gray-500 font-semibold">Durée</p>
                                                        <p class="text-xl font-bold text-pink-600">{{ $service->duration }}<span class="text-xs">min</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Récapitulatif des services sélectionnés -->
                            <div id="servicesRecap" class="hidden bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl p-6 shadow-lg">
                                <h4 class="text-lg font-bold text-purple-800 mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Récapitulatif de votre réservation
                                </h4>
                                <div id="selectedServicesList" class="space-y-2 mb-4"></div>
                                <div class="border-t-2 border-purple-300 pt-4 flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-700">Durée totale</p>
                                        <p class="text-2xl font-bold text-purple-800"><span id="totalDuration">0</span> minutes</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-700">Prix total</p>
                                        <p class="text-3xl font-bold text-pink-600"><span id="totalPrice">0</span> FCFA</p>
                                    </div>
                                </div>
                            </div>

                            <p class="text-sm text-red-600 mt-2 hidden" id="serviceError">⚠️ Veuillez sélectionner au moins un service</p>
                        </div>

                        <!-- Informations client -->
                        <div class="border-t-2 border-gray-200 pt-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <span>👤</span>
                                Vos coordonnées
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="client_name" class="block text-gray-700 font-bold mb-2 flex items-center">
                                        <span class="text-xl mr-2">📝</span>
                                        Votre nom complet *
                                    </label>
                                    <input type="text" name="client_name" id="client_name"
                                           value="{{ old('client_name') }}" required
                                           placeholder="Ex: Jean Dupont"
                                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
                                </div>

                                <div>
                                    <label for="client_phone" class="block text-gray-700 font-bold mb-2 flex items-center">
                                        <span class="text-xl mr-2">📞</span>
                                        Votre téléphone *
                                    </label>
                                    <input type="tel" name="client_phone" id="client_phone"
                                           value="{{ old('client_phone') }}" required
                                           placeholder="06 12 34 56 78"
                                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="client_email" class="block text-gray-700 font-bold mb-2 flex items-center">
                                        <span class="text-xl mr-2">📧</span>
                                        Votre email (optionnel)
                                    </label>
                                    <input type="email" name="client_email" id="client_email"
                                           value="{{ old('client_email') }}"
                                           placeholder="email@exemple.com"
                                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
                                </div>
                            </div>
                        </div>

                        <!-- Date et Heure -->
                        <div class="border-t-2 border-gray-200 pt-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <span>📅</span>
                                Date et heure de début
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="appointment_date" class="block text-gray-700 font-bold mb-2 flex items-center">
                                        <span class="text-xl mr-2">📆</span>
                                        Date *
                                    </label>
                                    <input type="date" name="appointment_date" id="appointment_date"
                                           value="{{ old('appointment_date') }}"
                                           min="{{ date('Y-m-d') }}" required
                                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
                                </div>

                                <div>
                                    <label for="appointment_time" class="block text-gray-700 font-bold mb-2 flex items-center">
                                        <span class="text-xl mr-2">🕐</span>
                                        Heure de début *
                                    </label>
                                    <input type="time" name="appointment_time" id="appointment_time"
                                           value="{{ old('appointment_time') }}" required
                                           class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mt-3 bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                                💡 <strong>Info :</strong> Si vous sélectionnez plusieurs services, ils seront effectués l'un après l'autre sans interruption.
                            </p>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-gray-700 font-bold mb-2 flex items-center">
                                <span class="text-xl mr-2">📝</span>
                                Message / Remarques (optionnel)
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                      placeholder="Dites-nous si vous avez des demandes particulières..."
                                      class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:border-purple-500 focus:ring focus:ring-purple-200 transition">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Bouton de soumission -->
                        <button type="submit" id="submitBtn"
                                class="w-full bg-gradient-to-r from-purple-500 via-pink-500 to-indigo-600 hover:from-purple-600 hover:via-pink-600 hover:to-indigo-700 text-white font-bold py-5 px-6 rounded-xl text-xl transform hover:scale-105 transition shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed">
                            📅 Réserver maintenant
                        </button>

                        <p class="text-gray-500 text-sm text-center">
                            ✨ Votre rendez-vous sera confirmé par {{ $user->name }}
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pourquoi nous choisir -->
        <div class="mt-16 animate-fade-in-up delay-300">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">⭐ Pourquoi réserver chez nous ?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-xl text-center transform hover:scale-105 transition">
                    <div class="text-6xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold mb-2">Rapide</h3>
                    <p class="text-gray-600">Réservation en 2 minutes chrono</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-xl text-center transform hover:scale-105 transition">
                    <div class="text-6xl mb-4">✅</div>
                    <h3 class="text-xl font-bold mb-2">Confirmé</h3>
                    <p class="text-gray-600">Confirmation rapide par le professionnel</p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-xl text-center transform hover:scale-105 transition">
                    <div class="text-6xl mb-4">🎯</div>
                    <h3 class="text-xl font-bold mb-2">Flexible</h3>
                    <p class="text-gray-600">Un ou plusieurs services selon vos besoins</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">Propulsé par <span class="font-bold text-purple-400">BookingApp</span> • DHALY LAND © 2025</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.service-checkbox');
            const recap = document.getElementById('servicesRecap');
            const selectedCount = document.getElementById('selectedCount');
            const totalDuration = document.getElementById('totalDuration');
            const totalPrice = document.getElementById('totalPrice');
            const selectedServicesList = document.getElementById('selectedServicesList');
            const submitBtn = document.getElementById('submitBtn');
            const serviceError = document.getElementById('serviceError');
            const form = document.getElementById('bookingForm');

            // Fonction pour mettre à jour l'affichage
            function updateSelection() {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);

                // Mettre à jour les styles des cartes
                checkboxes.forEach(cb => {
                    const card = cb.nextElementSibling;
                    const checkmark = card.querySelector('.checkmark');

                    if (cb.checked) {
                        card.classList.add('service-card-selected');
                        checkmark.classList.remove('text-gray-400');
                        checkmark.classList.add('text-purple-600');
                    } else {
                        card.classList.remove('service-card-selected');
                        checkmark.classList.remove('text-purple-600');
                        checkmark.classList.add('text-gray-400');
                    }
                });

                // Mettre à jour le compteur
                selectedCount.textContent = selected.length;

                if (selected.length === 0) {
                    recap.classList.add('hidden');
                    return;
                }

                // Calculer totaux
                let duration = 0;
                let price = 0;
                let servicesList = '';

                selected.forEach((cb, index) => {
                    duration += parseInt(cb.dataset.duration);
                    price += parseFloat(cb.dataset.price);
                    servicesList += `
                        <div class="flex justify-between items-center text-sm bg-white/50 p-2 rounded">
                            <span>${index + 1}. ${cb.dataset.name}</span>
                            <span class="font-semibold">${cb.dataset.duration}min • ${new Intl.NumberFormat('fr-FR').format(cb.dataset.price)}F</span>
                        </div>
                    `;
                });

                totalDuration.textContent = duration;
                totalPrice.textContent = new Intl.NumberFormat('fr-FR').format(price);
                selectedServicesList.innerHTML = servicesList;
                recap.classList.remove('hidden');
            }

            // Validation du formulaire
            form.addEventListener('submit', function(e) {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);

                if (selected.length === 0) {
                    e.preventDefault();
                    serviceError.classList.remove('hidden');
                    document.querySelector('[name="service_ids[]"]').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }

                serviceError.classList.add('hidden');
            });

            // Écouter les changements
            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateSelection);
            });

            // Initialiser l'affichage au chargement
            updateSelection();
        });
    </script>

</body>
</html>
