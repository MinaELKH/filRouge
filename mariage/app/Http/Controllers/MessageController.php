<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Services\MessageService;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;
    protected $reservationService;

    public function __construct(MessageService $messageService , ReservationService $reservationService )
    {
        $this->messageService = $messageService;
        $this->reservationService = $reservationService;
    }

    public function index(Request $request, $partnerId = null)
    {
        $userId = auth()->id();
        $conversations = $this->messageService->getConversations($userId);

        $partner   = null;
        $messages  = collect();

        if ($partnerId) {
            $data      = $this->messageService->getConversation($userId, $partnerId);
            $partner   = $data['partner'];
            $messages  = $data['messages'];

            // 👇 Ici on teste si c'est une requête AJAX

                return view('messages.partials.conversation', compact('partner', 'messages'));



        }

        return view('messages.index', compact('conversations','partner','messages'));
    }

    // Affiche les messages envoyés par l'utilisateur
    public function sentMessages()
    {
        $userId = auth()->id(); // ou un autre moyen d'obtenir l'ID de l'utilisateur
        $sentMessages = $this->messageService->getSentMessages($userId);

        return view('messages.sent', compact('sentMessages'));
    }

    // Affiche les conversations
    public function conversations()
    {
        $userId = auth()->id(); // ou un autre moyen d'obtenir l'ID de l'utilisateur
        $conversations = $this->messageService->getConversations($userId);

        return view('messages.conversations', compact('conversations'));
    }

    // Affiche une conversation spécifique entre l'utilisateur et un partenaire
    public function showConversation($partnerId)
    {
        $userId = auth()->id();
        $conversation = $this->messageService->getConversation($userId, $partnerId);

        return view('messages._conversation', [
            'messages' => $conversation['messages'],
            'partner' => $conversation['partner'],
        ]);
    }

//    public function sendReply(Request $request, $partnerId)
//    {
//        $request->validate([
//            'body' => 'required|string',
//        ]);
//
//        $this->messageService->createMessage($partnerId, null, $request->body);
//
//        return back();
//    }

    public function sendReply(Request $request, $partnerId)
    {
        $request->validate(['body' => 'required|string']);

        $message = $this->messageService->createMessage(
            $partnerId,
            null ,
            $request->input('body')
        );

        // Debug: Vérifiez que le message est bien créé
        \Log::info('Message created:', $message->toArray());

        return response()->json([
            'success' => true,
            'message' => [
                'body' => $message->body,
                'time' => $message->created_at->format('H:i'),
                'isMe' => true
            ]
        ]);
    }
   //  Créer un nouveau message , avec une nouvelle service , c'est clique sur le button contacter
//    public function store(Request $request)
//    {
//        $validated = $request->validate([
//            'receiver_id' => 'required|exists:users,id',
//            'subject' => 'required|string|max:255',
//            'body' => 'required|string',
//        ]);
//        $message = $this->messageService->createMessage(
//            $validated['receiver_id'],
//            $validated['subject'],
//            $validated['body'],
//            $request->input('service_id') // récupère bien le service_id si fourni
//        );
//
//
//        return response()->json([
//            'success' => true
//        ]);
//    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'service_id' => 'nullable|exists:services,id',
            'event_date' => 'nullable|date|after:today'
        ]);

        $sender = auth()->user();

        // On vérifie s'il existe déjà une réservation similaire (optionnel)
        $reservation = null;

        $reservation = $this->reservationService->findOrCreateReservation([
            'user_id' => $validated['receiver_id'],
            'service_id' => $validated['service_id'],
            'event_date' => $validated['event_date'],
        ]);

        // Créer le message avec les bons IDs
        $message = $this->messageService->createMessage(
            $validated['receiver_id'],
            $validated['subject'],
            $validated['body'],
            $validated['service_id'] ?? null,
            $reservation?->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Message envoyé avec succès.'
        ]);
    }

    public function sendDevisMessage($request, $devisId)
    {


        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $devis = Devis::findOrFail($devisId);
        $url = route('devis.page', ['id' => $devis->id]);

        $message = $this->messageService->createMessage(
            $validated['receiver_id'],
            $validated['subject'],
           "Voici le devis généré : <a href='{$url}",
            $request->input('service_id') // récupère bien le service_id si fourni
        );


        return response()->json([
            'success' => true
        ]);

    }


}
