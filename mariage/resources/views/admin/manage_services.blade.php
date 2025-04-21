@extends('layouts.admin')

@section('content')
    <div class="mt-6 mb-8">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Liste des Services</h2>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Titre</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Catégorie</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Prestataire</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Ville</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr class="border-b">
                    <td class="px-4 py-2 text-sm">{{ $service->title }}</td>
                    <td class="px-4 py-2 text-sm">{{ $service->category->name ?? 'Non défini' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $service->user->name ?? 'Non défini' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $service->ville->name ?? 'Non défini' }}</td>
                    <td class="px-4 py-2 text-sm">
                        <span class="px-2 py-1 rounded bg-gray-200 text-gray-700 text-xs">{{ $service->status }}</span>
                    </td>
                    <td class="px-4 py-2 text-sm">
                        <form action="{{ route('admin.services.status', $service->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-sm px-2 py-1 border rounded">
                                <option value="pending" {{ $service->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="approved" {{ $service->status == 'approved' ? 'selected' : '' }}>Approuvé</option>
                                <option value="archived" {{ $service->status == 'archived' ? 'selected' : '' }}>Archivé</option>
                                <option value="rejected" {{ $service->status == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
