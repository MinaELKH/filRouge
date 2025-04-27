@extends('layouts.main')

@section('content')


    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md border border-gray-100">
        <h1 class="text-2xl font-semibold mb-4 text-wedding-pink">Modifier le devis #{{ $devis->id }}</h1>

        <form action="{{ route('devis.update', $devis->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700">Montant total</label>
                <input type="number" name="total_amount" value="{{ $devis->total_amount }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1 focus:border-wedding-pink focus:outline-none">
            </div>

            <h2 class="text-lg font-bold mt-6 mb-2 text-gray-700">Éléments du devis</h2>
            <div id="items">
                @foreach($devis->devisItems as $index => $item)
                    <div class="item-block mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <label class="block text-gray-600">Description</label>
                        <input type="text" name="items[{{ $index }}][service_name]" value="{{ $item->service_name }}"
                               class="w-full border border-gray-300 rounded px-3 py-1 focus:border-wedding-pink focus:outline-none" required>

                        <label class="block text-gray-600 mt-2">Prix</label>
                        <input type="number" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}"
                               class="w-full border border-gray-300 rounded px-3 py-1 focus:border-wedding-pink focus:outline-none" required>

                        <label class="block text-gray-600 mt-2">Quantité</label>
                        <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}"
                               class="w-full border border-gray-300 rounded px-3 py-1 focus:border-wedding-pink focus:outline-none" required>

                        <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">

                        <button type="button" class="remove-item mt-2 text-red-600 hover:text-red-700 hover:underline" data-id="{{ $item->id }}">Supprimer</button>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-item" class="mt-4 bg-gray-200 px-3 py-2 rounded-lg hover:bg-gray-300 transition-colors">Ajouter un élément</button>

            <div id="deleted-items-container"></div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-wedding-pink text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition-colors shadow-sm">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = {{ $devis->devisItems->count() }};

            document.getElementById('add-item').addEventListener('click', function () {
                alert("hello")
                const container = document.createElement('div');
                container.classList.add('item-block', 'mb-4', 'p-4', 'border', 'rounded', 'bg-gray-50');
                container.innerHTML = `
                <label class="block text-gray-600">Description</label>
                <input type="text" name="items[${itemIndex}][service_name]" class="w-full border rounded px-3 py-1" required>

                <label class="block text-gray-600 mt-2">Prix</label>
                <input type="number" name="items[${itemIndex}][unit_price]" class="w-full border rounded px-3 py-1" required>

                <label class="block text-gray-600 mt-2">Quantité</label>
                <input type="number" name="items[${itemIndex}][quantity]" class="w-full border rounded px-3 py-1" required>

                <button type="button" class="remove-item mt-2 text-red-600 hover:underline">Supprimer</button>
            `;
                document.getElementById('items').appendChild(container);
                itemIndex++;
            });

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item')) {
                    const itemId = e.target.dataset.id;
                    if (itemId) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'deleted_item_ids[]';
                        input.value = itemId;
                        document.getElementById('deleted-items-container').appendChild(input);
                    }
                    e.target.closest('.item-block').remove();
                }
            });
        });
    </script>
@endpush
