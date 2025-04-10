<?php

namespace App\Services;

use App\Repositories\MessageRepository;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * Créer un message
     *
     * @param int $receiverId
     * @param string $subject
     * @param string $body
     * @return \App\Models\Message
     */
    public function createMessage($receiverId, $subject, $body)
    {
        $senderId = Auth::id(); // Utilisateur connecté
        $senderId = 1 ;
        return $this->messageRepository->createMessage($senderId, $receiverId, $subject, $body);
    }

    /**
     * Récupérer les messages reçus par un utilisateur
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReceivedMessages($userId)
    {
        return $this->messageRepository->getReceivedMessages($userId);
    }

    /**
     * Récupérer les messages envoyés par un utilisateur
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSentMessages($userId)
    {
        return $this->messageRepository->getSentMessages($userId);
    }

    /**
     * Marquer un message comme lu
     *
     * @param int $messageId
     * @return void
     */
    public function markMessageAsRead($messageId)
    {
        $this->messageRepository->markAsRead($messageId);
    }

    /**
     * Archiver un message
     *
     * @param int $messageId
     * @return void
     */
    public function archiveMessage($messageId)
    {
        $this->messageRepository->archiveMessage($messageId);
    }

    /**
     * Supprimer un message
     *
     * @param int $messageId
     * @return void
     */
    public function deleteMessage($messageId)
    {
        $this->messageRepository->deleteMessage($messageId);
    }
}
