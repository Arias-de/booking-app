<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un rendez-vous
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="service_id" class="block text-gray-700 font-bold mb-2">
                                Service *
                            </label>
                            <select name="service_id" id="service_id" required
                                    class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="">-- Sélectionner un service --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">
                                        {{ $service->name }} - {{ $service->duration }}min - {{ number_format($service->price, 2) }}€
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="client_name" class="block text-gray-700 font-bold mb-2">
                                Nom du client *
                            </label>
                            <input type="text" name="client_name" id="client_name"
                                   value="{{ old('client_name') }}" required
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('client_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="client_phone" class="block text-gray-700 font-bold mb-2">
                                Téléphone *
                            </label>
                            <input type="tel" name="client_phone" id="client_phone"
                                   value="{{ old('client_phone') }}" required
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('client_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="client_email" class="block text-gray-700 font-bold mb-2">
                                Email (optionnel)
                            </label>
                            <input type="email" name="client_email" id="client_email"
                                   value="{{ old('client_email') }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('client_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="appointment_date" class="block text-gray-700 font-bold mb-2">
                                Date du rendez-vous *
                            </label>
                            <input type="date" name="appointment_date" id="appointment_date"
                                   value="{{ old('appointment_date') }}"
                                   min="{{ date('Y-m-d') }}" required
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('appointment_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="appointment_time" class="block text-gray-700 font-bold mb-2">
                                Heure du rendez-vous *
                            </label>
                            <input type="time" name="appointment_time" id="appointment_time"
                                   value="{{ old('appointment_time') }}" required
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                            @error('appointment_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 font-bold mb-2">
                                Notes (optionnel)
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="w-full border border-gray-300 rounded px-3 py-2">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Créer le rendez-vous
                            </button>
                            <a href="{{ route('appointments.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-block">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
