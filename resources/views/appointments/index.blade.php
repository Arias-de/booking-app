<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <span class="text-2xl mr-2">📅</span>
                {{ __('Mes Rendez-vous') }}
            </h2>
            <a href="{{ route('appointments.create') }}"
               class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-2 px-6 rounded-xl transform hover:scale-105 transition shadow-lg">
                ➕ Ajouter un rendez-vous
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Message de succès -->
            @if (session('success'))
                <div class="bg-gradient-to-r from-green-400 to-emerald-500 border-l-4 border-green-600 text-white px-6 py-4 rounded-xl mb-6 shadow-lg animate-pulse">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">✅</span>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Filtres de statut -->
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-2xl shadow-lg p-6 mb-6 border-2 border-cyan-200">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="font-bold text-gray-700 text-lg">🔍 Filtrer :</span>
                    <button class="px-4 py-2 rounded-xl bg-gradient-to-r from-gray-400 to-gray-600 text-white font-semibold hover:from-gray-500 hover:to-gray-700 transform hover:scale-105 transition shadow-lg">
                        Tous
                    </button>
                    <button class="px-4 py-2 rounded-xl bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-semibold hover:from-yellow-500 hover:to-orange-600 transform hover:scale-105 transition shadow-lg">
                        🟡 En attente
                    </button>
                    <button class="px-4 py-2 rounded-xl bg-gradient-to-r from-green-400 to-emerald-600 text-white font-semibold hover:from-green-500 hover:to-emerald-700 transform hover:scale-105 transition shadow-lg">
                        🟢 Confirmés
                    </button>
                    <button class="px-4 py-2 rounded-xl bg-gradient-to-r from-red-400 to-pink-600 text-white font-semibold hover:from-red-500 hover:to-pink-700 transform hover:scale-105 transition shadow-lg">
                        🔴 Annulés
                    </button>
                </div>
            </div>

            <!-- Liste des rendez-vous -->
            @if($appointments->count() > 0)
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        @if($appointment->status === 'pending')
                            <!-- RDV En attente - Jaune/Orange -->
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-8 border-yellow-400 rounded-2xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-102 transition duration-300">
                        @elseif($appointment->status === 'confirmed')
                            <!-- RDV Confirmé - Vert -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-8 border-green-500 rounded-2xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-102 transition duration-300">
                        @else
                            <!-- RDV Annulé - Rouge -->
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-8 border-red-400 rounded-2xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-102 transition duration-300">
                        @endif

                            <div class="flex justify-between items-start">
                                <!-- Informations -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        @if($appointment->status === 'pending')
                                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center font-bold text-white text-xl shadow-lg">
                                        @elseif($appointment->status === 'confirmed')
                                            <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center font-bold text-white text-xl shadow-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-pink-600 rounded-2xl flex items-center justify-center font-bold text-white text-xl shadow-lg">
                                        @endif
                                                {{ substr($appointment->client_name, 0, 2) }}
                                            </div>

                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-800">{{ $appointment->client_name }}</h3>
                                            @if($appointment->status === 'pending')
                                                <span class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-sm rounded-full font-bold shadow">⏳ En attente</span>
                                            @elseif($appointment->status === 'confirmed')
                                                <span class="px-3 py-1 bg-gradient-to-r from-green-400 to-emerald-600 text-white text-sm rounded-full font-bold shadow">✅ Confirmé</span>
                                            @else
                                                <span class="px-3 py-1 bg-gradient-to-r from-red-400 to-pink-600 text-white text-sm rounded-full font-bold shadow">❌ Annulé</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-700">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xl">💼</span>
                                            <span class="font-semibold">{{ $appointment->service->name }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xl">📅</span>
                                            <span class="font-semibold">{{ $appointment->appointment_date->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xl">🕐</span>
                                            <span class="font-semibold">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xl">📞</span>
                                            <span class="font-semibold">{{ $appointment->client_phone }}</span>
                                        </div>
                                        @if($appointment->client_email)
                                            <div class="flex items-center gap-2">
                                                <span class="text-xl">📧</span>
                                                <span class="font-semibold">{{ $appointment->client_email }}</span>
                                            </div>
                                        @endif
                                        @if($appointment->notes)
                                            <div class="flex items-center gap-2 col-span-2">
                                                <span class="text-xl">📝</span>
                                                <span class="font-semibold">{{ $appointment->notes }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col gap-2 ml-4">
                                    @if($appointment->status === 'pending')
                                        <form action="{{ route('appointments.updateStatus', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit"
                                                    class="w-full bg-gradient-to-r from-green-400 to-emerald-600 hover:from-green-500 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-bold transform hover:scale-105 transition shadow-lg whitespace-nowrap">
                                                ✓ Confirmer
                                            </button>
                                        </form>

                                        <form action="{{ route('appointments.updateStatus', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit"
                                                    class="w-full bg-gradient-to-r from-red-400 to-pink-600 hover:from-red-500 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-bold transform hover:scale-105 transition shadow-lg whitespace-nowrap"
                                                    onclick="return confirm('Annuler ce rendez-vous ?')">
                                                ✗ Annuler
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-gradient-to-r from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-6 py-3 rounded-xl font-bold transform hover:scale-105 transition shadow-lg whitespace-nowrap"
                                                onclick="return confirm('Supprimer définitivement ce rendez-vous ?')">
                                            🗑️ Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 rounded-2xl shadow-xl p-12 text-center">
                    <div class="text-8xl mb-6 animate-bounce">📅</div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Aucun rendez-vous pour le moment</h3>
                    <p class="text-gray-600 mb-8 text-lg">Créez votre premier rendez-vous ou attendez que vos clients réservent en ligne !</p>
                    <a href="{{ route('appointments.create') }}"
                       class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-xl transform hover:scale-105 transition shadow-lg text-lg">
                        ➕ Créer mon premier rendez-vous
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
