@extends('layouts.prestataire')
@section('content')
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Modifier le devis #{{ $devis->id }}</h1>

        <form action="{{ route('devis.update', $devis->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Montant total</label>
                <input type="number" name="total_amount" value="{{ $devis->total_amount }}"
                       class="w-full border rounded px-3 py-2 mt-1" required>
            </div>

            <h2 class="text-lg font-bold mt-6 mb-2">Éléments du devis</h2>
            <div id="items">
                @foreach($devis->devisItems as $index => $item)
                <div class="mb-4 p-4 border rounded bg-gray-50">
                        <label class="block text-gray-600">Description</label>
                        <input type="text" name="items[{{ $index }}][service_name]" value="{{ $item->service_name }}"
                               class="w-full border rounded px-3 py-1" required>

                        <label class="block text-gray-600 mt-2">Prix</label>
                        <input type="number" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}"
                               class="w-full border rounded px-3 py-1" required>

                    <label class="block text-gray-600 mt-2">Quantité</label>
                    <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}"
                           class="w-full border rounded px-3 py-1" required>


                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                    </div>
                @endforeach
            </div>

            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Enregistrer</button>
        </form>
    </div>
@endsection
