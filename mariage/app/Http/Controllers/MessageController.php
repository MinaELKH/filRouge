<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    // Afficher les messages reçus
    public function indexReceived($userId)
    {
        $messages = $this->messageService->getReceivedMessages($userId);
        return view('messages.received', compact('messages'));
    }

    // Afficher les messages envoyés
    public function indexSent($userId)
    {
        $messages = $this->messageService->getSentMessages($userId);
        return view('messages.sent', compact('messages'));
    }

    // Créer un nouveau message
    public function create(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $message = $this->messageService->createMessage(
            $validated['receiver_id'],
            $validated['subject'],
            $validated['body']
        );

        return response()->json([
            'success' => true
        ]);
    }

    // Marquer un message comme lu
    public function markAsRead($messageId)
    {
        $this->messageService->markMessageAsRead($messageId);
        return redirect()->back()->with('success', 'Message marqué comme lu!');
    }

    // Archiver un message
    public function archive($messageId)
    {
        $this->messageService->archiveMessage($messageId);
        return redirect()->back()->with('success', 'Message archivé!');
    }

    // Supprimer un message
    public function delete($messageId)
    {
        $this->messageService->deleteMessage($messageId);
        return redirect()->back()->with('success', 'Message supprimé!');
    }
}
