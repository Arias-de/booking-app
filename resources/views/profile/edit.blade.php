<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Logo du professionnel -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            🖼️ Logo de votre entreprise
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Ce logo sera affiché sur votre page de réservation publique.
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.update.logo') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <!-- Aperçu du logo actuel -->
                        @if(auth()->user()->logo)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Logo actuel :</p>
                                <img src="{{ asset('storage/' . auth()->user()->logo) }}"
                                     alt="Logo"
                                     class="w-32 h-32 object-contain rounded-lg border-2 border-gray-300">
                            </div>
                        @endif

                        <!-- Upload -->
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700">
                                Choisir un logo
                            </label>
                            <input type="file"
                                   name="logo"
                                   id="logo"
                                   accept="image/*"
                                   class="mt-1 block w-full">
                            @error('logo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-600 text-white px-4 py-2 rounded-lg hover:from-purple-600 hover:to-pink-700">
                                💾 Enregistrer le logo
                            </button>

                            @if (session('logo-status') === 'logo-updated')
                                <p class="text-sm text-green-600">Sauvegardé ✅</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations du profil -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Supprimer compte -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
