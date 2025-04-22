@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Créer un nouveau devis</h2>

        <form id="devisForm">
            @csrf

            <!-- Reservation ID -->
            <div class="mb-4">
                <label class="block text-sm font-medium">ID de réservation</label>
                <input type="number" name="reservation_id" required
                       class="w-full mt-1 px-4 py-2 border rounded" />
            </div>

            <!-- Total Amount -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Montant total</label>
                <input type="number" name="total_amount" step="0.01" required
                       class="w-full mt-1 px-4 py-2 border rounded" />
            </div>

            <!-- Items -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Éléments</label>
                <div id="itemsContainer">
                    <div class="flex gap-2 mb-2">
                        <input type="text" placeholder="Description" class="desc w-full border px-2 py-1 rounded">
                        <input type="number" placeholder="Prix" class="price w-1/3 border px-2 py-1 rounded">
                    </div>
                </div>
                <button type="button" id="addItem" class="mt-2 px-3 py-1 bg-gray-200 rounded">Ajouter un élément</button>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Créer le devis</button>
        </form>
    </div>

    <script>
        document.getElementById('addItem').addEventListener('click', () => {
            const container = document.getElementById('itemsContainer');
            container.insertAdjacentHTML('beforeend', `
            <div class="flex gap-2 mb-2">
                <input type="text" placeholder="Description" class="desc w-full border px-2 py-1 rounded">
                <input type="number" placeholder="Prix" class="price w-1/3 border px-2 py-1 rounded">
            </div>
        `);
        });

        document.getElementById('devisForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const data = {
                reservation_id: form.reservation_id.value,
                total_amount: form.total_amount.value,
            };

            // Création du devis
            const response = await fetch('/api/devis', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer {{ auth()->user()->api_token }}`,
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {
                const devisId = result.devis.id;
                const items = Array.from(document.querySelectorAll('#itemsContainer .flex')).map(div => {
                    return {
                        devis_id: devisId,
                        description: div.querySelector('.desc').value,
                        price: parseFloat(div.querySelector('.price').value)
                    };
                });

                // Envoi des items
                await fetch('/api/devis-items/multiple', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer {{ auth()->user()->api_token }}`,
                    },
                    body: JSON.stringify({ items }),
                });

                alert('Devis créé avec succès !');
                form.reset();
            } else {
                alert('Erreur : ' + result.message);
            }
        });
    </script>
@endsection
