/* resources/views/messages/index.blade.php */
@extends('layouts.app')

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

    <script>
        function loadConversation(partnerId) {
            fetch(`/messages/conversation/${partnerId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('conversationContainer').innerHTML = html;
                })
                .catch(err => console.error('Erreur chargement conversation:', err));
        }
    </script>
@endsection
