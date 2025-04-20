{{--messages.index.blade.php--}}
@extends('layouts.prestataire')

@section('content')
    <div class="h-screen flex overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="w-1/4 bg-white border-r overflow-y-auto">
            <div class="p-4 border-b font-bold text-lg">Messages</div>
            @foreach($conversations as $conv)
                <div class="flex items-center p-4 border-b hover:bg-gray-100 cursor-pointer"
                     onclick="loadConversation({{ $conv['partner']->id }})">
                    <img src="{{ $conv['partner']->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv['partner']->name) }}"
                         class="h-10 w-10 rounded-full mr-3">
                    <div class="flex-1">
                        <div class="font-medium">{{ $conv['partner']->name }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ Str::limit($conv['last_message']->body, 30) }}</div>
                    </div>
                    @if($conv['unread_count'] > 0)
                        <span class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2">{{ $conv['unread_count'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Conversation container -->
        <div id="conversationContainer" class="flex-1 flex flex-col bg-gray-50">
            @if(isset($partner))
                @include('messages.partials.conversation', ['partner' => $partner, 'messages' => $messages])
            @else
                <div class="flex-1 flex items-center justify-center text-gray-400 text-xl">
                    Sélectionnez une conversation
                </div>
            @endif
        </div>
    </div>

{{--    <script>--}}
{{--        function loadConversation(partnerId) {--}}
{{--            fetch(`/messages/${partnerId}`)--}}
{{--                .then(response => response.text())--}}
{{--                .then(html => {--}}
{{--                    document.getElementById('conversationContainer').innerHTML = html;--}}
{{--                })--}}
{{--                .catch(err => console.error('Erreur chargement conversation:', err));--}}
{{--        }--}}
{{--    </script>--}}

    <script>
        function loadConversation(partnerId) {
            fetch(`/messages/${partnerId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('conversationContainer').innerHTML = html;
                    setupReplyForm(partnerId); // Réinitialiser le form après chaque load
                })
                .catch(err => console.error('Erreur chargement conversation:', err));
        }

        function setupReplyForm(partnerId) {
            const form = document.getElementById('replyForm');

            if (!form) {
                console.error("replyForm introuvable");
                return;
            }

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(form);

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

                    // Recharger la conversation après l’envoi du message
                    loadConversation(partnerId);
                } catch (error) {
                    console.error("Erreur lors de l’envoi du message:", error);
                }
            });
        }

        // Si conversation déjà chargée au démarrage, initialiser le form JS
        document.addEventListener('DOMContentLoaded', function () {
            const partnerId = {{ $partner->id ?? 'null' }};
            if (partnerId) {
                setupReplyForm(partnerId);
            }
        });
    </script>

@endsection
