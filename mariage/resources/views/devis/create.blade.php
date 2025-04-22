@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Créer un nouveau devis</h2>

        <form id="devisForm" action="{{ route('devis.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reservation_id" value="{{ $reservation_id ?? '' }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Montant total</label>
                <input type="number" step="0.01" name="total_amount"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                       required>
            </div>

            <div id="itemsContainer" class="space-y-4">
                <h3 class="text-lg font-medium text-gray-800">Éléments du devis</h3>
                <div class="item-entry grid grid-cols-3 gap-4">
                    <input type="text" name="items[0][description]" placeholder="Description"
                           class="col-span-1 px-3 py-2 border rounded" required>
                    <input type="number" name="items[0][quantity]" placeholder="Quantité"
                           class="col-span-1 px-3 py-2 border rounded" required>
                    <input type="number" step="0.01" name="items[0][price]" placeholder="Prix unitaire"
                           class="col-span-1 px-3 py-2 border rounded" required>
                </div>
            </div>

            <button type="button" id="addItem"
                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                + Ajouter un élément
            </button>

            <div class="mt-6">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Enregistrer le devis
                </button>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 1;

        document.getElementById('addItem').addEventListener('click', () => {
            const container = document.getElementById('itemsContainer');
            const div = document.createElement('div');
            div.classList.add('item-entry', 'grid', 'grid-cols-3', 'gap-4', 'mt-4');
            div.innerHTML = `
            <input type="text" name="items[${itemIndex}][description]" placeholder="Description"
                   class="col-span-1 px-3 py-2 border rounded" required>
            <input type="number" name="items[${itemIndex}][quantity]" placeholder="Quantité"
                   class="col-span-1 px-3 py-2 border rounded" required>
            <input type="number" step="0.01" name="items[${itemIndex}][price]" placeholder="Prix unitaire"
                   class="col-span-1 px-3 py-2 border rounded" required>
        `;
            container.appendChild(div);
            itemIndex++;
        });
    </script>
@endsection
