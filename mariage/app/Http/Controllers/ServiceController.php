<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\CategoryService;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{


    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;

    }

    /**
     * Afficher tous les services.
     */
    public function index()
    {
        $data = $this->serviceService->getAllServices();
        $services = $data['services'];
        $categories = $data['categories'];
        $villes = $data['villes'];
        // dd($villes) ;
        // Retourner la vue avec les résultats
        return view('pages.home', compact('services', 'categories', 'villes'));


    }

    /**
     * @param  $category
     * @return \Illuminate\Http\JsonResponse
     */

    public function getServicesByCategory($id)
    {
        $data = $this->serviceService->getAllServices();
        $categories = $data['categories'];
        $villes = $data['villes'];
        $services = $this->serviceService->getServiceByCategory($id) ;
        return view('services.serviceByCategory', compact('services', 'categories', 'villes'));
    }
    public function getServicesByVille($id)
    {
        $services = $this->serviceService->getServiceByVille($id) ;
        return view('services.serviceByCategory', compact('services'));
    }

    public function search(Request $request)
    {
        // Récupérer les paramètres de recherche
        $categoryId = $request->input('category_id');
        $villeId = $request->input('ville_id');
       // dd("hello");
        // Utiliser le se$data)rvice pour effectuer la recherche
        $data = $this->serviceService->searchServices($categoryId, $villeId);
        $services = $data['services'];
        $categories = $data['categories'];
        $villes = $data['villes'];

        return view('services.serviceByCategory', compact('services', 'categories', 'villes'));
    }

    /**
     * Afficher un service spécifique.
     */
    public function show($id)
    {
        // Récupérer le service avec toutes ses relations
        $service = $this->serviceService->getServiceById($id);
   // dd($service);
        // Retourner la vue avec le service
        return view('services.show', compact('service'));
    }


    public function store(Request $request)
    {
        $this->authorize('create', Service::class);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'ville_id'    => 'required|exists:villes,id',
        ]);


        if ($request->hasFile('cover_image')) {
            $coverImageName = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('images/services'), $coverImageName);
        } else {
            $coverImageName = null;
        }


        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $galleryImageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/services/gallery'), $galleryImageName);
                $gallery[] = $galleryImageName;
            }
        }

        // Enregistrement du service
        $service = $this->serviceService->createService([
            'title'        => $validated['title'],
            'description'  => $validated['description'] ?? null,
            'price'        => $validated['price'],
            'cover_image'  => $coverImageName,
            'gallery'      => $gallery ? json_encode($gallery) : null,
            'category_id'  => $validated['category_id'],
            'ville_id'     => $validated['ville_id'],
            'user_id'      => auth()->id(),
            'status'       => 'pending',
        ]);
           //dd($service);
     //   return response()->json($service, 201);
        return redirect()->route('prestataire.services')->with('success', 'Service ajouté avec succès !');

    }







    public function update(Request $request, $id)
    {
        // Récupérer le service
        $service = $this->serviceService->getServiceById($id);

        // Vérifie si l'utilisateur est autorisé à modifier ce service
        $this->authorize('update', $service);

        // Validation des données envoyées par le formulaire
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric',
            'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // fichier image
            'gallery.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // chaque fichier de la galerie
            'category_id' => 'sometimes|required|exists:categories,id',
            'ville_id'    => 'sometimes|required|exists:villes,id',
        ]);

        // Si une nouvelle image de couverture est envoyée
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageName = time() . '_cover_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('images/services'), $coverImageName);
            $validated['cover_image'] = $coverImageName;
        }

        // Si une ou plusieurs nouvelles images de galerie sont envoyées
        if ($request->hasFile('gallery')) {
            $galleryImages = [];
            foreach ($request->file('gallery') as $image) {
                $galleryImageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/services/gallery'), $galleryImageName);
                $galleryImages[] = $galleryImageName;
            }
            // Stocke la galerie comme JSON dans la base
            $validated['gallery'] = json_encode($galleryImages);
        }

        // Mise à jour du service avec les nouvelles données
        $this->serviceService->updateService($id, $validated);

        // Redirection après la mise à jour avec un message de succès
        return redirect()->route('prestataire.services')->with('success', 'Service mis à jour avec succès');
    }


    public function destroy($id)
    {
        $service = $this->serviceService->getServiceById($id);
        $this->authorize('delete', $service);

        $this->serviceService->deleteService($id);
        return response()->json(['message' => 'Service supprimé avec succès'], 200);
    }


    //////////////  manage admin
    ///

    public function manage(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,archived',
        ]);

        $service = $this->serviceService->getServiceById($id);

        // Vérifie si l'utilisateur a l'autorisation de gérer le statut
        $this->authorize('manage', $service);

        // Mise à jour du statut
        $service->update(['status' => $request->status]);

        return redirect()->route('admin.manage_services')->with('success', 'services modifiée avec succès');
    }


    public function adminIndex()
    {
        $services = Service::with(['category', 'user', 'ville'])
            ->orderByDesc('created_at') // Tri décroissant
            ->get();

        return view('admin.manage_services', compact('services'));
    }

    public function myServices()
    {
        $user = auth()->user();


        $services = $this->serviceService->myServicesPrestataire($user);

        // Passe la variable $services à la vue
        return view('prestataire.services', compact('services'));
    }
    public function archive($id)
    {
        $this->serviceService->archive($id);
        return response()->json(['message' => 'Service archivé avec succès']);
    }

    public function desarchive($id)
    {
        $this->serviceService->desarchive($id);
        return response()->json(['message' => 'Service désarchivé avec succès']);
    }


    public function edit($id)
    {
      //  $this->authorize('update', $service);
        $data = $this->serviceService->editService($id);
        // data contient allcartegory + allVIlle + service a modifier
        $service = $data['service'];
        $categories = $data['categories'];
        $villes = $data['villes'];


        return view('prestataire.edit_service', compact('service' , 'categories' , 'villes'));
    }

    public function create()
    {
        //  $this->authorize('update', $service);
        $data = $this->serviceService->createViewService();
        // data contient allcartegory + allVIlle + service a modifier

        $categories = $data['categories'];
        $villes = $data['villes'];
        return view('prestataire.add_service', compact( 'categories' , 'villes'));

    }


}
