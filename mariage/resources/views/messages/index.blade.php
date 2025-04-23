{{-- messages._conversation.blade.php --}}
<div class="flex-1 flex flex-col h-full">
    <!-- Header -->
    <div class="bg-white border-b p-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center">
            <img src="{{ $partner->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) . '&background=4F46E5&color=fff' }}"
                 class="h-12 w-12 rounded-full mr-3 border-2 border-indigo-100">
            <div>
                <div class="font-semibold text-gray-800">{{ $partner->name }}</div>
                <div class="text-xs text-gray-500 flex items-center">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                    En ligne
                </div>
            </div>
        </div>

        @if(isset($reservationId) && $reservationId)
            <span class="text-xs bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full">
                Réservation #{{ $reservationId }}
            </span>
        @endif
    </div>

    <!-- Messages container -->
    <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
        @foreach($messages as $msg)
            @php
                $isMine = $msg->sender_id === auth()->id();
            @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }} mb-4">
                @if(!$isMine)
                    <img src="{{ $partner->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) . '&background=4F46E5&color=fff' }}"
                         class="h-8 w-8 rounded-full mr-2 self-end">
                @endif
                <div class="max-w-md rounded-lg shadow-sm p-3 {{ $isMine ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none' }}">
                    <p class="text-sm whitespace-pre-wrap">{!! nl2br(e($msg->body)) !!}</p>
                    <div class="text-xs {{ $isMine ? 'text-indigo-200' : 'text-gray-400' }} mt-1 text-right">
                        {{ $msg->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                @if($isMine)
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4F46E5&color=fff' }}"
                         class="h-8 w-8 rounded-full ml-2 self-end">
                @endif
            </div>
        @endforeach
    </div>

    <!-- Action bar -->
    @if($partner && isset($reservationId) && $reservationId)
        <div class="bg-gray-50 border-t p-3 flex items-center justify-end space-x-3">
            <button
                id="sendDevis"
                data-reservation-id="{{ $reservationId }}"
                class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition focus:outline-none focus:ring-2 focus:ring-indigo-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd" />
                </svg>
                Envoyer un devis
            </button>

            <a href="{{ route('devis.create', $reservationId) }}"
               class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Créer un devis
            </a>
        </div>
    @endif

    <!-- Input form -->
    <form id="replyForm" class="p-3 border-t bg-white flex items-center">
        @csrf
        <input type="hidden" name="reservation_id" value="{{ $reservationId ?? '' }}">

        <div class="flex-1 relative">
            <input type="text" name="body" placeholder="Écrire un message..."
                   class="w-full px-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent pr-10" required>

            {{-- On peut ajouter un bouton emoji ou autre ici --}}
            {{-- <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button> --}}
        </div>

        <button type="submit" class="ml-3 bg-indigo-600 text-white p-3 rounded-full hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
            </svg>
        </button>
    </form>
</div>
