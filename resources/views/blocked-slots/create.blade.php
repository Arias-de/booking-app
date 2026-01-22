<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bloquer un créneau
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('blocked-slots.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 font-bold mb-2">
                                Date *
                            </label>
                            <input type="date" name="date" id="date"
                                   value="{{ old('date') }}"
                                   min="{{ date('Y-m-d') }}" required
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="start_time" class="block text-gray-700 font-bold mb-2">
                                    Heure de début *
                                </label>
                                <input type="time" name="start_time" id="start_time"
                                       value="{{ old('start_time') }}" required
                                       class="w-full border border-gray-300 rounded px-3 py-2">
                                @error('start_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_time" class="block text-gray-700 font-bold mb-2">
                                    Heure de fin *
                                </label>
                                <input type="time" name="end_time" id="end_time"
                                       value="{{ old('end_time') }}" required
                                       class="w-full border border-gray-300 rounded px-3 py-2">
                                @error('end_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="reason" class="block text-gray-700 font-bold mb-2">
                                Raison (optionnel)
                            </label>
                            <input type="text" name="reason" id="reason"
                                   value="{{ old('reason') }}"
                                   placeholder="Ex: Rendez-vous médical, Vacances..."
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Bloquer ce créneau
                            </button>
                            <a href="{{ route('blocked-slots.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
