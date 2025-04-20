<!-- Modal -->
<div
    id="devisModal"
    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
>
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button
            id="closeModalBtn"
            class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl"
        >
            &times;
        </button>

        <h2 class="text-xl font-semibold mb-4">Choisir un devis à envoyer</h2>

        <form method="POST" action="{{ route('messages.sendDevis', ['devisId' => 0]) }}" id="devisForm">
            @csrf

            <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
            <input type="hidden" name="subject" value="Votre devis de réservation">

            <div class="mb-4">
                <label for="devis_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Sélectionner un devis
                </label>
                <select
                    name="devis_id"
                    id="devis_id"
                    class="w-full border-gray-300 rounded p-2"
                    required
                >
                    @foreach($devisList as $devis)
                        <option value="{{ $devis->id }}">
                            Devis #{{ $devis->id }} – {{ $devis->total_amount }} DH
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea
                    name="body"
                    rows="3"
                    class="w-full border-gray-300 rounded p-2"
                    placeholder="Votre message ici..."
                >Bonjour, voici le devis généré selon votre demande.</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <button
                    type="button"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
                    onclick="closeModal()"
                >
                    Annuler
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                >
                    Envoyer
                </button>
            </div>
        </form>
    </div>
</div>
