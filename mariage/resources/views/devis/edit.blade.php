@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Modifier le devis #{{ $devis->id }}</h2>

        <form method="POST" action="{{ route('devis.update', $devis->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700 mb-1">Montant total (€)</label>
                <input type="number" step="0.01" name="total_amount" value="{{ $devis->total_amount }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700 mb-1">Statut</label>
                <select name="status" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring" required>
                    <option value="pending" {{ $devis->status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="approved" {{ $devis->status == 'approved' ? 'selected' : '' }}>Approuvé</option>
                    <option value="rejected" {{ $devis->status == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                </select>
            </div>

            <h3 class="text-lg font-semibold mt-6 mb-2">Éléments du devis</h3>

            <div id="items-wrapper" class="space-y-4">
                @foreach($devis->items as $index => $item)
                    <div class="bg-gray-50 p-4 rounded border">
                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                        <div class="mb-2">
                            <label class="block text-sm">Titre</label>
                            <input type="text" name="items[{{ $index }}][title]" value="{{ $item->title }}"
                                   class="w-full px-3 py-2 border rounded" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm">Description</label>
                            <textarea name="items[{{ $index }}][description]" rows="2"
                                      class="w-full px-3 py-2 border rounded">{{ $item->description }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm">Prix (€)</label>
                            <input type="number" step="0.01" name="items[{{ $index }}][price]" value="{{ $item->price }}"
                                   class="w-full px-3 py-2 border rounded" required>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-right">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection
