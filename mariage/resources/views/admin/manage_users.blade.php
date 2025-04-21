@extends('layouts.admin')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Gestion des Utilisateurs</h2>

        <!-- Barre de recherche et filtre -->
        <form method="GET" action="{{ route('admin.manage_users') }}" class="mb-4 flex gap-4">
            <input type="text" name="search" placeholder="Rechercher par nom" value="{{ request('search') }}"
                   class="p-2 border rounded-md w-1/3">
            <select name="role" class="p-2 border rounded-md">
                <option value="">Tous les rôles</option>
                <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Client</option>
                <option value="prestataire" {{ request('role') == 'prestataire' ? 'selected' : '' }}>Prestataire</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Filtrer</button>
        </form>

        <!-- Tableau des utilisateurs -->
        <table class="w-full table-auto border">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Rôle</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr class="text-center border-b">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->role }}</td>
                    <td class="px-4 py-2">
                        @if($user->is_banned)
                            <span class="text-red-500 font-semibold">Banni</span>
                        @else
                            <span class="text-green-500 font-semibold">Actif</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <form action="{{ route('admin.users.toggleBan', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="px-3 py-1 text-white rounded-md
                                           {{ $user->banned ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $user->banned ? 'Débannir' : 'Bannir' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-4 text-center">Aucun utilisateur trouvé.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
