{{-- messages.index.blade.php --}}
@extends('layouts.prestataire')

@section('content')
    <div class="h-screen flex overflow-hidden bg-gray-50">
        <!-- Sidebar -->
        <div id="sidebar" class="w-1/4 bg-white border-r overflow-y-auto shadow-sm">
            <div class="p-4 border-b bg-indigo-600 text-white font-semibold text-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                </svg>
                Messages
            </div>

            @foreach($conversations as $conv)
                @php
                    $isActive = isset($partner) && $partner->id === $conv['partner']->id;
                @endphp
                <div class="flex items-center p-4 border-b hover:bg-indigo-50 cursor-pointer transition-colors {{ $isActive ? 'bg-indigo-50 border-l-4 border-indigo-500' : '' }}"
                     onclick="loadConversation({{ $conv['partner']->id }})">
                    <div class="relative">
                        <img src="{{ $conv['partner']->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv['partner']->name) . '&background=4F46E5&color=fff' }}"
                             class="h-12 w-12 rounded-full mr-3 border {{ $isActive ? 'border-indigo-500' : 'border-gray-200' }}">
                        <span class="absolute bottom-0 right-2 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-gray-800">{{ $conv['partner']->name }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ Str::limit($conv['last_message']->body, 30) }}</div>
                    </div>
                    <div class="flex flex-col items-end">
                        <div class="text-xs text-gray-500 mb-1">{{ $conv['last_message']->created_at->diffForHumans() }}</div>
                        @if($conv['unread_count'] > 0)
                            <span class="text-xs bg-indigo-600 text-white rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $conv['unread_count'] }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach

            @if(count($conversations) === 0)
                <div class="p-4 text-center text-gray-500">
                    Aucune conversation
                </div>
            @endif
        </div>

        <!-- Conversation container -->
        <div id="conversationContainer" class="flex-1 flex flex-col bg-gray-50">
            @if(isset($partner))
                @include('messages._conversation', [
                    'messages' => $messages,
                    'partner' => $partner,
                    'reservationId' => $messages->first()->reservation_id ?? ''
                ])
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-xl">Sélectionnez une conversation</p>
                    <p class="text-sm mt-2">Cliquez sur un contact pour commencer à discuter</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function loadConversation(partnerId) {
            // Ajouter une classe active à la conversation sélectionnée
            document.querySelectorAll('#sidebar > div').forEach(el => {
                el.classList.remove('bg-indigo-50', 'border-l-4', 'border-indigo-500');
            });

            // Trouver et marquer comme actif
            const conversationEl = Array.from(document.querySelectorAll('#sidebar > div')).find(
                el => el.getAttribute('onclick') === `loadConversation(${partnerId})`
            );
            if (conversationEl) {
                conversationEl.classList.add('bg-indigo-50', 'border-l-4', 'border-indigo-500');
            }

            // Afficher un indicateur de chargement
            document.getElementById('conversationContainer').innerHTML = `
                <div class="flex-1 flex items-center justify-center">
                    <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            `;

            // Charger la conversation
            fetch(`/messages/${partnerId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('conversationContainer').innerHTML = html;
                    setupReplyForm(partnerId);
                    setupDevisButton();
                    scrollToBottom();
                })
                .catch(err => {
                    console.error('Erreur chargement conversation:', err);
                    document.getElementById('conversationContainer').innerHTML = `
                        <div class="flex-1 flex flex-col items-center justify-center text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Erreur lors du chargement de la conversation</p>
                            <button onclick="loadConversation(${partnerId})" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Réessayer
                            </button>
                        </div>
                    `;
                });
        }

        function setupReplyForm(partnerId) {
            const form = document.getElementById('replyForm');

            if (!form) {
                console.error("replyForm introuvable");
                return;
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalContent = submitBtn.innerHTML;

                // Désactiver le bouton et montrer l'indicateur de chargement
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;

                try {
                    const response = await fetch(`/messages/${partnerId}/reply`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }

                    // Effacer le champ de message
                    form.querySelector('input[name="body"]').value = '';

                    // Recharger la conversation après l'envoi du message
                    loadConversation(partnerId);
                } catch (error) {
                    console.error("Erreur lors de l'envoi du message:", error);
                    // Afficher une notification d'erreur
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'text-red-500 text-sm mt-2';
                    errorMsg.textContent = "Erreur lors de l'envoi du message. Veuillez réessayer.";
                    form.appendChild(errorMsg);
                    setTimeout(() => errorMsg.remove(), 5000);

                    // Rétablir le bouton
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }
            });
        }

        function setupDevisButton() {
            const sendDevisBtn = document.getElementById('sendDevis');
            if (!sendDevisBtn) return;

            const reservationId = sendDevisBtn.dataset.reservationId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            sendDevisBtn.addEventListener('click', async function () {
                if (!reservationId) {
                    return alert("Aucune réservation associée.");
                }

                const originalContent = sendDevisBtn.innerHTML;
                sendDevisBtn.disabled = true;
                sendDevisBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Envoi en cours...
                `;

                try {
                    const response = await fetch(`/messages/send-devis-by-reservation/${reservationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        console.error("Status:", response.status, await response.text());
                        throw new Error("Erreur lors de l'envoi du devis.");
                    }

                    const result = await response.json();
                    if (result.success) {
                        // Afficher une notification de succès plus élégante
                        const notif = document.createElement('div');
                        notif.className = 'fixed top-4 right-4 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-lg z-50 flex items-center';
                        notif.innerHTML = `
                            <div class="text-green-500 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-green-800">Devis envoyé avec succès!</p>
                            </div>
                        `;
                        document.body.appendChild(notif);
                        setTimeout(() => notif.remove(), 5000);

                        @if(isset($partner))
                        loadConversation({{ $partner->id }});
                        @endif
                    }
                } catch (error) {
                    console.error(error);

                    // Notification d'erreur
                    const notif = document.createElement('div');
                    notif.className = 'fixed top-4 right-4 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-lg z-50 flex items-center';
                    notif.innerHTML = `
                        <div class="text-red-500 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-red-800">Erreur lors de l'envoi du devis</p>
                        </div>
                    `;
                    document.body.appendChild(notif);
                    setTimeout(() => notif.remove(), 5000);

                    // Rétablir le bouton
                    sendDevisBtn.disabled = false;
                    sendDevisBtn.innerHTML = originalContent;
                }
            });
        }

        function scrollToBottom() {
            const container = document.getElementById('messagesContainer');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        // Initialisation au premier chargement
        document.addEventListener('DOMContentLoaded', function () {
            const partnerId = {{ $partner->id ?? 'null' }};
            if (partnerId) {
                setupReplyForm(partnerId);
                setupDevisButton();
                scrollToBottom();
            }
        });
    </script>
@endsection
