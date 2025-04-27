<?php

namespace App\Services;

use App\Models\Service;
use App\Models\User;
use App\Repositories\Contracts\MessageRepositoryInterface;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }



    public function createMessage($receiverId, $subject, $body, $serviceId = null, $reservationId = null)
    {

        return $this->messageRepository->createMessage(
            auth()->id(),
            $receiverId,
            $subject,
            $body,
            $reservationId,
        );
    }

    public function getReceivedMessages($userId)
    {
        return $this->messageRepository->getReceivedMessages($userId);
    }

    public function getSentMessages($userId)
    {
        return $this->messageRepository->getSentMessages($userId);
    }

    public function markMessageAsRead($messageId)
    {
        $this->messageRepository->markAsRead($messageId);
    }

    public function archiveMessage($messageId)
    {
        $this->messageRepository->archiveMessage($messageId);
    }

    public function deleteMessage($messageId)
    {
        $this->messageRepository->deleteMessage($messageId);
    }

//    public function getConversations($userId)
//    {
//        $partnerIds = $this->messageRepository->getDistinctPartners($userId);
//        $conversations = [];
//
//        foreach ($partnerIds as $partnerId) {
//            $lastMessage = $this->messageRepository->getLastMessageBetween($userId, $partnerId);
//
//            if ($lastMessage) {
//                $partner = User::find($partnerId);
//                $unreadCount = $this->messageRepository->countUnreadMessages($partnerId, $userId);
//
//                $conversations[] = [
//                    'partner' => $partner,
//                    'last_message' => $lastMessage,
//                    'unread_count' => $unreadCount,
//                ];
//            }
//        }
//
//        usort($conversations, fn($a, $b) => $b['last_message']->created_at <=> $a['last_message']->created_at);
//
//        return $conversations;
//    }
    public function getConversations($userId)
    {
        // Récupérer toutes les réservations distinctes avec des messages
        $reservations = $this->messageRepository->getDistinctReservationsWithMessages($userId);
        $conversations = [];

        foreach ($reservations as $reservation) {
            $lastMessage = $this->messageRepository->getLastMessageForReservation($reservation->id);

            if ($lastMessage) {
                // Déterminer le partenaire (celui qui n'est pas l'utilisateur actuel)
                $partnerId = $lastMessage->sender_id == $userId ? $lastMessage->receiver_id : $lastMessage->sender_id;
                $partner = User::find($partnerId);

                $unreadCount = $this->messageRepository->countUnreadMessagesForReservation($reservation->id, $userId);

                $conversations[] = [
                    'reservation' => $reservation,
                    'service' => $reservation->service, // Assurez-vous que la relation est chargée
                    'partner' => $partner,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                ];
            }
        }

        usort($conversations, fn($a, $b) => $b['last_message']->created_at <=> $a['last_message']->created_at);

        return $conversations;
    }

    public function getConversationByReservation($userId, $reservationId)
    {
        $messages = $this->messageRepository->getMessagesForReservation($reservationId);

        // Marquer les messages comme lus
        $this->messageRepository->markReservationMessagesAsRead($reservationId, $userId);

        // Trouver le partenaire
        $firstMessage = $messages->first();
        if ($firstMessage) {
            $partnerId = $firstMessage->sender_id == $userId ? $firstMessage->receiver_id : $firstMessage->sender_id;
            $partner = User::find($partnerId);
        } else {
            $partner = null;
        }

        $reservation = \App\Models\Reservation::with('service')->find($reservationId);

        return [
            'messages' => $messages,
            'partner' => $partner,
            'reservation' => $reservation,
        ];
    }
    public function getConversation($userId, $partnerId)
    {
        $messages = $this->messageRepository->getMessagesBetween($userId, $partnerId);
        $this->messageRepository->markMessagesAsRead($partnerId, $userId);

      //  $partner = User::with('serviceProvider')->find($partnerId);
        $partner = User::find($partnerId);
        return [
            'messages' => $messages,
            'partner' => $partner,
        ];
    }
}
