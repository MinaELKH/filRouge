<?php


namespace App\Services;


use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    // Récupérer tous les commentaires d'un service
    public function getCommentsByService(int $serviceId)
    {
        return $this->commentRepository->getByService($serviceId);
    }

    // Créer un commentaire
    public function createComment(array $data)
    {
        $data['user_id'] = Auth::id();  // L'utilisateur authentifié
        return $this->commentRepository->create($data);
    }

    // Modifier un commentaire
    public function updateComment(Comment $comment, array $data)
    {
        return $this->commentRepository->update($comment, $data);
    }

    // Supprimer un commentaire
    public function deleteComment(Comment $comment)
    {
        return $this->commentRepository->delete($comment);
    }

    // Signaler un commentaire
    public function reportComment(Comment $comment)
    {
        // On peut ajouter une logique spécifique de signalement, par exemple,
        // en ajoutant un champ 'reported' ou similaire pour indiquer qu'un commentaire a été signalé.
        return $comment->update(['reported' => true]);
    }
}
