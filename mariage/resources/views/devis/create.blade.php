{{--@extends('layouts.prestataire')--}}

{{--@section('content')--}}
{{--    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">--}}
{{--        <h1 class="text-2xl font-semibold mb-4">Créer un nouveau devis</h1>--}}

{{--        <form action="{{ route('devis.store') }}" method="POST">--}}
{{--            @csrf--}}

{{--            <input type="hidden" name="reservation_id" value="{{ $reservationId }}">--}}

{{--            <div class="mb-4">--}}
{{--                <label class="block text-gray-700">Montant total</label>--}}
{{--                <input type="number" name="total_amount" class="w-full border rounded px-3 py-2 mt-1">--}}
{{--            </div>--}}

{{--            <h2 class="text-lg font-bold mt-6 mb-2">Éléments du devis</h2>--}}
{{--            <div id="items"></div>--}}

{{--            <button type="button" id="add-item" class="mt-4 bg-gray-200 px-3 py-2 rounded">Ajouter un élément</button>--}}

{{--            <div class="mt-6">--}}
{{--                <button type="submit"--}}
{{--                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Enregistrer</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@push('script')--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            let itemIndex = 0;--}}

{{--            document.getElementById('add-item').addEventListener('click', function () {--}}
{{--                const container = document.createElement('div');--}}
{{--                container.classList.add('item-block', 'mb-4', 'p-4', 'border', 'rounded', 'bg-gray-50');--}}
{{--                container.innerHTML = `--}}
{{--                <label class="block text-gray-600">Description</label>--}}
{{--                <input type="text" name="items[${itemIndex}][service_name]" class="w-full border rounded px-3 py-1" required>--}}

{{--                <label class="block text-gray-600 mt-2">Prix</label>--}}
{{--                <input type="number" name="items[${itemIndex}][unit_price]" class="w-full border rounded px-3 py-1" required>--}}

{{--                <label class="block text-gray-600 mt-2">Quantité</label>--}}
{{--                <input type="number" name="items[${itemIndex}][quantity]" class="w-full border rounded px-3 py-1" required>--}}

{{--                <button type="button" class="remove-item mt-2 text-red-600 hover:underline">Supprimer</button>--}}
{{--            `;--}}
{{--                document.getElementById('items').appendChild(container);--}}
{{--                itemIndex++;--}}
{{--            });--}}

{{--            document.addEventListener('click', function (e) {--}}
{{--                if (e.target.classList.contains('remove-item')) {--}}
{{--                    e.target.closest('.item-block').remove();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
@extends('layouts.prestataire')

@section('content')
    <div class="max-w-4xl mx-auto p-8 bg-white rounded-lg shadow-md border border-gray-100">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
            <h1 class="text-2xl font-semibold text-wedding-pink">Créer un nouveau devis</h1>
            <div class="text-gray-500 text-sm">
                Réservation #{{ $reservationId }}
            </div>
        </div>

        <form action="{{ route('devis.store') }}" method="POST">
            @csrf

            <input type="hidden" name="reservation_id" value="{{ $reservationId }}">

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Montant total</label>
                <div class="relative">
                    <input type="number" name="total_amount" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent transition-colors">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">€</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Le montant total peut être calculé automatiquement à partir des éléments ci-dessous</p>
            </div>

            <h2 class="text-lg font-bold mt-8 mb-4 flex items-center text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-wedding-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Éléments du devis
            </h2>

            <div id="items" class="space-y-4"></div>

            <button type="button" id="add-item" class="mt-6 flex items-center px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-wedding-pink" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajouter un élément
            </button>

            <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-wedding-pink text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition-colors shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Enregistrer le devis
                </button>
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
                container.classList.add('item-block', 'p-4', 'border', 'border-gray-200', 'rounded-lg', 'bg-gray-50', 'relative');
                container.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-3">
                            <label class="block text-gray-700 font-medium mb-1">Description</label>
                            <input type="text" name="items[${itemIndex}][service_name]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Prix unitaire</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">€</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Quantité</label>
                            <input type="number" name="items[${itemIndex}][quantity]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-wedding-pink focus:border-transparent" value="1" min="1" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Total</label>
                            <div class="bg-gray-100 border border-gray-200 rounded-lg px-3 py-2 text-gray-700 font-medium">
                                <span class="item-total">0.00</span> €
                            </div>
                        </div>
                    </div>

                    <button type="button" class="remove-item absolute top-3 right-3 text-gray-400 hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;

                document.getElementById('items').appendChild(container);

                // Mettre à jour le total lorsque le prix ou la quantité change
                const priceInput = container.querySelector('input[name$="[unit_price]"]');
                const quantityInput = container.querySelector('input[name$="[quantity]"]');
                const totalElement = container.querySelector('.item-total');

                function updateTotal() {
                    const price = parseFloat(priceInput.value) || 0;
                    const quantity = parseInt(quantityInput.value) || 0;
                    totalElement.textContent = (price * quantity).toFixed(2);
                }

                priceInput.addEventListener('input', updateTotal);
                quantityInput.addEventListener('input', updateTotal);

                itemIndex++;
            });

            // Ajouter le premier élément par défaut
            document.getElementById('add-item').click();

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
                    e.target.closest('.item-block').remove();
                }
            });
        });
    </script>
@endpush
