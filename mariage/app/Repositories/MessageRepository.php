<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    // Créer un nouveau message
    public function createMessage($senderId, $receiverId, $subject, $body)
    {
        return Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'subject' => $subject,
            'body' => $body,
        ]);
    }

    // Récupérer tous les messages reçus pour un utilisateur
    public function getReceivedMessages($userId)
    {
        return Message::where('receiver_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    // Récupérer tous les messages envoyés par un utilisateur
    public function getSentMessages($userId)
    {
        return Message::where('sender_id', $userId)->orderBy('created_at', 'desc')->get();
    }

    // Marquer un message comme lu
    public function markAsRead($messageId)
    {
        $message = Message::find($messageId);
        if ($message) {
            $message->status = 'read';
            $message->save();
        }
    }

    // Archiver un message
    public function archiveMessage($messageId)
    {
        $message = Message::find($messageId);
        if ($message) {
            $message->status = 'archived';
            $message->save();
        }
    }

    // Supprimer un message
    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);
        if ($message) {
            $message->delete();
        }
    }
}
