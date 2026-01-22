<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <span class="text-2xl mr-2">✂️</span>
                {{ __('Mes Services') }}
            </h2>
            <a href="{{ route('services.create') }}" class="bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-bold py-2 px-6 rounded-xl transform hover:scale-105 transition shadow-lg">
                ➕ Ajouter un service
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

            <!-- Liste des services -->
            @if($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 hover:rotate-1 transition duration-300 border-t-4 border-purple-500">

                            <!-- Image -->
                            @if($service->image)
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $service->image) }}"
                                         alt="{{ $service->name }}"
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                </div>
                            @else
                                <div class="h-48 bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center">
                                    <span class="text-6xl">✂️</span>
                                </div>
                            @endif

                            <!-- Contenu -->
                            <div class="p-6">
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">{{ $service->name }}</h3>

                                @if($service->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $service->description }}</p>
                                @endif

                                <div class="flex justify-between items-center mb-4 bg-gradient-to-r from-blue-50 to-purple-50 p-3 rounded-xl">
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 font-semibold">Prix</p>
                                        <p class="text-2xl font-bold text-blue-600">{{ number_format($service->price, 2) }}FCFA</p>
                                    </div>
                                    <div class="w-px h-10 bg-gray-300"></div>
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 font-semibold">Durée</p>
                                        <p class="text-2xl font-bold text-purple-600">{{ $service->duration }}<span class="text-sm">min</span></p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('services.edit', $service) }}"
                                       class="flex-1 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white text-center py-3 rounded-xl font-bold transform hover:scale-105 transition shadow-lg">
                                        ✏️ Modifier
                                    </a>

                                    <form action="{{ route('services.destroy', $service) }}"
                                          method="POST"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');"
                                          class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white py-3 rounded-xl font-bold transform hover:scale-105 transition shadow-lg">
                                            🗑️ Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gradient-to-br from-purple-100 via-pink-100 to-blue-100 rounded-2xl shadow-xl p-12 text-center">
                    <div class="text-8xl mb-6 animate-bounce">✂️</div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Aucun service pour le moment</h3>
                    <p class="text-gray-600 mb-8 text-lg">Créez votre premier service pour commencer à recevoir des réservations !</p>
                    <a href="{{ route('services.create') }}"
                       class="inline-block bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-bold py-4 px-8 rounded-xl transform hover:scale-105 transition shadow-lg text-lg">
                        ➕ Créer mon premier service
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
