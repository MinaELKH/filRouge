<div class="flex-1 flex flex-col">
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
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach($messages as $msg)
            <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs p-3 rounded-lg shadow-sm {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-white' }}">
                    <p class="text-sm">{{ $msg->body }}</p>
                    <div class="text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input form -->
    <form id="replyForm" data-partner-id="{{ $partner->id }}" class="p-4 border-t bg-white flex">
        @csrf
        <input type="text" name="body" placeholder="Écrire un message..."
               class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring">
        <button type="submit" class="ml-3 bg-blue-500 text-white px-4 py-2 rounded-full">Envoyer</button>
    </form>


</div>

<script>
    document.getElementById('replyForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const body = form.body.value;
        const token = document.querySelector('input[name="_token"]').value;
        const partnerId = form.dataset.partnerId;

        fetch(`/messages/${partnerId}/reply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ body: body })
        })
            .then(response => {
                if (!response.ok) throw new Error('Erreur lors de l’envoi du message');
                form.body.value = ''; // reset input

                // Recharger les messages après envoi
                return fetch(`/messages/${partnerId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('conversationContainer').innerHTML = html;
            })
            .catch(error => {
                console.error(error);
                alert('Erreur lors de l’envoi du message.');
            });
    });
</script>
