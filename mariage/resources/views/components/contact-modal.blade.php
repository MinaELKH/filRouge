<!-- Modal backdrop -->
<div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4 relative shadow-2xl transform transition-all">
        <!-- Close button -->
        <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Header -->
        <div class="bg-gradient-to-r from-wedding-pink to-rose-200 p-6 rounded-t-2xl">
            <h2 class="text-2xl font-bold text-white">Contactez le prestataire</h2>
            <p class="text-pink-100 text-sm mt-1">Remplissez le formulaire pour envoyer votre message</p>
        </div>

        <!-- Formulaire de message -->
        <form id="sendMessageForm" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="receiver_id" id="receiver_id" class="hidden">
            <input type="hidden" name="service_id" id="service_id" class="hidden">

            <div class="space-y-2">
                <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-1">
                    Date de l'événement
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input
                        type="date"
                        name="event_date"
                        id="event_date"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                        required
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">
                    Objet
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        required
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400"
                        placeholder="Sujet de votre message"
                    >
                </div>
            </div>

            <div class="space-y-2">
                <label for="body" class="block text-sm font-semibold text-gray-700 mb-1">
                    Message
                </label>
                <div class="relative">
                    <textarea
                        id="body"
                        name="body"
                        required
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 resize-none"
                        placeholder="Écrivez votre message ici..."
                    ></textarea>
                    <div class="absolute bottom-3 right-3 flex items-center space-x-2">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-gradient-to-r from-wedding-pink to-rose-300 hover:from-rose-500 hover:to-wedding-pink text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2">
                    <span>Envoyer le message</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Injecter l'URL de la route dans une variable JS -->
<script>
    const messageStoreUrl = "{{ route('messages.store') }}";
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
        alert("je suis la ")
        e.preventDefault();

        const formData = new FormData(sendMessageForm);

        fetch(messageStoreUrl, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': formData.get('_token')
            },
            body: formData
        })
            // .then(response => response.json())

            .then(async response => {
                if (!response.ok) {
                    const errorHtml = await response.text();
                    console.error('Erreur HTTP:', response.status);
                    console.error('Contenu retourné :', errorHtml);  // 👉 Affiche le HTML retourné
                    throw new Error('Réponse du serveur invalide');
                }

                alert(response.text) //function text() { [native code] }
                console.log(response.json) //ƒ json() { [native code] }
                return response.json();
            })
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
