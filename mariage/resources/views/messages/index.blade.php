@extends('layouts.main')

@section('content')
    <div class="h-screen flex overflow-hidden rounded-lg shadow-sm">
        <!-- Sidebar -->
        <div id="sidebar" class="w-1/4 bg-white border-r overflow-y-auto">
            <div class="p-4 border-b font-bold text-lg bg-wedding-pink text-white">Messages</div>
            @foreach($conversations as $conv)
                <div class="flex items-center p-4 border-b hover:bg-pink-50 cursor-pointer transition-colors"
                     onclick="loadConversation({{ $conv['reservation']->id }})">
                    <img
                        src="{{ $conv['partner']->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv['partner']->name) }}"
                        class="h-10 w-10 rounded-full mr-3 border border-gray-100">
                    <div class="flex-1">
                        <div class="font-medium text-gray-800">{{ $conv['partner']->name }}</div>
                        <div class="text-sm text-gray-600">{{ $conv['service']->title }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ Str::limit($conv['last_message']->body, 30) }}</div>
                    </div>
                    @if($conv['unread_count'] > 0)
                        <span class="text-xs bg-wedding-pink text-white rounded-full px-2 py-1 ml-2">{{ $conv['unread_count'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Conversation container -->
        <div id="conversationContainer" class="flex-1 flex flex-col bg-gray-50">
            @if(isset($partner))
                @include('messages.partials.conversation', [
                    'messages' => $messages,
                    'partner' => $partner,
                    'reservation' => $reservation
                ])
            @else
                <div class="flex-1 flex items-center justify-center text-gray-400 text-xl">
                    <i class="fas fa-comments text-wedding-pink text-3xl mr-3"></i>
                    Sélectionnez une conversation
                </div>
            @endif
        </div>
    </div>

    <script>
        function loadConversation(partnerId) {
            fetch(`/messages/${partnerId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('conversationContainer').innerHTML = html;
                    setupReplyForm(partnerId);
                    setupDevisButton();
                    scrollToBottom();
                })
                .catch(err => console.error('Erreur chargement conversation:', err));
        }

        function setupReplyForm(reservationId) {
            const form = document.getElementById('replyForm');

            if (!form) {
                console.error("replyForm introuvable");
                return;
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    const response = await fetch(`/messages/reservation/${reservationId}/reply`, {
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

                    loadConversation(reservationId);
                } catch (error) {
                    console.error("Erreur lors de l'envoi du message:", error);
                }
            });
        }


        function setupDevisButton() {
            const sendDevisBtn = document.getElementById('sendDevis');
            if (!sendDevisBtn) return;

            const reservationId = sendDevisBtn.dataset.reservationId;
            const csrfToken   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            sendDevisBtn.addEventListener('click', async function () {
                if (!reservationId) {
                    return alert("Aucune réservation associée.");
                }

                try {
                    const response = await fetch(`/messages/send-devis-by-reservation/${reservationId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept':       'application/json',
                        }
                    });

                    if (!response.ok) {
                        console.error("Status:", response.status, await response.text());
                        throw new Error("Erreur lors de l'envoi du devis.");
                    }

                    const result = await response.json();
                    if (result.success) {
                        alert("✅ Devis envoyé !");
                        @if(isset($partner))
                        loadConversation({{ $partner->id }});
                        @endif
                    }
                } catch (error) {
                    console.error(error);
                    alert("Une erreur est survenue.");
                }
            });
        }

        // Initialisation au premier chargement
        document.addEventListener('DOMContentLoaded', function () {
            const partnerId = {{ $partner->id ?? 'null' }};
            if (partnerId) {
                setupReplyForm(partnerId);
                setupDevisButton(); // 👈 Important ici aussi au 1er affichage
            }
        });
    </script>

    <script>
        // defilment du boite messagerie
        function scrollToBottom() {
            const container = document.getElementById('messagesContainer');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        // On appelle cette fonction après chargement des messages
        document.addEventListener('DOMContentLoaded', function () {
            scrollToBottom();
        });


    </script>
@endsection
