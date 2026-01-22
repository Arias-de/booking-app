<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                   <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nom du service -->
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">
                                Nom du service *
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">
                                Description (optionnel)
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="3"
                                      class="w-full border border-gray-300 rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">
                                Photo du service (optionnel)
                            </label>
                            <input type="file"
                                   name="image"
                                   id="image"
                                   accept="image/*"
                                   class="w-full border border-gray-300 rounded px-3 py-2 @error('image') border-red-500 @enderror">
                            <p class="text-gray-500 text-sm mt-1">Format acceptés : JPG, PNG, WEBP (max 2MB)</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Durée -->
                        <div class="mb-4">
                            <label for="duration" class="block text-gray-700 font-bold mb-2">
                                Durée (en minutes) *
                            </label>
                            <input type="number"
                                   name="duration"
                                   id="duration"
                                   value="{{ old('duration') }}"
                                   min="1"
                                   class="w-full border border-gray-300 rounded px-3 py-2 @error('duration') border-red-500 @enderror"
                                   required>
                            @error('duration')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prix -->
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-bold mb-2">
                                Prix (en FCFA) *
                            </label>
                            <input type="number"
                                   name="price"
                                   id="price"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full border border-gray-300 rounded px-3 py-2 @error('price') border-red-500 @enderror"
                                   required>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Créer le service
                            </button>
                            <a href="{{ route('services.index') }}"
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
