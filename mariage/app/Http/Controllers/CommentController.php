<?php


namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Service;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    // Ajouter un commentaire
    public function store(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        // Vérifier si l'utilisateur peut créer un commentaire
        $this->authorize('create', [Comment::class, $service]);

        // Créer le commentaire
        $commentData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $commentData['service_id'] = $service->id;
        $this->commentService->createComment($commentData, $service);

        return response()->json(['message' => 'Commentaire ajouté avec succès.'], 201);
    }

    // Modifier un commentaire
    public function update(Request $request, Comment $comment)
    {
        // Vérifier si l'utilisateur peut modifier ce commentaire
        $this->authorize('update', $comment);

        $commentData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $this->commentService->updateComment($comment, $commentData);

        return response()->json(['message' => 'Commentaire mis à jour avec succès.']);
    }

    // Supprimer un commentaire
    public function destroy(Comment $comment)
    {
        // Vérifier si l'utilisateur peut supprimer ce commentaire
        $this->authorize('delete', $comment);

        $this->commentService->deleteComment($comment);

        return response()->json(['message' => 'Commentaire supprimé avec succès.']);
    }

    // Signaler un commentaire
    public function report(Comment $comment)
    {
        // Vérifier si l'utilisateur peut signaler ce commentaire
        $this->authorize('report', $comment);

        $this->commentService->reportComment($comment);

        return response()->json(['message' => 'Commentaire signalé avec succès.']);
    }
}
