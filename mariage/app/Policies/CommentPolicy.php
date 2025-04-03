<?php


namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use App\Models\Service;

class CommentPolicy
{
    /**
     * Déterminer si l'utilisateur peut ajouter un commentaire.
     */
    public function create(User $user, Service $service)
    {
        // Tous les utilisateurs peuvent commenter un service.
        return $user->role === 'client' || $user->role === 'admin' || $user->role === 'prestataire';
    }

    /**
     * Déterminer si l'utilisateur peut modifier un commentaire.
     */
    public function update(User $user, Comment $comment)
    {
        // Un utilisateur peut modifier un commentaire s'il en est l'auteur
        return $user->id === $comment->user_id ;
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un commentaire.
     */
    public function delete(User $user, Comment $comment)
    {
        // Seul l'admin ou l'auteur du commentaire peut supprimer ce commentaire
        return $user->id === $comment->user_id || $user->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut signaler un commentaire.
     */
    public function report(User $user, Comment $comment)
    {
        // Seul le prestataire peut signaler un commentaire
        return $user->role === 'prestataire';
    }
}
