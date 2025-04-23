@extends('layouts.prestataire')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Créer un nouveau devis</h1>

        <form action="{{ route('devis.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reservation_id" value="{{ $reservationId }}">

            <div class="mb-4">
                <label class="block text-gray-700">Montant total</label>
                <input type="number" name="total_amount" class="w-full border rounded px-3 py-2 mt-1">
            </div>

            <h2 class="text-lg font-bold mt-6 mb-2">Éléments du devis</h2>
            <div id="items"></div>

            <button type="button" id="add-item" class="mt-4 bg-gray-200 px-3 py-2 rounded">Ajouter un élément</button>

            <div class="mt-6">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = 0;

            document.getElementById('add-item').addEventListener('click', function () {
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
                    e.target.closest('.item-block').remove();
                }
            });
        });
    </script>
@endpush
