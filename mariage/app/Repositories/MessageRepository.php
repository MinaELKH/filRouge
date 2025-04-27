<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Contracts\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    // Créer un nouveau message
    public function createMessage($senderId, $receiverId, $subject, $body, $reservationId = null )
    {
        return Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'subject' => $subject,
            'body' => $body,
            'reservation_id' => $reservationId,
           // 'service_id' => $serviceId,

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



    public function getDistinctPartners($userId)
    {
        $sent = Message::where('sender_id', $userId)->select('receiver_id as partner_id');
        $received = Message::where('receiver_id', $userId)->select('sender_id as partner_id');

        return $sent->union($received)->distinct()->pluck('partner_id');
    }

    public function getLastMessageBetween($userId, $partnerId)
    {
        return Message::where(function($query) use ($userId, $partnerId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $partnerId);
        })->orWhere(function($query) use ($userId, $partnerId) {
            $query->where('sender_id', $partnerId)
                ->where('receiver_id', $userId);
        })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function countUnreadMessages($fromId, $toId)
    {
        return Message::where('sender_id', $fromId)
            ->where('receiver_id', $toId)
            ->whereNull('read_at')
            ->count();
    }

    public function getMessagesBetween($userId, $partnerId)
    {
        return Message::where(function($query) use ($userId, $partnerId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $partnerId);
        })->orWhere(function($query) use ($userId, $partnerId) {
            $query->where('sender_id', $partnerId)
                ->where('receiver_id', $userId);
        })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function markMessagesAsRead($fromId, $toId)
    {
        return Message::where('sender_id', $fromId)
            ->where('receiver_id', $toId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }


    public function getDistinctReservationsWithMessages($userId)
    {
        return Message::where(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
            ->whereNotNull('reservation_id')
            ->with('reservation.service')
            ->select('reservation_id')
            ->distinct()
            ->get()
            ->pluck('reservation');
    }

    public function getLastMessageForReservation($reservationId)
    {
        return Message::where('reservation_id', $reservationId)
            ->latest()
            ->first();
    }

    public function getMessagesForReservation($reservationId)
    {
        return Message::where('reservation_id', $reservationId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function countUnreadMessagesForReservation($reservationId, $userId)
    {
        return Message::where('reservation_id', $reservationId)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    public function markReservationMessagesAsRead($reservationId, $userId)
    {
        Message::where('reservation_id', $reservationId)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
