<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tableau de bord') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->locale('fr')->translatedFormat('l j F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Message de bienvenue - Version Ultra Colorée -->
            <div class="relative overflow-hidden bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-600 rounded-2xl shadow-2xl p-8 mb-8 text-white transform hover:scale-105 transition duration-300">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-3xl font-bold mb-2 animate-pulse">👋 Bonjour {{ auth()->user()->name }} !</h3>
                            <p class="text-pink-100 text-lg">Prêt à gérer votre journée comme un pro ?</p>
                        </div>
                        <div class="hidden md:block text-7xl animate-bounce">
                            ✨
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques - Version Colorée -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Total RDV - Bleu -->
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-110 hover:rotate-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-white bg-opacity-30 rounded-xl flex items-center justify-center">
                            <span class="text-4xl">📅</span>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-100 text-sm font-semibold">Total</p>
                            <p class="text-5xl font-bold">{{ auth()->user()->appointments()->count() }}</p>
                        </div>
                    </div>
                    <p class="text-blue-100 font-semibold">Rendez-vous</p>
                </div>

                <!-- RDV en attente - Orange/Jaune -->
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-110 hover:rotate-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-white bg-opacity-30 rounded-xl flex items-center justify-center">
                            <span class="text-4xl">⏳</span>
                        </div>
                        <div class="text-right">
                            <p class="text-yellow-100 text-sm font-semibold">En attente</p>
                            <p class="text-5xl font-bold">{{ auth()->user()->appointments()->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                    <p class="text-yellow-100 font-semibold">À confirmer</p>
                </div>

                <!-- RDV confirmés - Vert -->
                <div class="bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-110 hover:rotate-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-white bg-opacity-30 rounded-xl flex items-center justify-center">
                            <span class="text-4xl">✅</span>
                        </div>
                        <div class="text-right">
                            <p class="text-green-100 text-sm font-semibold">Confirmés</p>
                            <p class="text-5xl font-bold">{{ auth()->user()->appointments()->where('status', 'confirmed')->count() }}</p>
                        </div>
                    </div>
                    <p class="text-green-100 font-semibold">Validés</p>
                </div>

                <!-- Services actifs - Violet/Rose -->
                <div class="bg-gradient-to-br from-purple-400 to-pink-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-110 hover:rotate-1 transition duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-white bg-opacity-30 rounded-xl flex items-center justify-center">
                            <span class="text-4xl">💼</span>
                        </div>
                        <div class="text-right">
                            <p class="text-purple-100 text-sm font-semibold">Services</p>
                            <p class="text-5xl font-bold">{{ auth()->user()->services()->count() }}</p>
                        </div>
                    </div>
                    <p class="text-purple-100 font-semibold">Actifs</p>
                </div>

            </div>

            <!-- Raccourcis rapides - Version Colorée -->
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-2xl shadow-xl p-8 mb-8 border-2 border-cyan-200">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                    <span class="text-3xl mr-3">🚀</span>
                    Actions rapides
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <a href="{{ route('appointments.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 hover:-rotate-2 transition duration-300">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                        <div class="relative z-10">
                            <span class="text-5xl mb-4 block">📋</span>
                            <p class="font-bold text-xl mb-2">Mes rendez-vous</p>
                            <p class="text-blue-100 text-sm">Gérer tous vos RDV</p>
                        </div>
                    </a>

                    <a href="{{ route('services.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 hover:-rotate-2 transition duration-300">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                        <div class="relative z-10">
                            <span class="text-5xl mb-4 block">✂️</span>
                            <p class="font-bold text-xl mb-2">Mes services</p>
                            <p class="text-purple-100 text-sm">Gérer vos prestations</p>
                        </div>
                    </a>

                    <a href="{{ route('blocked-slots.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-red-500 to-orange-600 rounded-xl p-6 text-white shadow-lg transform hover:scale-105 hover:-rotate-2 transition duration-300">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                        <div class="relative z-10">
                            <span class="text-5xl mb-4 block">🚫</span>
                            <p class="font-bold text-xl mb-2">Mon agenda</p>
                            <p class="text-red-100 text-sm">Bloquer des créneaux</p>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Prochains rendez-vous - Version Colorée -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border-l-8 border-indigo-500 mb-8">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                    <span class="text-3xl mr-3">📅</span>
                    Prochains rendez-vous
                </h3>

                @php
                    $upcomingAppointments = auth()->user()->appointments()
                        ->where('appointment_date', '>=', today())
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->orderBy('appointment_date')
                        ->orderBy('appointment_time')
                        ->take(5)
                        ->get();
                @endphp

                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="flex items-center justify-between p-5 bg-gradient-to-r from-{{ $appointment->status === 'pending' ? 'yellow' : 'green' }}-50 to-{{ $appointment->status === 'pending' ? 'orange' : 'emerald' }}-50 rounded-xl border-2 border-{{ $appointment->status === 'pending' ? 'yellow' : 'green' }}-200 hover:shadow-lg transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-{{ $appointment->status === 'pending' ? 'yellow' : 'green' }}-400 to-{{ $appointment->status === 'pending' ? 'orange' : 'emerald' }}-600 rounded-2xl flex items-center justify-center font-bold text-white text-xl shadow-lg">
                                        {{ substr($appointment->client_name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-lg text-gray-800">{{ $appointment->client_name }}</p>
                                        <p class="text-gray-600 font-semibold">
                                            🔸 {{ $appointment->service->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            📅 {{ $appointment->appointment_date->format('d/m/Y') }} •
                                            🕐 {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if($appointment->status === 'pending')
                                        <span class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full text-sm font-bold shadow-lg">⏳ En attente</span>
                                    @else
                                        <span class="px-4 py-2 bg-gradient-to-r from-green-400 to-emerald-600 text-white rounded-full text-sm font-bold shadow-lg">✅ Confirmé</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('appointments.index') }}" class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-3 rounded-xl font-bold hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition shadow-lg">
                            Voir tous les rendez-vous →
                        </a>
                    </div>
                @else
                    <div class="text-center py-12 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl">
                        <div class="text-6xl mb-4">📭</div>
                        <p class="text-gray-500 mb-6 text-lg">Aucun rendez-vous à venir pour le moment</p>
                        <a href="{{ route('appointments.create') }}" class="inline-block bg-gradient-to-r from-purple-500 to-pink-600 text-white px-8 py-3 rounded-xl font-bold hover:from-purple-600 hover:to-pink-700 transform hover:scale-105 transition shadow-lg">
                            ➕ Créer un rendez-vous
                        </a>
                    </div>
                @endif
            </div>

            <!-- Lien de réservation - Version Colorée -->
            <div class="relative overflow-hidden bg-gradient-to-br from-teal-400 via-cyan-500 to-blue-600 rounded-2xl shadow-2xl p-8 text-white">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">🔗</span>
                        <h3 class="text-2xl font-bold">Votre lien de réservation magique</h3>
                    </div>
                    <p class="text-cyan-100 mb-6 text-lg">Partagez ce lien sur WhatsApp, Instagram, Facebook... Vos clients réservent en 2 clics !</p>
                    <div class="flex items-center gap-3">
                        <input type="text"
                               value="{{ url('/booking/' . auth()->user()->slug) }}"
                               id="bookingLink"
                               readonly
                               class="flex-1 px-6 py-4 bg-white text-gray-800 font-semibold border-4 border-cyan-300 rounded-xl shadow-lg text-lg">
                        <button onclick="copyLink()"
                                class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-8 py-4 rounded-xl font-bold hover:from-yellow-500 hover:to-orange-600 transform hover:scale-110 transition shadow-xl text-lg">
                            📋 Copier
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function copyLink() {
            const input = document.getElementById('bookingLink');
            input.select();
            document.execCommand('copy');

            // Animation de confirmation
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '✅ Copié !';
            button.classList.add('animate-pulse');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('animate-pulse');
            }, 2000);
        }
    </script>
</x-app-layout>
