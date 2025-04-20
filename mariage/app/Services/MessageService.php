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

//    public function createMessage($receiverId, $subject, $body , $serviceId = null)
//    {
//        $senderId = auth()->id(); // ou fixe comme $senderId = 1 pour les tests
////        if (!$subject && $serviceId) {
////            $service = Service::find($serviceId);
////            $subject = "Demande concernant le service : " . $service->titre;
////        }
//        return $this->messageRepository->createMessage($senderId, $receiverId, $subject, $body);
//    }

    public function createMessage($receiverId, $subject, $body, $serviceId = null, $reservationId = null)
    {

        return $this->messageRepository->createMessage(
            auth()->id(),
            $receiverId,
            $subject,
            $body,
            $serviceId,
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

    public function getConversations($userId)
    {
        $partnerIds = $this->messageRepository->getDistinctPartners($userId);
        $conversations = [];

        foreach ($partnerIds as $partnerId) {
            $lastMessage = $this->messageRepository->getLastMessageBetween($userId, $partnerId);

            if ($lastMessage) {
                $partner = User::find($partnerId);
                $unreadCount = $this->messageRepository->countUnreadMessages($partnerId, $userId);

                $conversations[] = [
                    'partner' => $partner,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                ];
            }
        }

        usort($conversations, fn($a, $b) => $b['last_message']->created_at <=> $a['last_message']->created_at);

        return $conversations;
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
