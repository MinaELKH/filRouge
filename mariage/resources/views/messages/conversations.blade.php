<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messagerie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gray-100 flex overflow-hidden">

<!-- Sidebar des conversations -->
<div class="w-1/4 bg-white border-r overflow-y-auto">
    <div class="p-4 border-b font-bold text-lg">Messages</div>

    @foreach ($conversations as $conv)
        <a href="{{ route('messages.conversation', $conv['partner']->id) }}" class="flex items-center p-4 border-b hover:bg-gray-100 @if(request()->route('partnerId') == $conv['partner']->id) bg-gray-200 @endif">
            <img src="{{ $conv['partner']->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($conv['partner']->name) }}" class="h-10 w-10 rounded-full mr-3">
            <div class="flex-1">
                <div class="font-medium">{{ $conv['partner']->name }}</div>
                <div class="text-sm text-gray-500 truncate">{{ $conv['last_message']->body }}</div>
            </div>
            @if($conv['unread_count'] > 0)
                <span class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2">{{ $conv['unread_count'] }}</span>
            @endif
        </a>
    @endforeach
</div>
<!-- Zone de chat (au centre) -->
<div class="col-md-8" id="chat-content">
    <!-- Le contenu de _conversation.blade.php viendra ici -->
</div>
<!-- Section des messages -->
<div class="flex-1 flex flex-col">
    @if(isset($partner))
        <div class="p-4 border-b bg-white flex items-center">
            <img src="{{ $partner->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($partner->name) }}" class="h-10 w-10 rounded-full mr-3">
            <div>
                <div class="font-semibold">{{ $partner->name }}</div>
                <div class="text-sm text-gray-500">En ligne</div>
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
            @foreach($messages as $msg)
                <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs p-3 rounded-lg shadow {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-white' }}">
                        <p class="text-sm">{{ $msg->body }}</p>
                        <div class="text-xs mt-1 text-right opacity-70">{{ $msg->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formulaire d'envoi -->
        <form action="{{ route('messages.send', $partner->id) }}" method="POST" class="p-4 border-t bg-white">
            @csrf
            <div class="flex">
                <input type="text" name="body" placeholder="Écrire un message..." class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring">
                <button type="submit" class="ml-3 bg-blue-500 text-white px-4 py-2 rounded-full">Envoyer</button>
            </div>
        </form>
    @else
        <div class="flex-1 flex items-center justify-center text-gray-400 text-xl">Sélectionnez une conversation</div>
    @endif
</div>
<script>
    document.querySelectorAll('.conversation-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const partnerId = this.dataset.partnerId;

            fetch(`/messages/conversation/${partnerId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('chat-content').innerHTML = html;
                });
        });
    });
</script>
</body>
</html>
