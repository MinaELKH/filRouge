// resources/views/messages/conversation.blade.php
@extends('layouts.app')

@section('content')
    <div class="flex h-screen">
        <!-- Sidebar / Liste des prestataires -->
        <div class="w-80 bg-white border-r border-gray-200 flex flex-col">
            <!-- Titre sidebar -->
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Messages des prestataires</h2>
                <div class="flex items-center">
                    <div class="h-2 w-2 bg-red-500 rounded-full mr-2"></div>
                    <button class="text-gray-500" id="toggleSidebar">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <button class="ml-4 border border-gray-300 rounded p-2">
                        <i class="fas fa-edit text-gray-500"></i>
                    </button>
                </div>
            </div>

            <!-- Barre de recherche -->
            <div class="p-4 border-b border-gray-200">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" placeholder="Rechercher messages" class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Liste des prestataires -->
            <div class="flex-1 overflow-y-auto">
                @foreach($conversations as $conversation)
                    @php
                        $partner = $conversation['partner'];
                        $lastMessage = $conversation['last_message'];
                        $unreadCount = $conversation['unread_count'];
                        $isActive = $partner->id == $partner->id;

                        // Déterminer la date à afficher
                        $date = $lastMessage->created_at->diffInDays(now()) <= 3
                            ? $lastMessage->created_at->diffInDays(now()) . 'd'
                            : $lastMessage->created_at->format('j/n/y');
                    @endphp

                    <a href="{{ route('conversations.show', $partner->id) }}"
                       class="border-b border-gray-200 p-4 hover:bg-gray-50 cursor-pointer flex {{ $isActive ? 'bg-gray-100' : '' }}">
                        <img src="{{ $partner->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) }}"
                             class="h-10 w-10 rounded-full object-cover mr-3">
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <div>
                                    @if($lastMessage->created_at->diffInDays(now()) < 15 && $unreadCount > 0)
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full mr-1">
                                        Reçu il y a {{ $lastMessage->created_at->diffInDays(now()) }} jours
                                    </span>
                                    @endif
                                    <h3 class="font-medium text-gray-800">{{ $partner->serviceProvider->business_name ?? $partner->name }}</h3>
                                    @if($partner->serviceProvider && $partner->serviceProvider->location)
                                        <p class="text-xs text-gray-500">{{ $partner->serviceProvider->location }}</p>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500">{{ $date }}</span>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-500 truncate">
                                    {{ Str::limit($lastMessage->body, 30) }}
                                </p>
                                @if($unreadCount > 0)
                                    <span class="bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    {{ $unreadCount }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Section principale / Conversation -->
        <div class="flex-1 flex flex-col">
            <!-- Header de la conversation -->
            <div class="bg-white border-b border-gray-200 p-4 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">{{ $partner->serviceProvider->business_name ?? $partner->name }}</h2>
                    <p class="text-sm text-gray-500">
                        Répond habituellement en {{ $partner->serviceProvider->response_time ?? '24h' }}
                    </p>
                </div>
                <button class="text-gray-500">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-4 bg-gray-50" id="messages-container">
                @foreach($messages as $message)
                    @php
                        $isFromUser = $message->sender_id === auth()->id();
                    @endphp

                    <div class="flex mb-6 {{ $isFromUser ? 'justify-end' : '' }}">
                        @if(!$isFromUser)
                            <img src="{{ $partner->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) }}"
                                 class="h-8 w-8 rounded-full object-cover mr-3">
                        @else
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white mr-3">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center">
                                <span class="font-medium mr-2">{{ $isFromUser ? 'Vous' : $partner->serviceProvider->business_name ?? $partner->name }}</span>
                                <span class="text-xs text-gray-500">{{ $message->created_at->format('d/m/Y - H:i') }}</span>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm mt-1 max-w-lg">
                                <p>{{ $message->body }}</p>

                                @if(isset($message->metadata) && isset($message->metadata['event_date']))
                                    <p class="text-sm text-gray-500 mt-2">Date du mariage: {{ $message->metadata['event_date'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($loop->last && $message->sender_id != auth()->id() && $message->created_at->diffInDays(now()) > 3)
                        <!-- Message en attente -->
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6 flex items-start">
                            <div class="text-blue-500 mr-3 mt-1">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <p class="text-blue-700">
                                    {{ $partner->serviceProvider->business_name ?? $partner->name }} attend votre réponse.
                                    Dites-lui si vous souhaitez toujours profiter de ses services. Sinon,
                                    <a href="{{ route('messages.archive', $message->id) }}"
                                       class="text-blue-600 underline archive-link">archivez cette conversation</a>.
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Actions rapides -->
            <div class="p-4 bg-gray-50 border-t border-gray-200 flex gap-2">
                <button class="quick-reply bg-white border border-gray-300 rounded-full px-4 py-2 text-gray-700 hover:bg-gray-50"
                        data-reply="Ça m'intéresse...">
                    Ça m'intéresse...
                </button>
                <button class="quick-reply bg-white border border-gray-300 rounded-full px-4 py-2 text-gray-700 hover:bg-gray-50"
                        data-reply="Je réfléchis...">
                    Je réfléchis...
                </button>
                <button class="quick-reply bg-white border border-gray-300 rounded-full px-4 py-2 text-gray-700 hover:bg-gray-50"
                        data-reply="Non, merci...">
                    Non, merci...
                </button>
            </div>

            <!-- Input message -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form id="message-form" action="{{ route('conversations.store', $partner->id) }}" method="POST">
                    @csrf
                    <div class="border border-gray-300 rounded-lg px-4 py-3 flex items-center">
                        <button type="button" class="text-gray-500 mr-2">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="text" name="body" placeholder="Répondre à {{ $partner->serviceProvider->business_name ?? $partner->name }}..."
                               class="flex-1 outline-none text-gray-700" id="message-input">
                        <button type="submit" class="text-blue-500 ml-2">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panneau d'information -->
        @if($partner->serviceProvider)
            <div class="w-80 bg-white border-l border-gray-200 flex flex-col">
                <!-- Header profile -->
                <div class="relative">
                    <img src="{{ $partner->serviceProvider->profile_image ?? 'https://via.placeholder.com/400x200' }}"
                         class="w-full h-48 object-cover" alt="Profile cover">
                    <div class="absolute bottom-0 right-0 flex">
                        @for($i = 0; $i < 5; $i++)
                            <div class="w-3 h-3 bg-white rounded-full m-0.5"></div>
                        @endfor
                    </div>
                </div>

                <!-- Nom agence -->
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-center">{{ $partner->serviceProvider->business_name }}</h2>
                </div>

                <!-- Informations -->
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-map-marker-alt text-gray-500 mr-3"></i>
                        <span>{{ $partner->serviceProvider->location }}</span>
                    </div>
                    <div class="flex items-center mb-3">
                        <i class="fas fa-tag text-gray-500 mr-3"></i>
                        <span>À partir de {{ $partner->serviceProvider->price_from }}€</span>
                    </div>
                    @if($partner->serviceProvider->has_promotion)
                        <div class="flex items-center">
                            <i class="fas fa-percent text-gray-500 mr-3"></i>
                            <span>1 promotion</span>
                        </div>
                    @endif
                </div>

                <!-- Boutons d'action -->
                <div class="p-4 flex gap-2">
                    <button class="flex-1 bg-white border border-gray-300 rounded-full py-2 px-4 flex items-center justify-center text-green-600">
                        <i class="fas fa-check-circle mr-2"></i>
                        Engagé
                    </button>
                    <button class="flex-1 bg-white border border-gray-300 rounded-full py-2 px-4 flex items-center justify-center text-red-500">
                        <i class="fas fa-times-circle mr-2"></i>
                        Non retenu
                    </button>
                </div>

                <!-- Détails de la conversation -->
                <div class="p-4">
                    <h3 class="font-semibold mb-2">Détails de la conversation</h3>
                    <p class="text-sm text-gray-700 mb-4">
                        Votre premier contact avec ce prestataire a eu lieu le
                        {{ $messages->first()->created_at->format('d/m/Y') }}
                    </p>

                    @if(isset($messages->first()->metadata) && isset($messages->first()->metadata['event_date']))
                        <h4 class="font-medium text-gray-800 mb-1">Date du mariage</h4>
                        <p class="text-sm text-gray-700">{{ $messages->first()->metadata['event_date'] }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleSidebarBtn = document.getElementById('toggleSidebar');
            const sidebar = document.querySelector('.w-80:first-child');

            toggleSidebarBtn.addEventListener('click', () => {
                const icon = toggleSidebarBtn.querySelector('i');
                if (icon.classList.contains('fa-chevron-down')) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                    sidebar.classList.add('hidden');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                    sidebar.classList.remove('hidden');
                }
            });

            // Ajax pour envoyer les messages
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const messagesContainer = document.getElementById('messages-container');

            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(messageForm);

                fetch(messageForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Ajout du message à la conversation
                            const date = new Date();
                            const formattedDate = `${date.getDate()}/${date.getMonth()+1}/${date.getFullYear()} - ${date.getHours()}:${date.getMinutes()}`;

                            const messageHtml = `
                        <div class="flex mb-6 justify-end">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white mr-3">
                                ${document.querySelector('meta[name="user-initial"]').getAttribute('content')}
                            </div>
                            <div>
                                <div class="flex items-center">
                                    <span class="font-medium mr-2">Vous</span>
                                    <span class="text-xs text-gray-500">${formattedDate}</span>
                                </div>
                                <div class="bg-white rounded-lg p-3 shadow-sm mt-1 max-w-lg">
                                    <p>${messageInput.value}</p>
                                </div>
                            </div>
                        </div>
                    `;

                            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                            messageInput.value = '';

                            // Scroll to bottom
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Quick replies
            document.querySelectorAll('.quick-reply').forEach(button => {
                button.addEventListener('click', function() {
                    messageInput.value = this.dataset.reply;
                    messageForm.dispatchEvent(new Event('submit'));
                });
            });

            // Archive links with AJAX
            document.querySelectorAll('.archive-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    fetch(this.href, {
                        method: 'PUT',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.closest('.bg-blue-50').remove();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Scroll to bottom on load
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    </script>
@endpush
