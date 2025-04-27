{{-- messages.conversation.blade.php --}}
<div class="flex-1 flex flex-col overflow-y-auto max-h-[80%]">
    <!-- Header -->
    <div class="bg-white border-b p-4 flex items-center justify-between ">
        <div>
        <img src="{{ $partner->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) . '&background=f76c6f&color=ffffff' }}"
             class="h-10 w-10 rounded-full mr-3 border border-gray-100">
        <div>
            <div class="font-semibold text-gray-800">{{ $partner->name }}</div>
            <div class="text-sm text-gray-500">En ligne</div>
        </div>

        </div>
        @if($partner)
            <div class="p-4 border-t bg-white flex justify-end space-x-3">
                <button
                    id="sendDevis"
                    data-reservation-id="{{ $messages->first()->reservation_id ?? '' }}"
                    class="bg-wedding-pink text-white px-4 py-2 rounded hover:bg-opacity-90">
                    Envoyer un devis
                </button>

                <a href="{{ route('devis.create', $messages->first()->reservation_id) }}"
                   class="border border-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-50">
                    Créer un devis
                </a>
            </div>
        @endif

    </div>

    <!-- Messages -->
    <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs p-3 rounded-lg bg-white border border-gray-100">
                    <p class="text-sm">{!! $msg->body !!}</p>
                    <div class="text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input form -->
    <form id="replyForm" class="p-4 border-t bg-white flex">
        @csrf
        <input type="hidden" name="reservation_id" value="{{ $messages->first()->reservation_id ?? '' }}">
        <input type="text" name="body" placeholder="Écrire un message..."
               class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring focus:border-wedding-pink" required>
        <button type="submit" class="ml-3 bg-wedding-pink text-white px-4 py-2 rounded-full">
            Envoyer
        </button>
    </form>


</div>
