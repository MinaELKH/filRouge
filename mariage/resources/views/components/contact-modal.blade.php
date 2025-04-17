<!-- Modal backdrop -->
<div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg max-w-md w-full relative">
        <!-- Close button -->
        <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
            &times;
        </button>

        <!-- Formulaire de message -->
        <form id="sendMessageForm">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="receiver_id" id="receiver_id">

            <div class="mb-4">
                <label for="subject" class="block font-medium mb-1">Objet :</label>
                <input type="text" id="subject" name="subject" required class="form-input w-full">
            </div>

            <div class="mb-4">
                <label for="body" class="block font-medium mb-1">Message :</label>
                <textarea id="body" name="body" required class="form-textarea w-full"></textarea>
            </div>

            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white py-2 px-4 rounded-md">
                Envoyer
            </button>
        </form>
    </div>
</div>

<!-- Injecter l'URL de la route dans une variable JS -->
<script>
    const messageStoreUrl = "{{ route('messages.create') }}";
</script>

<!-- Script JS -->
<script>
    const sendMessageForm = document.getElementById('sendMessageForm');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const closeModalBtn = document.getElementById('closeModalBtn');

    closeModalBtn.addEventListener('click', () => {
        modalBackdrop.classList.add('hidden');
        document.body.style.overflow = '';
    });

    sendMessageForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(sendMessageForm);

        fetch(messageStoreUrl, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': formData.get('_token')
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Message envoyé !");
                    modalBackdrop.classList.add('hidden');
                    document.body.style.overflow = '';
                    sendMessageForm.reset();
                } else {
                    alert("Erreur lors de l'envoi.");
                }
            })
            .catch(error => {
                console.error(error);
                alert("Erreur inattendue.");
            });
    });
</script>
