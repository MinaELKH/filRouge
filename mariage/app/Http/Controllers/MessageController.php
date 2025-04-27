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
// Dans MessageController.php
//    public function index(Request $request, $partnerId = null)
//    {
//        $userId = auth()->id();
//        $conversations = $this->messageService->getConversations($userId);
//
//        $partner = null;
//        $messages = collect();
//
//        if ($partnerId) {
//            $data = $this->messageService->getConversation($userId, $partnerId);
//            $partner = $data['partner'];
//            $messages = $data['messages'];
//
//            // Ne retourner la vue partielle que si c'est une requête AJAX
//            if ($request->ajax()) {
//                //return view('messages.partial.conversation', compact('partner', 'messages'));
//                return view('messages.partials.conversation', compact('partner', 'messages'));
//
//            }
//
//            // Sinon, retourner la vue complète avec la conversation sélectionnée
//        }
//
//        // Toujours retourner la vue complète dans le cas non-AJAX
//        return view('messages.index', compact('conversations', 'partner', 'messages'));
//    }


    public function index(Request $request, $reservationId = null)
    {
        $userId = auth()->id();
        $conversations = $this->messageService->getConversations($userId);

        $partner = null;
        $messages = collect();
        $reservation = null;

        if ($reservationId) {
            $data = $this->messageService->getConversationByReservation($userId, $reservationId);
            $partner = $data['partner'];
            $messages = $data['messages'];
            $reservation = $data['reservation'];

            if ($request->ajax()) {
                return view('messages.partials.conversation', compact('partner', 'messages', 'reservation'));
            }
        }

        return view('messages.index', compact('conversations', 'partner', 'messages', 'reservation'));
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

        $messages = $conversation['messages'];
    //    $reservationId = $messages->first()->reservation_id ?? null;

        return view('messages._conversation', [
            'messages' => $messages,
            'partner' => $conversation['partner'],
            'reservationId' => $messages->first()->reservation_id ?? '' ,
        ]);
    }

    public function sendReply(Request $request, $partnerId)
    {
        $request->validate([
            'body' => 'required|string',
            'reservation_id' => 'required|exists:reservations,id',
        ]);

        $message = $this->messageService->createMessage(
            $partnerId,
            null,
            $request->input('body'),
            null,
            $request->input('reservation_id') // 👈 ajoute ce paramètre ici
        );

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
            'user_id' => $sender->id,
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

    public function sendDevisByReservation($reservationId)
    {
        $devis = Devis::where('reservation_id', $reservationId)->firstOrFail();
      //  $this->authorize('sendMessageForDevis', $devis);

        $receiverId = $devis->reservation->user_id;
        // Utilise le bon nom de paramètre:
        $url = route('devis.show', ['devi' => $devis->id]);

        $messageContent = "Bonjour, voici le devis généré pour votre demande : "
            . "<a href=\"{$url}\" target=\"_blank\" class=\"text-blue-600 underline\">Voir le devis</a>";

        $this->messageService->createMessage(
            $receiverId,
            'Devis pour votre réservation',
            $messageContent,
            null,
            $reservationId
        );

        return response()->json(['success' => true]);
    }


}
