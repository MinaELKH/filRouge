@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Gestion des Prestataires</h2>

        <!-- Barre de recherche -->
        <form method="GET" action="{{ route('admin.manage_prestataires') }}" class="mb-6 flex flex-wrap gap-4 items-center">
            <input type="text" name="search" placeholder="Rechercher par nom" value="{{ request('search') }}"
                   class="p-2 border border-gray-300 rounded-md w-1/3 focus:outline-none focus:ring focus:border-blue-300">

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">
                Filtrer
            </button>
        </form>

        <!-- Tableau des Prestataires -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-6 py-3 font-semibold">Nom</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 font-semibold">Rôle</th>
                    <th class="px-6 py-3 font-semibold">Statut</th>
                    <th class="px-6 py-3 font-semibold text-center">Action</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4 capitalize">{{ $user->role }}</td>
                        <td class="px-6 py-4">
                            @if($user->is_banned)
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Banni</span>
                            @else
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Actif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.users.toggleBan', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="text-white px-3 py-1 rounded-md transition
                                               {{ $user->is_banned ? 'bg-green-500 hover:bg-green-600' : ' hover:bg-white' }}"
                                        title="{{ $user->is_banned ? 'Débannir' : 'Bannir' }}">
                                    {{ $user->is_banned ? '✅' : '🚫' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-6 py-4 text-gray-500">Aucun prestataire trouvé.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
