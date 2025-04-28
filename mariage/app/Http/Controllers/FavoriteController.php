<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Afficher les favoris de l'utilisateur connecté
    public function index()
    {
        $favorites = auth()->user()->favoritedServices()->with(['category', 'ville', 'user'])->get();
        return view('client.favorites', compact('favorites'));
    }

    // Ajouter un service aux favoris
    public function store(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        // Vérifier si le service est déjà dans les favoris
        $existingFavorite = Favorite::where('user_id', auth()->id())
            ->where('service_id', $serviceId)
            ->first();

        if (!$existingFavorite) {
            Favorite::create([
                'user_id' => auth()->id(),
                'service_id' => $serviceId
            ]);
            return response()->json(['success' => true, 'message' => 'Service ajouté aux favoris']);
        }

        return response()->json(['success' => false, 'message' => 'Service déjà dans vos favoris']);
    }

    // Supprimer un service des favoris
    public function destroy($serviceId)
    {
        $favorite = Favorite::where('user_id', auth()->id())
            ->where('service_id', $serviceId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['success' => true, 'message' => 'Service retiré des favoris']);
        }

        return response()->json(['success' => false, 'message' => 'Service non trouvé dans vos favoris']);
    }
}
