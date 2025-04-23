{{--messages.partial.conversation.blade.php--}}4

<div class="flex-1 flex flex-col overflow-y-auto max-h-[80%]">
    <!-- Header -->
    <div class="bg-white border-b p-4 flex items-center">
        <img src="{{ $partner->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) }}"
             class="h-10 w-10 rounded-full mr-3">
        <div>
            <div class="font-semibold">{{ $partner->name }}</div>
            <div class="text-sm text-gray-500">En ligne</div>
        </div>
    </div>

    <!-- Messages -->
    <!-- Messages -->
    <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs p-3 rounded-lg shadow-sm {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-white' }}">
                    <p class="text-sm">{!! $msg->body !!}</p>
                    <div class="text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Input form -->
    <form id="replyForm" class="p-4 border-t bg-white flex">
        @csrf
        <input type="text" name="reservation_id" value="{{ $messages->first()->reservation_id ?? '' }}">
        <input type="text" name="body" placeholder="Écrire un message..."
               class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring" required>
        <button type="submit" class="ml-3 bg-blue-500 text-white px-4 py-2 rounded-full">
            Envoyer
        </button>

    </form>

    @if($partner )
        <div class="p-4 border-b bg-white flex justify-end">
            <button
                id="sendDevis"
                data-reservation-id="{{ $messages->first()->reservation_id ?? '' }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Envoyer un devis
            </button>
            <a href="{{ route('devis.create', ['reservation_id' => $reservation->id]) }}"
               target="_blank"
               class="btn btn-primary">
                ➕ Créer un devis
            </a>
        </div>
    @endif
</div>



