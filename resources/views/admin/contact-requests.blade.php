<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">
                📩 Demandes de Spécialisation
            </h1>

            <div class="flex items-center gap-4">
                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                    {{ $unreadCount }} nouvelle(s)
                </span>

                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    ← Retour
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Message de succès --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Tableau --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($requests->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entreprise</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach($requests as $req)
                                <tr class="{{ $req->is_read ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $req->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $req->company }}</div>
                                        <div class="text-sm text-gray-500">{{ $req->name }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        <a href="mailto:{{ $req->email }}" class="text-blue-600 hover:underline">
                                            {{ $req->email }}
                                        </a><br>
                                        <a href="tel:{{ $req->phone }}" class="text-gray-600 hover:underline">
                                            {{ $req->phone }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $req->need_type }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($req->is_read)
                                            <span class="px-2 text-xs rounded-full bg-gray-100 text-gray-800">
                                                Lu
                                            </span>
                                        @else
                                            <span class="px-2 text-xs rounded-full bg-green-100 text-green-800">
                                                Nouveau
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm">
                                        <button onclick="showMessage({{ $req->id }}, @js($req->message), {{ $req->is_read ? 'true' : 'false' }})"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            👁️ Voir
                                        </button>

                                        @if(!$req->is_read)
                                            <form method="POST"
                                                  action="{{ route('admin.contact-requests.read', $req->id) }}"
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="text-green-600 hover:text-green-900 mr-3">
                                                    ✓ Marquer lu
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST"
                                              action="{{ route('admin.contact-requests.destroy', $req->id) }}"
                                              class="inline"
                                              onsubmit="return confirm('Supprimer cette demande ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 bg-gray-50">
                        {{ $requests->links() }}
                    </div>
                @else
                    <div class="p-12 text-center text-gray-500">
                        Aucune demande pour le moment.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="messageModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-11/12 md:w-1/2">
            <div class="flex justify-between mb-4">
                <h3 class="text-xl font-bold">💬 Message</h3>
                <button onclick="closeModal()" class="text-xl">&times;</button>
            </div>

            <p id="modalMessage" class="whitespace-pre-wrap mb-4"></p>

            <div class="text-right">
                <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <script>
        function showMessage(id, message) {
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('messageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
