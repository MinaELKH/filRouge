<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Stocker un nouveau commentaire via AJAX
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'comment' => 'required|string|min:3',
        ]);

        // Créer le commentaire
        $review = Review::create([
            'user_id' => auth()->id(),
            'service_id' => $validated['service_id'],
            'comment' => $validated['comment'],
        ]);

        // Charger la relation utilisateur
        $review->load('user');

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'review' => $review,
                'userName' => $review->user->name,
                'createdAt' => $review->created_at->format('d/m/Y'),
                'html' => view('partials.review-item', compact('review'))->render()
            ]);
        }

        return redirect()->back()->with('success', 'Votre commentaire a été publié avec succès !');
    }

    // Supprimer un commentaire via AJAX
    public function destroy(Review $review)
    {
        // Vérifier que l'utilisateur est propriétaire du commentaire
        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vous n\'êtes pas autorisé à supprimer ce commentaire.'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Commentaire supprimé avec succès'
        ]);
    }
}
