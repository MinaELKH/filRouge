<div class="chat-box">
    <h4>Conversation avec {{ $partner->name }}</h4>

    <div class="messages">
        @foreach($messages as $message)
            <div class="message {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}">
                <p>{{ $message->body }}</p>
                <small>{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.reply', $partner->id) }}" method="POST">
        @csrf
        <input type="text" name="body" class="form-control" placeholder="Écrire un message...">
        <button class="btn btn-primary mt-2">Envoyer</button>
    </form>
</div>
