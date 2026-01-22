<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <span class="text-2xl mr-2">🗓️</span>
                {{ __('Mon Agenda - Créneaux bloqués') }}
            </h2>
            <a href="{{ route('blocked-slots.create') }}"
               class="bg-gradient-to-r from-red-500 to-orange-600 hover:from-red-600 hover:to-orange-700 text-white font-bold py-2 px-6 rounded-xl transform hover:scale-105 transition shadow-lg">
                🚫 Bloquer un créneau
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

            <!-- Info card -->
            <div class="bg-gradient-to-r from-orange-100 to-red-100 border-l-4 border-orange-500 rounded-xl p-6 mb-6 shadow-lg">
                <div class="flex items-start">
                    <span class="text-4xl mr-4">💡</span>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800 mb-2">À quoi servent les créneaux bloqués ?</h3>
                        <p class="text-gray-700">
                            Bloquez des plages horaires pour vos pauses, rendez-vous personnels, vacances...
                            Vos clients ne pourront pas réserver pendant ces périodes.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Liste des créneaux bloqués -->
            @if($blockedSlots->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($blockedSlots as $slot)
                        <div class="bg-gradient-to-br from-red-50 to-orange-50 border-l-8 border-red-500 rounded-2xl shadow-lg p-6 hover:shadow-2xl transform hover:scale-105 hover:rotate-1 transition duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-3xl">🚫</span>
                                </div>
                                <span class="px-3 py-1 bg-gradient-to-r from-red-400 to-orange-500 text-white text-xs rounded-full font-bold shadow">
                                    Bloqué
                                </span>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                                <span class="mr-2">📅</span>
                                {{ $slot->date->format('d/m/Y') }}
                            </h3>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <span class="text-xl">⏰</span>
                                    <span class="font-semibold">
                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                    </span>
                                </div>

                                @if($slot->reason)
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <span class="text-xl">📝</span>
                                        <span class="font-semibold">{{ $slot->reason }}</span>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('blocked-slots.destroy', $slot) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-green-400 to-emerald-600 hover:from-green-500 hover:to-emerald-700 text-white px-4 py-3 rounded-xl font-bold transform hover:scale-105 transition shadow-lg"
                                        onclick="return confirm('Débloquer ce créneau ?')">
                                    ✅ Débloquer
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gradient-to-br from-orange-100 via-red-100 to-pink-100 rounded-2xl shadow-xl p-12 text-center">
                    <div class="text-8xl mb-6 animate-bounce">🗓️</div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Aucun créneau bloqué</h3>
                    <p class="text-gray-600 mb-8 text-lg">
                        Vous êtes disponible tout le temps ! Bloquez des créneaux pour vos pauses ou rendez-vous personnels.
                    </p>
                    <a href="{{ route('blocked-slots.create') }}"
                       class="inline-block bg-gradient-to-r from-red-500 to-orange-600 hover:from-red-600 hover:to-orange-700 text-white font-bold py-4 px-8 rounded-xl transform hover:scale-105 transition shadow-lg text-lg">
                        🚫 Bloquer mon premier créneau
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
