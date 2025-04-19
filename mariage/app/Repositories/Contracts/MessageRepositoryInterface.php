<?php

namespace App\Repositories\Contracts;


interface MessageRepositoryInterface
{
    public function createMessage($senderId, $receiverId, $subject, $body);
    public function getReceivedMessages($userId);
    public function getSentMessages($userId);
    public function markAsRead($messageId);
    public function archiveMessage($messageId);
    public function deleteMessage($messageId);
    public function getDistinctPartners($userId);
    public function getLastMessageBetween($userId, $partnerId);
    public function countUnreadMessages($fromId, $toId);
    public function getMessagesBetween($userId, $partnerId);
    public function markMessagesAsRead($fromId, $toId);
}


